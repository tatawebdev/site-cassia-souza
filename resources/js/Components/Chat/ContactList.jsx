import { useState } from 'react';

export default function ContactList({ contacts = [], selectedId, onSelect }) {
  const [query, setQuery] = useState('');

  const filtered = contacts.filter((c) =>
    c.name.toLowerCase().includes(query.toLowerCase()) ||
    (c.lastMessage || '').toLowerCase().includes(query.toLowerCase())
  );

  return (
    <div className="w-80 border-r border-gray-200 h-full flex flex-col">
      <div className="p-4">
        <input
          className="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
          placeholder="Pesquisar contatos"
          value={query}
          onChange={(e) => setQuery(e.target.value)}
        />
      </div>

      <div className="overflow-y-auto flex-1">
        {filtered.map((c) => (
          <button
            key={c.id}
            onClick={() => onSelect(c.id)}
            className={`w-full text-left p-4 hover:bg-gray-50 flex items-start gap-3 ${
              selectedId === c.id ? 'bg-gray-100' : ''
            }`}
          >
            <div className="w-10 h-10 rounded-full bg-indigo-200 flex items-center justify-center text-white font-semibold">
              {c.name.split(' ').map((s) => s[0]).slice(0,2).join('')}
            </div>
            <div className="flex-1">
              <div className="flex justify-between items-center">
                <div className="font-medium text-sm">{c.name}</div>
                {c.unread > 0 && (
                  <div className="text-xs bg-red-500 text-white rounded-full px-2 py-0.5">{c.unread}</div>
                )}
              </div>
              <div className="text-xs text-gray-500 truncate">{c.lastMessage}</div>
            </div>
          </button>
        ))}
      </div>
    </div>
  );
}
