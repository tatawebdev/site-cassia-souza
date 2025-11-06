import { useEffect, useRef } from 'react';
import MessageBubble from '@/Components/Chat/MessageBubble';
import ChatInput from '@/Components/Chat/ChatInput';

export default function ChatWindow({ contact, messages = [], onSend, loading = false, onReceive }) {
  const bottomRef = useRef(null);

  useEffect(() => {
    bottomRef.current?.scrollIntoView({ behavior: 'smooth' });
  }, [messages, contact]);

  // Listen for incoming FCM messages dispatched as CustomEvent('fcm-message')
  useEffect(() => {
    if (!onReceive) return;

    function handleFcmEvent(e) {
      const payload = e.detail || e;
      let data = payload.data || payload;
      if (typeof data === 'string') {
        try { data = JSON.parse(data); } catch (err) { /* ignore */ }
      }

      const usuarioId = data.usuario_id || (data.data && data.data.usuario_id) || data.user_id || data.usuario || null;
      if (!usuarioId || !contact || usuarioId !== contact.id) return;

      const mensagemText = data.mensagem || (data.data && data.data.mensagem) || data.message || (data.notification && data.notification.body) || '';
      const remetente = data.remetente || (data.data && data.data.remetente) || 'user';
      const messageId = data.id || data.message_id || Date.now();
      const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

      const newMsg = { id: messageId, from: remetente === 'me' ? 'me' : 'other', text: mensagemText, time };

      try {
        onReceive(newMsg, usuarioId);
      } catch (err) {
        console.error('onReceive handler error', err);
      }
    }

    window.addEventListener('fcm-message', handleFcmEvent);
    return () => window.removeEventListener('fcm-message', handleFcmEvent);
  }, [onReceive, contact]);

  if (!contact) {
    return (
      <div className="flex-1 flex items-center justify-center">
        <div className="text-gray-500">Selecione um contato para iniciar a conversa</div>
      </div>
    );
  }

  return (
    <div className="flex-1 flex flex-col h-full">
      <div className="p-4 border-b border-gray-200 flex items-center gap-3">
        <div className="w-10 h-10 rounded-full bg-indigo-200 flex items-center justify-center text-white font-semibold">
          {contact.name.split(' ').map((s) => s[0]).slice(0,2).join('')}
        </div>
        <div>
          <div className="font-medium">{contact.name}</div>
          <div className="text-xs text-gray-500">{contact.lastMessage}</div>
        </div>
      </div>

      <div className="p-4 overflow-y-auto flex-1 relative">
        {loading && (
          <div className="absolute inset-0 flex items-center justify-center bg-white/60 z-10">
            <div className="flex flex-col items-center gap-2">
              <div className="h-8 w-8 border-4 border-t-indigo-600 border-gray-200 rounded-full animate-spin" />
              <div className="text-sm text-gray-600">Carregando mensagens...</div>
            </div>
          </div>
        )}

        {!loading && (!messages || messages.length === 0) ? (
          <div className="h-full flex items-center justify-center text-gray-500">
            <div className="text-center">
              <div className="mb-2">Nenhuma mensagem ainda</div>
              <div className="text-xs">Envie a primeira mensagem para iniciar a conversa.</div>
            </div>
          </div>
        ) : (
          messages.map((m) => (
            <MessageBubble key={m.id} message={m} />
          ))
        )}
        <div ref={bottomRef} />
      </div>

      <ChatInput onSend={onSend} />
    </div>
  );
}
