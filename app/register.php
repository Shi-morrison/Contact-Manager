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
            <div> <a class="custom-btn btn-15" href="index.php">Home</a></div>
            <div class="wrap">
                <div class="search">
                    <input type="text" class="searchTerm" placeholder="Search for Contact">
                    <button type="submit" class="searchButton">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="dropdown_menu">
                <li><button id="show-register" class="custom-btn btn-15">Sign Up</button></li>
                <li><button id="show-login" class="custom-btn btn-15">Log In</button></li>

            </div>
    </header>
    <main>
        <section id="hero">

            <form id="retrieveForm">
                <label for="user_id">User ID:</label>
                <input type="text" id="user_id" name="user_id">
                <input type="submit" value="Get Contacts">
            </form>

            <h2>Contacts:</h2>
            <ul id="contactsList">
                <!-- Contacts will be appended here -->
            </ul>


        </section>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#retrieveForm").submit(function (event) {
                event.preventDefault();

                const data = {
                    user_id: $("#user_id").val()
                };

                $.ajax({
                    url: './LAMPAPI/Contact.php',
                    type: 'GET',
                    data: data,
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function (response) {
                        $("#contactsList").empty(); // Clear previous contacts
                        response.forEach(contact => {
                            $("#contactsList").append(`<li>${contact.first_name} ${contact.last_name} - ${contact.email}</li>`);
                        });
                    },
                    error: function (error) {
                        console.error("Error retrieving contacts:", error);
                    }
                });
            });
        });
    </script>
</body>

</html>