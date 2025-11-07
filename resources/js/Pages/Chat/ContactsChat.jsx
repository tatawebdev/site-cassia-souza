import { useState, useEffect } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import ContactList from '@/Components/Chat/ContactList';
import ChatWindow from '@/Components/Chat/ChatWindow';
import { contacts as initialContacts } from '@/data/mockChat';

export default function ContactsChat() {
  const [contacts, setContacts] = useState(initialContacts.map((c) => ({ ...c })));
  const [selectedId, setSelectedId] = useState(null);
  const [loadingContacts, setLoadingContacts] = useState(true);
  const [loadingMessagesFor, setLoadingMessagesFor] = useState(null);
  const [groups, setGroups] = useState(null);
  const [sendingFor, setSendingFor] = useState(null);

  function handleSelect(id) {
    setSelectedId(id);
    // mark as read locally
    setContacts((prev) => prev.map((c) => (c.id === id ? { ...c, unread: 0 } : c)));

    // if messages not loaded, fetch from API
    const contact = contacts.find((c) => c.id === id);
    if (!contact) return;
    if (!contact.messages || contact.messages.length === 0) {
      fetchMessages(id);
    }
    // on mobile, switch to chat view after selecting
    if (isMobile) setShowList(false);
  }

  function handleSend(text) {
    if (!selectedId) return;

    const contact = contacts.find((c) => c.id === selectedId);
    if (!contact) return;


    setSendingFor(selectedId);

    window.axios.post(route('chat.api.storeMessage'), {
      usuario_id: contact.id,
      mensagem: text,
      remetente: 'me',
    }).then(() => {
      setSendingFor(null);
    }).catch((err) => {
      setSendingFor(null);
      console.error('Erro ao enviar mensagem', err);
    });
  }
  const selected = contacts.find((c) => c.id === selectedId) || null;

  const [isMobile, setIsMobile] = useState(typeof window !== 'undefined' ? window.innerWidth < 768 : false);
  const [showList, setShowList] = useState(true);

  useEffect(() => {
    function onResize() {
      const mobile = window.innerWidth < 768;
      setIsMobile(mobile);
      // when switching to desktop ensure both panes visible
      if (!mobile) setShowList(true);
    }

    window.addEventListener('resize', onResize);
    // init
    onResize();
    return () => window.removeEventListener('resize', onResize);
  }, []);

  useEffect(() => {
    // try carregar contatos da API, cai para mock se falhar
    setLoadingContacts(true);
    window.axios.get(route('chat.api.contacts'))
      .then((res) => {
        // se backend retornar groups, mantemos groups; caso contrário, assume lista plana
        if (res.data && res.data.groups) {
          setGroups(res.data.groups);
          // selecionar primeiro contato do primeiro grupo
          const first = res.data.groups[0]?.items?.[0];
          if (first) setSelectedId((prev) => prev ?? first.id);
          // também preencher contatos plano para compatibilidade
          const flat = res.data.groups.flatMap(g => g.items.map(i => ({ ...i, messages: i.messages || [] })));
          setContacts(flat);
        } else {
          const data = res.data.map((c) => ({ ...c, messages: c.messages || [] }));
          setContacts(data);
          if (data.length > 0) setSelectedId((prev) => prev ?? data[0].id);
        }
      })
      .catch((err) => {
        console.warn('Não foi possível carregar contatos via API, usando mock', err);
        // manter mocks
      })
      .finally(() => setLoadingContacts(false));
  }, []);

  // Handler called by ChatWindow when an incoming message for the open contact arrives
  function handleIncomingMessage(newMsg, usuarioId) {
    setContacts((prev) =>
      prev.map((c) => {
        if (c.id !== usuarioId) return c;
        const msgs = [...(c.messages || []), newMsg];
        return {
          ...c,
          messages: msgs,
          lastMessage: newMsg.text,
          unread: (selectedId === usuarioId) ? 0 : ((c.unread || 0) + 1),
        };
      })
    );
  }

  // When an FCM message arrives for a contact that is NOT currently open,
  // fetch the latest messages for that contact so the UI stays in sync.
  useEffect(() => {
    const recentFetch = { current: {} };

    function handleBackgroundFcm(e) {
      const payload = e.detail || e;
      let data = payload.data || payload;
      if (typeof data === 'string') {
        try { data = JSON.parse(data); } catch (err) { /* ignore */ }
      }
      const usuarioId = data.usuario_id || (data.data && data.data.usuario_id) || data.user_id || data.usuario || null;

      const mensagemText = data.mensagem || (data.data && data.data.mensagem) || data.message || (data.notification && data.notification.body) || '';
      if (!usuarioId) return;



      const now = Date.now();
      const last = recentFetch.current[usuarioId] || 0;
      recentFetch.current[usuarioId] = now;


      const msgId = data.id || data.message_id || Date.now();

      console.log(data)
      setContacts((prev) => prev.map((c) => {
        if (c.id != usuarioId) return c;
        const exists = (c.messages || []).some(m => m.id == msgId);
        if (exists) return c;
        return {
          ...c,
          lastMessage: data.mensagem,
          unread: (c.unread || 0) + 1,
          messages: [
            ...(c.messages || []),
            {
              id: msgId,
              from: data.remetente || 'them',
              text: data.mensagem,
              time: data.time || new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
              type: data.type
            }
          ]
        };
      }));


      fetchMessages(usuarioId);

    }

    window.addEventListener('fcm-message', handleBackgroundFcm);
    return () => window.removeEventListener('fcm-message', handleBackgroundFcm);
  }, [selectedId]);

  function fetchMessages(usuarioId) {
    setLoadingMessagesFor(usuarioId);

    window.axios.get(route('chat.api.messages', { usuario: usuarioId }))
      .then((res) => {

        const msgs = res.data;
        setContacts((prev) => prev.map((c) => c.id !== usuarioId ? c : { ...c, messages: msgs }));
        if (selected?.id === usuarioId) {
          selected.messages = msgs;
        }
      })
      .catch((err) => {
        console.warn('Erro ao buscar mensagens', err);
      })
      .finally(() => setLoadingMessagesFor(null));
  }

  return (
    <AuthenticatedLayout
      header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Chat de Contatos</h2>}
    >
      <Head title="Chat" />

      <div className="py-6">
        <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div className="bg-white shadow-sm sm:rounded-lg overflow-hidden" style={{ height: '70vh' }}>
            <div className="flex h-full flex-col md:flex-row relative">
              {/* Desktop / large screens: side-by-side. Mobile: show either list or chat */}
              {(!isMobile || showList) && (
                <ContactList contacts={contacts} selectedId={selectedId} onSelect={handleSelect} groups={groups} />
              )}

              {(!isMobile) ? (
                <div className="flex-1 h-full">
                  <ChatWindow
                    contact={selected}
                    messages={selected?.messages || []}
                    onReceive={handleIncomingMessage}
                    onSend={handleSend}
                    loading={loadingMessagesFor === selectedId}
                    sending={sendingFor === selectedId}
                    isMobile={false}
                  />
                </div>
              ) : (
                <div className={`flex-1 h-full ${showList ? 'hidden' : 'block'}`}>
                  <ChatWindow
                    contact={selected}
                    messages={selected?.messages || []}
                    onReceive={handleIncomingMessage}
                    onSend={handleSend}
                    loading={loadingMessagesFor === selectedId}
                    sending={sendingFor === selectedId}
                    isMobile={true}
                    onBack={() => setShowList(true)}
                  />
                </div>
              )}

              {/* Floating action button on mobile to open list / new chat */}
              {isMobile && showList && (
                <button
                  type="button"
                  onClick={() => { /* placeholder for new chat action */ }}
                  className="fixed bottom-6 right-6 bg-green-500 shadow-lg text-white rounded-full w-14 h-14 flex items-center justify-center"
                  title="Novo contato"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 4v16m8-8H4" />
                  </svg>
                </button>
              )}
              {/* on mobile when viewing chat show a back button in UI provided by ChatWindow */}
          </div>
        </div>
      </div>
    </div>
    </AuthenticatedLayout>
  );
}
