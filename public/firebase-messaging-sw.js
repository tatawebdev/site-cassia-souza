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
});
