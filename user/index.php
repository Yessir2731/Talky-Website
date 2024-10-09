<?php
?>
<!DOCTYPE html>
<html>
<head>
    <title>WhatsApp Clone</title>
    <script>
        function loadMessages() {
            var xhr = new XMLHttpRequest()
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("chatbox").innerHTML = xhr.responseText;
                }
            };
            xhr.open("GET", "get_messages.php", true);
            xhr.send();
        }

        function sendMessage() {
            var message = document.getElementById('message').value;
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "send_message.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('message').value = '';
                    loadMessages(); // Refresh chat after sending
                }
            };
            xhr.send("message=" + message);
        }

        setInterval(loadMessages, 1000); // Poll every second
    </script>
</head>
<body onload="loadMessages()">
    <div id="chatbox" style="height: 300px; border: 1px solid #ccc; overflow-y: scroll;">
        <!-- Messages will be loaded here -->
    </div>
    <input type="text" id="message" placeholder="Type a message">
    <button onclick="sendMessage()">Send</button>
</body>
</html>
