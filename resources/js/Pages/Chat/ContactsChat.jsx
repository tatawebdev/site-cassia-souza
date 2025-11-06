import { useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import ContactList from '@/Components/Chat/ContactList';
import ChatWindow from '@/Components/Chat/ChatWindow';
import { contacts as initialContacts } from '@/data/mockChat';

export default function ContactsChat() {
  const [contacts, setContacts] = useState(initialContacts.map((c) => ({ ...c })));
  const [selectedId, setSelectedId] = useState(contacts[0]?.id ?? null);

  function handleSelect(id) {
    setSelectedId(id);
    // optional: mark as read in the mocked data
    setContacts((prev) => prev.map((c) => (c.id === id ? { ...c, unread: 0 } : c)));
  }

  function handleSend(text) {
    if (!selectedId) return;
    const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    setContacts((prev) =>
      prev.map((c) => {
        if (c.id !== selectedId) return c;
        const nextId = (c.messages[c.messages.length - 1]?.id || 0) + 1;
        const newMsg = { id: nextId, from: 'me', text, time };
        return { ...c, messages: [...c.messages, newMsg], lastMessage: text };
      })
    );
  }

  const selected = contacts.find((c) => c.id === selectedId) || null;

  return (
    <AuthenticatedLayout
      header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Chat de Contatos</h2>}
    >
      <Head title="Chat" />

      <div className="py-6">
        <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div className="bg-white shadow-sm sm:rounded-lg overflow-hidden" style={{ height: '70vh' }}>
            <div className="flex h-full">
              <ContactList contacts={contacts} selectedId={selectedId} onSelect={handleSelect} />
              <div className="flex-1 h-full">
                <ChatWindow contact={selected} messages={selected?.messages || []} onSend={handleSend} />
              </div>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
