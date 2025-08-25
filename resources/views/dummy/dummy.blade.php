<!-- Firebase SDK -->
<script src="https://www.gstatic.com/firebasejs/9.6.1/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.6.1/firebase-messaging-compat.js"></script>
<!-- jQuery (Required for Toastr) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Toastr CSS & JS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    const firebaseConfig = {
        apiKey: "AIzaSyC6R77dRxIK2WBOeP_wTs_TLdC_En_Fx3g",
        authDomain: "react-login-6bc23.firebaseapp.com",
        projectId: "react-login-6bc23",
        storageBucket: "react-login-6bc23.appspot.com",
        messagingSenderId: "463371952850",
        appId: "1:463371952850:web:640e50c51548d09654430b"
    };

    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();

    // Register Service Worker first
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/firebase-messaging-sw.js')
            .then(function(registration) {
                console.log('Service Worker registered');

                messaging.getToken({
                    vapidKey: "BKCzxZHpWy8RIwbNbCrQXhKOU3NS-01nvEX8ywsnpIqr9pW_6b1Y1PMsgj0PtyZszadFtQysGQffpXwEW7wa11c",
                    serviceWorkerRegistration: registration
                }).then(function(token) {
                    if (token) {
                        console.log("FCM Token:", token);

                        // Send token to server
                        fetch("{{ route('store.fcm.token') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                token
                            })
                        });
                    } else {
                        console.warn("No token available");
                    }
                }).catch(function(err) {
                    console.error("Token error:", err);
                });
            }).catch(function(err) {
                console.error('Service Worker registration failed:', err);
            });
    }

    messaging.onMessage((payload) => {

        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 5000
        };

        toastr.success(payload.notification.body, payload.notification.title);
    });


    // Ask for Notification Permission
    Notification.requestPermission().then(function(permission) {
        if (permission !== "granted") {
            alert("Please allow notifications.");
        }
    });

    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/firebase-messaging-sw.js')
            .then((registration) => {
                console.log('Service Worker registered with scope:', registration.scope);
            }).catch((err) => {
                console.error('Service Worker registration failed:', err);
            });
    }
</script>
