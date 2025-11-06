import { useEffect, useRef } from 'react';
import MessageBubble from '@/Components/Chat/MessageBubble';
import ChatInput from '@/Components/Chat/ChatInput';

export default function ChatWindow({ contact, messages = [], onSend, loading = false }) {
  const bottomRef = useRef(null);

  useEffect(() => {
    bottomRef.current?.scrollIntoView({ behavior: 'smooth' });
  }, [messages, contact]);

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

        {messages.map((m) => (
          <MessageBubble key={m.id} message={m} />
        ))}
        <div ref={bottomRef} />
      </div>

      <ChatInput onSend={onSend} />
    </div>
  );
}
