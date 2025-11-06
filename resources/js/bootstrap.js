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
		const currentToken = await messaging.getToken({ vapidKey });

		console.log('FCM token:', currentToken);

		if (currentToken) {
			// TODO: enviar token ao backend para associar ao usuário/dispositivo.
			// Ex.: await axios.post('/api/fcm/token', { token: currentToken });
		}
	} catch (err) {
		console.error('Error registering FCM:', err);
	}
}

// Try to register on load (only in browsers)
if (typeof window !== 'undefined') {
	registerFCM();
}
