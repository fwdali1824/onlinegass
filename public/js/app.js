if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/firebase-messaging-sw.js')
        .then(function (registration) {
            console.log('Service Worker Registered', registration);
        }).catch(function (err) {
            console.error('Service Worker Registration Failed', err);
        });
}
