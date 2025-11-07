import { useState, useMemo } from 'react';

function getDayGroupLabel(contact) {
  // tenta pegar o tempo da última mensagem (campo messages[].time) ou usa lastMessage
  const last = (contact.messages && contact.messages.length)
    ? contact.messages[contact.messages.length - 1].time
    : contact.lastMessage || '';

  if (!last) return 'Anteriores';

  const lc = String(last).toLowerCase();
  // padrões simples: 'hoje', 'ontem' ou hora '09:15' => hoje
  if (lc.includes('hoje') || /^\d{1,2}:\d{2}$/.test(lc)) return 'Hoje';
  if (lc.includes('ontem')) return 'Ontem';
  return 'Anteriores';
}

function getTimestamp(contact) {
  // Prioriza lastAt (vindo do backend). Depois tenta messages[].time heurístico.
  const tryParse = (val) => {
    if (!val) return NaN;
    // se for ISO ou formato completo, Date.parse funciona
    const p = Date.parse(val);
    if (!isNaN(p)) return p;
    const s = String(val).trim().toLowerCase();
    // hora '09:15' -> hoje às 09:15
    const hhmm = s.match(/^(\d{1,2}):(\d{2})$/);
    if (hhmm) {
      const now = new Date();
      now.setHours(parseInt(hhmm[1], 10), parseInt(hhmm[2], 10), 0, 0);
      return now.getTime();
    }
    if (s.includes('hoje')) return Date.now();
    if (s.includes('ontem')) {
      const d = new Date();
      d.setDate(d.getDate() - 1);
      return d.getTime();
    }
    return NaN;
  };

  if (contact.lastAt) {
    const p = tryParse(contact.lastAt);
    if (!isNaN(p)) return p;
  }

  // fallback para última mensagem
  const last = (contact.messages && contact.messages.length) ? contact.messages[contact.messages.length - 1].time : contact.lastMessage;
  const p2 = tryParse(last);
  if (!isNaN(p2)) return p2;

  return 0;
}

export default function ContactList({ contacts = [], selectedId, onSelect, groups = null }) {
  const [query, setQuery] = useState('');

  const filtered = useMemo(() => {
    const f = contacts.filter((c) =>
      c.name.toLowerCase().includes(query.toLowerCase()) ||
      (c.lastMessage || '').toLowerCase().includes(query.toLowerCase())
    );
    // ordenar por lastAt (mais recente primeiro)
    return f.sort((a, b) => getTimestamp(b) - getTimestamp(a));
  }, [contacts, query]);

  const grouped = useMemo(() => {
    // if backend already provided groups, ignore local grouping
    if (groups && Array.isArray(groups) && groups.length) return null;

    const g = { Hoje: [], Ontem: [], Anteriores: [] };
    filtered.forEach((c) => {
      const label = getDayGroupLabel(c);
      if (!g[label]) g[label] = [];
      g[label].push(c);
    });
    return g;
  }, [filtered, groups]);

  const order = ['Hoje', 'Ontem', 'Anteriores'];

  return (
    <div className="w-full md:w-80 border-gray-200 h-full flex flex-col md:border-r md:border-b-0 border-b">
      <div className="p-4">
        <input
          className="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
          placeholder="Pesquisar contatos"
          value={query}
          onChange={(e) => setQuery(e.target.value)}
        />
      </div>

      <div className="overflow-y-auto flex-1">
        {/* if backend provided groups, render them directly */}
        {groups && Array.isArray(groups) && groups.length ? (
          groups.map((section) => (
            <div key={section.key} className="pb-3">
              <div className="px-4 py-2 text-xs font-semibold text-gray-500 uppercase">{section.label}</div>
              {section.items.map((c) => (
                <button
                  key={c['id']}
                  onClick={() => onSelect(c['id'])}
                  className={`w-full text-left p-4 hover:bg-gray-50 flex items-start gap-3 ${
                    selectedId === c['id'] ? 'bg-gray-100' : ''
                  }`}
                >
                  <div className="w-10 h-10 rounded-full bg-indigo-200 flex items-center justify-center text-white font-semibold">
                    {String(c['name']).split(' ').map((s) => s[0]).slice(0,2).join('')}
                  </div>
                  <div className="flex-1">
                    <div className="flex justify-between items-center">
                      <div className="font-medium text-sm">{c['name']}</div>
                      {c['unread'] > 0 && (
                        <div className="text-xs bg-red-500 text-white rounded-full px-2 py-0.5">{c['unread']}</div>
                      )}
                    </div>
                    <div className="text-xs text-gray-500 truncate">{c['lastMessage']}</div>
                  </div>
                </button>
              ))}
            </div>
          ))
        ) : (
          order.map((section) => (
            (grouped[section] && grouped[section].length > 0) ? (
              <div key={section} className="pb-3">
                <div className="px-4 py-2 text-xs font-semibold text-gray-500 uppercase">{section}</div>
                {grouped[section].map((c) => (
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
            ) : null
          ))
        )}
      </div>
    </div>
  );
}
