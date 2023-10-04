<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <video autoplay loop muted src="./assets/backround.mov" type="video/mov"></video>
    <header>
        <div class="navbar">
            <div> <a class="custom-btn btn-15" href="index.php">Home</a></div>
            <ul class="links">
                <li><button id="show-register" class="custom-btn btn-15">Sign Up</button></li>
                <li><button id="show-login" class="custom-btn btn-15">Log In</button></li>
            </ul>
            <div class="toggle_btn">
                <i class="fa-solid fa-bars"></i>
            </div>
        </div>
        <div class="dropdown_menu">
            <li><button id="show-register" class="custom-btn btn-15">Sign Up</button></li>
            <li><button id="show-login" class="custom-btn btn-15">Log In</button></li>

        </div>
    </header>

    <main>
        <section id="hero">
            <!-- Log in Form -->
            <div class="center">
            </div>
            <div class="popup">
                <div class="close-btn">&times;</div>
                <form class="form" id="loginForm">
                    <h2>Log in</h2>
                    <div class="form-element">
                        <label for="username">Username</label>
                        <input type="text" id="logInusername" placeholder="Enter username">
                    </div>
                    <div class="form-element">
                        <label for="password">Password</label>
                        <input type="password" id="logInpassword" placeholder="Enter password">
                    </div>
                    <div id="loginError" class="error"></div>
                    <div class="form-element">
                        <button type="submit">Sign in</button>
                    </div>
                </form>
            </div>

            <!-- Register Form -->
            <div class="center">
            </div>
            <div class="popup1">
                <div class="close-btn">&times;</div>
                <form class="form" id="registrationForm">
                    <h2>Register</h2>
                    <div class="form-element">
                        <label for="username">Username</label>
                        <input type="text" id="username" placeholder="Enter username">
                    </div>
                    <div class="form-element">
                        <label for="password">Password</label>
                        <input type="password" id="password" placeholder="Enter password">
                    </div>
                    <div id="registerError" class="error"></div>
                    <div class="form-element">
                        <button type="submit">Sign Up</button>
                    </div>

                </form>
            </div>
        </section>
    </main>


    <script>
        document.querySelector("#show-login").addEventListener("click", function() {
            if (!document.querySelector(".popup1").classList.contains("active")) {
                document.querySelector(".popup").classList.add("active");
            }
        });
        document.querySelector(".popup .close-btn").addEventListener("click", function() {
            document.querySelector(".popup").classList.remove("active");
        });

        document.querySelector("#show-register").addEventListener("click", function() {
            if (!document.querySelector(".popup").classList.contains("active")) {
                document.querySelector(".popup1").classList.add("active");
            }
            document.querySelector(".popup1").classList.add("active");
        });
        document.querySelector(".popup1 .close-btn").addEventListener("click", function() {
            document.querySelector(".popup1").classList.remove("active");
        });

        var toggleBtn = document.querySelector(".toggle_btn")
        var toggleBtnIcon = document.querySelector(".toggle_btn i")
        var dropDownMenu = document.querySelector(".dropdown_menu")

        toggleBtn.onclick = function() {
            dropDownMenu.classList.toggle("open")
            const isOpen = dropDownMenu.classList.contains("open")

            toggleBtnIcon.classList = isOpen ?
                'fa-solid fa-xmark' :
                'fa-solid fa-bars'
        }

        document.querySelector("#registrationForm").addEventListener("submit", function(event) {
            event.preventDefault();
            registerUser();
        });

        function registerUser() {
            const username = document.getElementById("username").value;
            const password = document.getElementById("password").value;

            const data = {
                username: username,
                new_password: password,
                confirm_password: password
            };

            fetch('./LAMPAPI/RegisterUser.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.user_id) {
                        window.location.href = "home.php"; // Redirect to home.php
                    } else if (data.error) {
                        // Display the error message at the bottom of the form
                        displayError('register', data.error);
                    } else {
                        // General error for the whole form
                        alert('Login failed. Please try again.');
                    }
                })

        }

        document.querySelector("#loginForm").addEventListener("submit", function(event) {
            event.preventDefault();
            loginUser();
        });

        function loginUser() {
            const username = document.getElementById("logInusername").value;
            const password = document.getElementById("logInpassword").value;

            const data = {
                username: username,
                password: password
            };

            fetch('./LAMPAPI/LoginUser.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.user_id) {
                        window.location.href = "home.php"; // Redirect to home.php
                    } else if (data.error) {
                        // Display the error message at the bottom of the form
                        displayError('login', data.error);
                    } else {
                        // General error for the whole form
                        alert('Login failed. Please try again.');
                    }
                })

                .catch(error => {
                    console.error('Error during the login process:', error);
                });
        }

        function clearError(formType) {
            const errorElement = formType === 'login' ?
                document.getElementById("loginError") :
                document.getElementById("registerError");
            if (errorElement) {
                errorElement.textContent = '';
            }
        }


        function displayError(formType, message) {
            const errorElement = formType === 'login' ?
                document.getElementById("loginError") :
                document.getElementById("registerError");
            if (errorElement) {
                errorElement.textContent = message;
            }
        }
    </script>
</body>

</html>