<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatbotUsuario;
use App\Models\ChatbotAtendimento;
use App\Models\ChatbotInteracaoUsuario;
use App\Models\ChatbotInteracaoChat;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Retorna estatísticas simples para a dashboard.
     * Parâmetros opcionais: days (int) periodo em dias (default 30)
     */
    public function stats(Request $request)
    {
        $days = (int) $request->query('days', 30);
        $to = Carbon::now();
        $from = Carbon::now()->subDays($days)->startOfDay();

        // contacts over time (group by date) - tenta usar created_at de chatbot_usuario
        $contactsOverTime = ChatbotUsuario::selectRaw("DATE(created_at) as date, count(*) as count")
            ->whereBetween('created_at', [$from, $to])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($row) {
                return ['date' => $row->date, 'count' => (int) $row->count];
            });

        // total contacts in period
        $totalContacts = ChatbotUsuario::whereBetween('created_at', [$from, $to])->count();

        // companies: contamos números únicos que possuem campo CNPJ no atendimento
        $companies = ChatbotAtendimento::where('nome_campo', 'CNPJ')
            ->whereBetween('created_at', [$from, $to])
            ->selectRaw('count(DISTINCT numero) as cnt')
            ->first();

        $companiesCount = $companies ? (int) $companies->cnt : 0;
        $individualsCount = max(0, $totalContacts - $companiesCount);

        // interactions: open vs finalized
        // Open: interacoes aguardando = 1
        $openInteractions = ChatbotInteracaoUsuario::where('aguardando', 1)->count();
        // finalized: total distinct interactions (id_usuario) - open
        $totalInteractions = ChatbotInteracaoUsuario::distinct('id_usuario')->count('id_usuario');
        $finalizedInteractions = max(0, $totalInteractions - $openInteractions);

        // messages counts (total messages in period)
        $messagesTotal = ChatbotInteracaoChat::whereBetween('created_at', [$from, $to])->count();

        return response()->json([
            'contacts_over_time' => $contactsOverTime,
            'total_contacts' => $totalContacts,
            'companies' => $companiesCount,
            'individuals' => $individualsCount,
            'interactions' => [
                'open' => (int) $openInteractions,
                'finalized' => (int) $finalizedInteractions,
                'total' => (int) $totalInteractions,
            ],
            'messages_total' => (int) $messagesTotal,
        ]);
    }
}
