    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Captcha Test</title>
        <style>
            input[name="captcha_input"] {
                text-transform: uppercase;
            }
        </style>
    </head>

    <body>

        <?php session_start(); ?>
        <form id="captchaForm" method="post" action="send.php">
            <label>Enter the letters:</label><br>
            <img src="captcha.php" alt="CAPTCHA"><br><br>
            <input type="text" name="captcha_input" maxlength="3" required>
            <button type="submit">Send</button>
            <div id="captchaError" style="color: red; display: none; margin-top: 10px;"></div>
        </form>
        <script>
        document.getElementById('captchaForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const input = document.querySelector('input[name="captcha_input"]').value.trim().toUpperCase();
            fetch('send.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'captcha_input=' + encodeURIComponent(input)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'error') {
                    document.getElementById('captchaError').innerHTML =
                        'CAPTCHA is incorrect.<br>' +
                        '<b>Sent:</b> ' + data.sent + '<br>' +
                        '<b>Generated:</b> ' + data.generated;
                    document.getElementById('captchaError').style.display = 'block';
                    document.getElementById('captchaError').style.color = 'red';
                    // Refresh captcha image
                    document.querySelector('img[alt="CAPTCHA"]').src = 'captcha.php?' + Date.now();
                } else {
                    document.getElementById('captchaError').innerHTML = '<span style="color:green">' + data.message + '</span>';
                    document.getElementById('captchaError').style.display = 'block';
                    document.getElementById('captchaError').style.color = 'green';
                    // Optionally clear input
                    document.querySelector('input[name="captcha_input"]').value = '';
                    // Refresh captcha image
                    document.querySelector('img[alt="CAPTCHA"]').src = 'captcha.php?' + Date.now();
                }
            });
        });
        </script>
    </body>

    </html>