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

// Handle background messages
messaging.onBackgroundMessage(function (payload) {
    console.log('Received background message ', payload);

    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: payload.notification.icon
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
    // Also notify any open clients (pages) so they can update UI in real time
    // This helps update chat windows when the app is open (but in background)
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
