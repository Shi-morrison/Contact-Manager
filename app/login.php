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
            <div class="wrap">
                <div class="search">
                    <input type="text" class="searchTerm" placeholder="What are you looking for?">
                    <button type="submit" class="searchButton">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>

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


            <form onsubmit="event.preventDefault(); submitForm();">
                <input type="text" id="user_id" placeholder="User ID"><br>
                <input type="text" id="first_name" placeholder="First Name"><br>
                <input type="text" id="last_name" placeholder="Last Name"><br>
                <input type="email" id="email" placeholder="Email"><br>
                <input type="tel" id="phone" placeholder="Phone"><br>
                <input type="submit" value="Submit">
            </form>

            <div class="center">
                <!-- <button id="show-login">Login</button> -->
            </div>
            <div class="popup">
                <div class="close-btn">&times;</div>
                <form class="form">
                    <h2>Log in</h2>
                    <div class="form-element">
                        <label for="email">Email</label>
                        <input type="text" id="email" placeholder="Enter email">
                    </div>
                    <div class="form-element">
                        <label for="password">Password</label>
                        <input type="password" id="password" placeholder="Enter password">
                    </div>
                    <div class="form-element">
                        <input type="checkbox" id="remember-me">
                        <label for="remember-me">Remember me</label>
                    </div>
                    <div class="form-element">
                        <button type="submit" href="home.php">Sign in</button>
                    </div>
                    <div class="form-element">
                        <a href="#">Forgot password?</a>
                    </div>
                </form>
            </div>

            <div class="center">
                <!-- <button id="show-login">Login</button> -->
            </div>
            <div class="popup1">
                <div class="close-btn">&times;</div>
                <form class="form">
                    <h2>Register</h2>
                    <div class="form-element">
                        <label for="email">Email</label>
                        <input type="text" id="email" placeholder="Enter email">
                    </div>
                    <div class="form-element">
                        <label for="password">Password</label>
                        <input type="password" id="password" placeholder="Enter password">
                    </div>
                    <div class="form-element">
                        <button type="submit" href="home.php">Sign Up</button>
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

        function submitForm() {
            const data = {
                user_id: document.getElementById("user_id").value,
                first_name: document.getElementById("first_name").value,
                last_name: document.getElementById("last_name").value,
                email: document.getElementById("email").value,
                phone: document.getElementById("phone").value
            };

            fetch('./LAMPAPI/Contact.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                });
        }
    </script>
</body>

</html>