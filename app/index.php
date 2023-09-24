<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles.css">
</head>

<body class="login-body">
    <div class="login-box">
        <h2>Login</h2>
        <form action="#" method="post">
            <div class="input-box">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-box">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <a href="home.php" style="text-decoration: none;" class="submit-button" type="submit">Login</a>
            <a class="register-button" href="register.php" style="text-decoration: none; font-size: 16px;">Register</a>
        </form>
    </div>
</body>

</html>