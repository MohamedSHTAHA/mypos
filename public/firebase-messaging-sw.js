// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here, other Firebase libraries
// are not available in the service worker.
importScripts('https://www.gstatic.com/firebasejs/7.18.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.18.0/firebase-messaging.js');

// Initialize the Firebase app in the service worker by passing in
// your app's Firebase config object.
// https://firebase.google.com/docs/web/setup#config-object
// Your web app's Firebase configuration
var firebaseConfig = {
    apiKey: "AIzaSyAE8H8yuIaEkyXWtLkOX0lu8fHoKtmHtuc",
    authDomain: "mypos-e68ee.firebaseapp.com",
    databaseURL: "https://mypos-e68ee.firebaseio.com",
    projectId: "mypos-e68ee",
    storageBucket: "mypos-e68ee.appspot.com",
    messagingSenderId: "203411580144",
    appId: "1:203411580144:web:e5b51c423969d906288e35"
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();


messaging.setBackgroundMessageHandler(function (payload) {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);

    const {
        title,
        body
    } = payload.notification;
    // Customize notification here
    //const notificationTitle = 'Background Message Title';
    const notificationOptions = {
        body,
        //icon: '/firebase-logo.png'
    };

    return self.registration.showNotification(notificationTitle,
        notificationOptions);
});
