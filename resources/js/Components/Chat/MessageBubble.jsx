import { User, Cpu, MessageSquare } from 'lucide-react';

export default function MessageBubble({ message }) {
  const isMe = message.from === 'me';
  const isBot = message.from === 'bot';

  const Icon = isBot ? Cpu : (isMe ? User : MessageSquare);

  return (
    <div className={`flex ${isMe ? 'justify-end' : 'justify-start'} mb-2`}> 
      <div className={`${isMe ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-800'} max-w-xs p-3 rounded-lg flex items-end gap-2`}> 
        {/* ícone à esquerda para outros, à direita para 'me' */}
        {!isMe && (
          <div className="flex-shrink-0 mt-0">
            <Icon size={18} className={`${isBot ? 'text-white/80' : 'text-gray-500'}`} />
          </div>
        )}

        <div className="flex-1">
          <div className="text-sm">{message.text}</div>
          <div className={`text-xs mt-1 ${isMe ? 'text-indigo-100' : 'text-gray-500'}`}>{message.time}</div>
        </div>

        {isMe && (
          <div className="flex-shrink-0">
            <Icon size={18} className="text-indigo-100" />
          </div>
        )}
      </div>
    </div>
  );
}
