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
        <h2>Create New Contact</h2>
        <form action="#" method="post">
            <div class="input-box">
                <label>Full Name:</label>
                <input type="text" required>
            </div>
            <div class="input-box">
                <label>Phone:</label>
                <input type="text" required>
            </div>
            <div class="input-box">
                <label>Email:</label>
                <input type="text" required>
            </div>
            <div class="input-box">
                <label for="profile-pic">Photo:</label>
                <input type="file" id="profile-pic" name="profile-pic" accept="image/*">
            </div>
            <a href="home.php" style="text-decoration: none;" class="submit-button" type="submit">Create</a>
        </form>
    </div>
</body>
</html>