import { useState } from 'react';

export default function ChatInput({ onSend }) {
  const [text, setText] = useState('');

  function submit(e) {
    e.preventDefault();
    const trimmed = text.trim();
    if (!trimmed) return;
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
      />
      <button className="bg-indigo-600 text-white px-4 py-2 rounded-md" type="submit">Enviar</button>
    </form>
  );
}
