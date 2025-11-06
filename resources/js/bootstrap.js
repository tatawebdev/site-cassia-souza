import axios from 'axios';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// --- Firebase Cloud Messaging (FCM) setup (web) ---
// Uses firebase compat build; add VITE_FIREBASE_VAPID_KEY to your .env for the public VAPID key
import firebase from 'firebase/compat/app';
import 'firebase/compat/messaging';

const firebaseConfig = {
    apiKey: "AIzaSyDC_juTBl65iSz_TZsjYQEtUyIRURLQap0",
    authDomain: "chat-cassia-souza-adv.firebaseapp.com",
    projectId: "chat-cassia-souza-adv",
    storageBucket: "chat-cassia-souza-adv.appspot.com",
    messagingSenderId: "969461920153",
    appId: "1:969461920153:web:89874b4322d96f77eda308",
    measurementId: "G-DMYW90V0D7"
};

if (!firebase.apps.length) {
    firebase.initializeApp(firebaseConfig);
}

const messaging = firebase.messaging();

async function registerFCM() {
    if (!('serviceWorker' in navigator) || !('Notification' in window)) {
        console.log('FCM not supported in this browser.');
        return;
    }

    try {
        // Ensure service worker from public/ is registered
        const registration = await navigator.serviceWorker.register('/firebase-messaging-sw.js');
        console.log('Service Worker registered for FCM:', registration);

        // Request notification permission
        const permission = await Notification.requestPermission();
        if (permission !== 'granted') {
            console.log('Notification permission not granted.');
            return;
        }

        const vapidKey = import.meta.env.VITE_FIREBASE_VAPID_KEY || 'REPLACE_WITH_VAPID_KEY';

        const isValidVapid = typeof vapidKey === 'string' && vapidKey.length > 20 && /^[A-Za-z0-9\-_]+=*$/.test(vapidKey) && vapidKey !== 'REPLACE_WITH_VAPID_KEY';
        if (!isValidVapid) {
            console.error('VAPID key inválida ou não configurada. Defina VITE_FIREBASE_VAPID_KEY no seu .env com o "public VAPID key" (Console Firebase → Cloud Messaging → Web configuration).');
            return;
        }

        // Ensure the service worker is active and controlled before subscribing
        const readyRegistration = await navigator.serviceWorker.ready;
        const currentToken = await messaging.getToken({ vapidKey, serviceWorkerRegistration: readyRegistration });

        console.log('FCM token:', currentToken);

        if (currentToken) {
            // Envia o token ao backend para persistência (rota: POST /api/fcm/token)
            try {
                await axios.post('/api/fcm/token', { token: currentToken });
                console.log('FCM token enviado ao backend');
            } catch (err) {
                console.error('Erro ao enviar token FCM ao backend', err);
            }
        }
    } catch (err) {
        console.error('Error registering FCM:', err);
    }
}

// Try to register on load (only in browsers)
if (typeof window !== 'undefined') {
    registerFCM();
}

// Handle foreground messages and notify app UI via a CustomEvent
if (typeof window !== 'undefined') {
    messaging.onMessage(function (payload) {
        console.log('FCM foreground message received: ', payload);
        try {
            const event = new CustomEvent('fcm-message', { detail: payload });
            window.dispatchEvent(event);
        } catch (e) {
            console.error('Error dispatching fcm-message event', e);
        }
    });
}

// Listen for messages posted from the Service Worker (background messages)
if (typeof navigator !== 'undefined' && 'serviceWorker' in navigator) {
    try {
        navigator.serviceWorker.addEventListener('message', function (event) {
            // The SW posts { type: 'fcm-message', payload }
            const data = event.data;
            if (!data) return;
            if (data.type === 'fcm-message') {
                console.log('Received fcm-message from service worker', data.payload);
                try {
                    const customEvent = new CustomEvent('fcm-message', { detail: data.payload });
                    window.dispatchEvent(customEvent);
                } catch (e) {
                    console.error('Error dispatching fcm-message from SW', e);
                }
            }
        });
    } catch (e) {
        console.error('Error adding serviceWorker message listener', e);
    }
}
