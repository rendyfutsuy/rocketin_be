<html>
<title>Firebase Messaging Demo</title>
<style>
    div {
        margin-bottom: 15px;
    }
</style>
<body>
    <div id="token"></div>
    <div id="msg"></div>
    <div id="notis"></div>
    <div id="err"></div>
    <script src="https://www.gstatic.com/firebasejs/7.20.0/firebase-app.js"></script>

    <!-- Add Firebase products that you want to use -->
    <script src="https://www.gstatic.com/firebasejs/7.20.0/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.20.0/firebase-firestore.js"></script>
    
    <script src="https://www.gstatic.com/firebasejs/7.20.0/firebase-messaging.js"></script>
    <script src={{ url("fcm_init.js") }}></script>

    <script>
        MsgElem = document.getElementById("msg");
        TokenElem = document.getElementById("token");
        NotisElem = document.getElementById("notis");
        ErrElem = document.getElementById("err");

        const messaging = firebase.messaging();
        messaging.usePublicVapidKey("BJeOeluFfTaxZcyqaGeYboHiNtnHqP27xtaByiqtrZeQVfTlyM96w4ZZ_TtRtLzz3SHJW7hVe5Kr8qe1vzy9a7M");

        messaging
            .requestPermission()
            .then(function () {
                MsgElem.innerHTML = "Notification permission granted.";
                console.log("Notification permission granted.");
                // get the token in the form of promise
                return messaging.getToken()
            })
            .then(function(token) {
                TokenElem.innerHTML = "token is : " + token
            })
            .catch(function (err) {
                ErrElem.innerHTML =  ErrElem.innerHTML + "; " + err
                console.log("Unable to get permission to notify.", err);
            });
    </script>

    </body>

</html>