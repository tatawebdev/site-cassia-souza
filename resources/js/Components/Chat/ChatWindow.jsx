import { useEffect, useRef } from 'react';
import MessageBubble from '@/Components/Chat/MessageBubble';
import ChatInput from '@/Components/Chat/ChatInput';

export default function ChatWindow({ contact, messages = [], onSend }) {
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

      <div className="p-4 overflow-y-auto flex-1">
        {messages.map((m) => (
          <MessageBubble key={m.id} message={m} />
        ))}
        <div ref={bottomRef} />
      </div>

      <ChatInput onSend={onSend} />
    </div>
  );
}
