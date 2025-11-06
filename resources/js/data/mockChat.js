export const contacts = [
  {
    id: 1,
    name: 'João Silva',
    avatar: null,
    unread: 2,
    lastMessage: 'Até mais tarde!',
    messages: [
      { id: 1, from: 'contact', text: 'Olá, você tem um minuto?', time: '09:10' },
      { id: 2, from: 'me', text: 'Tenho sim, diga.', time: '09:12' },
      { id: 3, from: 'contact', text: 'Perfeito — até mais tarde!', time: '09:15' },
    ],
  },
  {
    id: 2,
    name: 'Maria Oliveira',
    avatar: null,
    unread: 0,
    lastMessage: 'Obrigado pelo retorno.',
    messages: [
      { id: 1, from: 'contact', text: 'Você pode me encaminhar os documentos?', time: '08:05' },
      { id: 2, from: 'me', text: 'Já enviei por e-mail.', time: '08:10' },
      { id: 3, from: 'contact', text: 'Obrigado pelo retorno.', time: '08:12' },
    ],
  },
  {
    id: 3,
    name: 'Carlos Pereira',
    avatar: null,
    unread: 5,
    lastMessage: 'Pode ligar mais tarde?',
    messages: [
      { id: 1, from: 'contact', text: 'Oi, está disponível?', time: 'Ontem' },
      { id: 2, from: 'contact', text: 'Preciso agendar uma reunião.', time: 'Ontem' },
      { id: 3, from: 'me', text: 'Posso sim — qual horário?', time: 'Ontem' },
      { id: 4, from: 'contact', text: 'Pode ligar mais tarde?', time: 'Hoje' },
    ],
  },
];

export default { contacts };
