export default function MessageBubble({ message }) {
  const isMe = message.from === 'me';
  return (
    <div className={`flex ${isMe ? 'justify-end' : 'justify-start'} mb-2`}> 
      <div className={`${isMe ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-800'} max-w-xs p-3 rounded-lg`}> 
        <div className="text-sm">{message.text}</div>
        <div className={`text-xs mt-1 ${isMe ? 'text-indigo-100' : 'text-gray-500'}`}>{message.time}</div>
      </div>
    </div>
  );
}
