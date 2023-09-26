<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <video autoplay loop muted src="./assets/backround.mov" type="video/mov"></video>
    <header>
        <div class="navbar">
            <div class="logo"> <a href="index.php">Home</a></div>
            <ul class="links">
                <li><a href="register.php">Sign Up</a></li>
                <li><a href="login.php">Log In</a></li>
            </ul>

            <div class="toggle_btn">
                <i class="fa-solid fa-bars"></i>
            </div>
        </div>
        <div class="dropdown_menu">
            <li><a href="register.php">Sign Up</a></li>
            <li><a href="login.php">Log In</a></li>

        </div>
    </header>

    <main>
        <section id="hero">
            <div class="login-box">
                <h2>Register</h2>
                <form action="#" method="post">
                    <div class="input-box">
                        <label for="username">Create username</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="input-box">
                        <label for="password">Create password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="input-box" <label style="font-weight: bold;" for="password">Confirm password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <a class="submit-button" href="home.php" style="text-decoration: none;">Submit</a>
                </form>
            </div>

        </section>
    </main>


    <script>
        var toggleBtn = document.querySelector(".toggle_btn")
        var toggleBtnIcon = document.querySelector(".toggle_btn i")
        var dropDownMenu = document.querySelector(".dropdown_menu")

        toggleBtn.onclick = function () {
            dropDownMenu.classList.toggle("open")
            const isOpen = dropDownMenu.classList.contains("open")

            toggleBtnIcon.classList = isOpen
                ? 'fa-solid fa-xmark'
                : 'fa-solid fa-bars'
        }

    </script>
</body>

</html>