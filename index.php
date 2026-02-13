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
        <form method="post" action="send.php">
            <label>Enter the letters:</label><br>
            <img src="captcha.php" alt="CAPTCHA"><br><br>
            <input type="text" name="captcha_input" maxlength="3" required>
            <button type="submit">Send</button>
        </form>
    </body>

    </html>