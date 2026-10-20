// Versão nova assume na hora, sem esperar o visitante fechar todas as abas do
// site (senão a antiga continua recebendo os avisos e pode não saber mostrá-los).
self.addEventListener('install', function () {
    self.skipWaiting();
});
self.addEventListener('activate', function (event) {
    event.waitUntil(self.clients.claim());
});

// Avisos de artigos (só dados, ver FcmService): este worker mostra a notificação
// sempre, mesmo com uma aba do site aberta. Registrado antes do SDK do Firebase,
// que só repassa mensagens de dados para a página e não exibe nada.
self.addEventListener('push', function (event) {
    var dados;
    try {
        dados = (event.data && event.data.json().data) || {};
    } catch (e) {
        return;
    }
    if (!dados.aviso_titulo) return;

    event.waitUntil(self.registration.showNotification(dados.aviso_titulo, {
        body: dados.aviso_texto || '',
        icon: '/favicon-192x192.png',
        badge: '/favicon-96x96.png',
        tag: dados.aviso_link,
        data: { link: dados.aviso_link }
    }));
});

self.addEventListener('notificationclick', function (event) {
    var link = event.notification.data && event.notification.data.link;
    if (!link) return;
    event.notification.close();
    event.waitUntil(self.clients.openWindow(link));
});

importScripts('https://www.gstatic.com/firebasejs/10.5.2/firebase-app-compat.js')
importScripts('https://www.gstatic.com/firebasejs/10.5.2/firebase-messaging-compat.js')

// Initialize Firebase in the service worker
firebase.initializeApp({
    apiKey: "AIzaSyDC_juTBl65iSz_TZsjYQEtUyIRURLQap0",
    authDomain: "chat-cassia-souza-adv.firebaseapp.com",
    projectId: "chat-cassia-souza-adv",
    storageBucket: "chat-cassia-souza-adv.appspot.com",
    messagingSenderId: "969461920153",
    appId: "1:969461920153:web:89874b4322d96f77eda308",
    measurementId: "G-DMYW90V0D7"
});

const messaging = firebase.messaging();

// Quando o Chrome troca a inscrição de push (pushsubscriptionchange), o SDK tenta
// apagar o token usando o registro do worker, que aqui fica vazio até alguém
// chamar getToken: dava "Cannot read properties of undefined (reading
// 'pushManager')". Entregamos o registro de antemão. O token novo é gravado pela
// página (renovação diária e nova tentativa quando o site responde 410).
try {
    (messaging._delegate || messaging).swRegistration = self.registration;
} catch (e) {
    console.error('Erro ao preparar o registro do FCM no worker', e);
}

// Mensagens do chat (com "notification"): o próprio SDK mostra quando não há aba
// em foco. Aqui só repassamos às abas abertas para o painel se atualizar.
messaging.onBackgroundMessage(function (payload) {
    try {
        self.clients.matchAll({ includeUncontrolled: true, type: 'window' }).then(function (clients) {
            for (const client of clients) {
                client.postMessage({ type: 'fcm-message', payload });
            }
        });
    } catch (e) {
        console.error('Error posting message to clients from SW', e);
    }
});
