<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatbotUsuario;
use App\Models\ChatbotInteracaoChat;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ChatController extends Controller
{

    /**
     * Retorna lista de contatos com última mensagem e contagem de não lidos.
     */
    public function contacts()
    {
        $users = ChatbotUsuario::orderBy('ultima_conversa', 'desc')->get();

        // montar lista com lastAt (Carbon) e agrupar por dia
        $items = $users->map(function ($u) {
            $lastInteraction = ChatbotInteracaoChat::where('usuario_id', $u->id)
                ->orderBy('data_envio', 'desc')
                ->first();

            $lastMessage = $lastInteraction ? $lastInteraction->mensagem : ($u->ultima_mensagem ? $u->ultima_mensagem->toDateTimeString() : '');

            $lastAt = null;
            if ($lastInteraction && $lastInteraction->data_envio) {
                $lastAt = Carbon::parse($lastInteraction->data_envio);
            } elseif ($u->ultima_conversa) {
                $lastAt = Carbon::parse($u->ultima_conversa);
            }

            $unread = ChatbotInteracaoChat::where('usuario_id', $u->id)
                ->where('remetente', 'contact')
                ->whereNull('data_visualizacao')
                ->count();

            return [
                'id' => $u->id,
                'name' => $u->nome,
                'telefone' => $u->telefone,
                'lastMessage' => $lastMessage,
                // lastAt em ISO 8601 com timezone de São Paulo
                'lastAt' => $lastAt ? $lastAt->setTimezone('America/Sao_Paulo')->toIso8601String() : null,
                'lastAtDate' => $lastAt ? $lastAt->toDateString() : null, // Y-m-d
                'lastAtTimestamp' => $lastAt ? $lastAt->timestamp : null,
                'unread' => $unread,
            ];
        })->filter();

        // agrupar por data (Y-m-d)
        $groups = [];
        foreach ($items as $it) {
            $key = $it['lastAtDate'] ?? 'sem-data';
            if (!isset($groups[$key]))
                $groups[$key] = [];
            $groups[$key][] = $it;
        }

        // ordenar keys desc
        $keys = array_keys($groups);
        usort($keys, function ($a, $b) {
            if ($a === 'sem-data')
                return 1;
            if ($b === 'sem-data')
                return -1;
            return strcmp($b, $a);
        });

        // transformar em array de grupos com label formatado em PT-BR (ex: '6 DE NOV.')
        $months = ['JAN', 'FEV', 'MAR', 'ABR', 'MAI', 'JUN', 'JUL', 'AGO', 'SET', 'OUT', 'NOV', 'DEZ'];
        $groupsOut = [];
        foreach ($keys as $k) {
            if ($k === 'sem-data') {
                $label = 'Sem data';
            } else {
                $d = Carbon::createFromFormat('Y-m-d', $k);
                $day = $d->day;
                $month = $months[$d->month - 1] ?? strtoupper($d->format('M'));
                $label = sprintf('%d DE %s.', $day, $month);
            }
            $groupsOut[] = [
                'key' => $k,
                'label' => $label,
                'items' => $groups[$k],
            ];
        }

        return response()->json(['groups' => $groupsOut]);
    }

    /**
     * Retorna mensagens de um usuário ordenadas cronologicamente.
     */
    public function messages($usuarioId)
    {
        $msgs = ChatbotInteracaoChat::where('usuario_id', $usuarioId)
            ->orderBy('data_envio', 'asc')
            ->get();

        $result = $msgs->map(function ($m) {
            return [
                'id' => $m->id,
                'from' => in_array($m->remetente, ['me', 'agent', 'system', 'bot']) ? 'me' : 'contact',
                'text' => $m->mensagem,
                'time' => $m->data_envio ? $m->data_envio->toDateTimeString() : null,
                'status' => $m->status_mensagem,
            ];
        });

        return response()->json($result);
    }

    /**
     * Armazena uma nova mensagem (remetente pode ser 'me' ou 'contact').
     * Se for passado telefone e não existir usuário, cria com addUserIfNotExists.
     */
    public function storeMessage(Request $request)
    {
        $data = $request->validate([
            'usuario_id' => 'nullable|integer|exists:chatbot_usuario,id',
            'telefone' => 'nullable|string',
            'nome' => 'nullable|string',
            'mensagem' => 'required|string',
            'remetente' => 'nullable|string|in:me,contact,bot,system,agent',
        ]);

        $usuario = null;
        if (!empty($data['usuario_id'])) {
            $usuario = ChatbotUsuario::find($data['usuario_id']);
        } elseif (!empty($data['telefone'])) {
            $usuario = ChatbotUsuario::addUserIfNotExists($data['telefone'], $data['nome'] ?? null);
        }

        if (!$usuario) {
            return response()->json(['error' => 'usuario_id ou telefone é requerido'], 422);
        }

        $remetente = $data['remetente'] ?? 'me';

        $msg = ChatbotInteracaoChat::create([
            'usuario_id' => $usuario->id,
            'mensagem' => $data['mensagem'],
            'remetente' => $remetente,
            'status_mensagem' => 'sent',
            'data_envio' => now(),
            'data' => now(),
            'message_id' => uniqid('msg_'),
        ]);



        if ($remetente === 'me' && $usuario->telefone) {
            app(\App\Services\WhatsAppService::class)
                ->sendMessageText($usuario->telefone, $data['mensagem']);
dd($usuario->telefone);
        }


        // atualiza timestamps do usuario
        $usuario->ultima_mensagem = now();
        $usuario->ultima_conversa = now();
        $usuario->save();

        return response()->json([
            'message' => 'ok',
            'data' => [
                'id' => $msg->id,
                'usuario_id' => $usuario->id,
                'text' => $msg->mensagem,
                'from' => $remetente,
                'time' => $msg->data_envio->toDateTimeString(),
            ],
        ], 201);
    }

}
