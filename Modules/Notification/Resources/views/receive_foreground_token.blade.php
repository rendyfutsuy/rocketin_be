<html>
<title>Firebase Messaging Demo</title>
<style>
    div {
        margin-bottom: 15px;
    }
</style>
<body>
    Foreground Receiver
    <script src="https://www.gstatic.com/firebasejs/7.20.0/firebase-app.js"></script>

    <!-- Add Firebase products that you want to use -->
    <script src="https://www.gstatic.com/firebasejs/7.20.0/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.20.0/firebase-firestore.js"></script>
    
    <script src="https://www.gstatic.com/firebasejs/7.20.0/firebase-messaging.js"></script>

    <script src={{ url("fcm_init.js") }}></script>

    <div id="messages"></div>

    <script>
        const messaging = firebase.messaging();

        messaging.onMessage((payload) => {
                console.log('Message received. ', payload);
                appendMessage(payload);
                const notificationTitle = 'Background Message Title';
                const notificationOptions = {
                    body: 'Background Message body.',
                    icon: '/firebase-logo.png'
                };
                return self.registration.showNotification(notificationTitle,
                    notificationOptions);
            });

        function appendMessage(payload) {
            const messagesElement = document.querySelector('#messages');
            const dataHeaderELement = document.createElement('h5');
            const dataElement = document.createElement('pre');
            dataElement.style = 'overflow-x:hidden;';
            dataHeaderELement.textContent = 'Received message:';
            dataElement.textContent = JSON.stringify(payload, null, 2);
            messagesElement.appendChild(dataHeaderELement);
            messagesElement.appendChild(dataElement);
        }
    </script>
</body>

</html>