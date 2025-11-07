import { useState } from 'react';

export default function ChatInput({ onSend, sending = false }) {
  const [text, setText] = useState('');

  function submit(e) {
    e.preventDefault();
    const trimmed = text.trim();
    if (!trimmed || sending) return;
    onSend(trimmed);
    setText('');
  }

  return (
    <form onSubmit={submit} className="p-3 border-t border-gray-200 flex gap-2 items-center">
      <input
        value={text}
        onChange={(e) => setText(e.target.value)}
        className="flex-1 rounded-md border-gray-300 shadow-sm px-3 py-2 focus:outline-none"
        placeholder="Escreva uma mensagem..."
        disabled={sending}
      />
      <button
  className={`px-4 py-2 rounded-md ${sending ? 'bg-gray-300 text-gray-700' : 'bg-primary text-white'}`}
        type="submit"
        disabled={sending}
      >
        {sending ? (
          <div className="flex items-center gap-2">
            <div className="h-4 w-4 border-2 border-t-primary-600 border-gray-200 rounded-full animate-spin" />
            <span className="text-sm">Enviando...</span>
          </div>
        ) : (
          'Enviar'
        )}
      </button>
    </form>
  );
}
