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
    <!-- <video autoplay loop muted src="./assets/backround.mov" type="video/mov"></video> -->
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
            <div class="view">
                <h1>Contact Viewer</h1>

                <!-- Input for user ID -->
                <div>
                    <label for="user_id">User ID:</label>
                    <input type="text" id="user_id" placeholder="Enter User ID">
                </div>

                <!-- Input for contact ID (optional) -->
                <div>
                    <label for="contact_id">Contact ID (optional):</label>
                    <input type="text" id="contact_id" placeholder="Enter Contact ID or leave blank">
                </div>

                <button onclick="fetchContacts()">Fetch Contacts</button>

                <div class="halloween">
                    <div class="head">
                        <div class="skull">
                            <div class="eyes">
                                <div class="eye eye-left"></div>
                                <div class="eye eye-right"></div>
                            </div>
                        </div>
                    </div>
                    <div class="body"></div>
                    <div class="legs"></div>
                </div>

                <div class="container">
                    <a href="https://twitter.com/austin_dudas" class="social-container twitter">
                        <div class="social-cube">
                            <div class="front">
                                Twitter
                            </div>
                            <div class="bottom">
                                @austin_dudas
                            </div>
                        </div>
                    </a>


                    <!-- Display contacts here -->
                    <div id="contactsDisplay">
                        Contacts here
                    </div>

                </div>


        </section>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function fetchContacts() {
            const userId = document.getElementById("user_id").value;
            let contactId = document.getElementById("contact_id").value;

            // If contactId is empty, set it to 'null' as per your PHP logic
            if (!contactId) {
                contactId = "null";
            }

            // Constructing the URL with query parameters
            const apiUrl = `./LAMPAPI/Contact.php?user_id=${userId}&contact_id=${contactId}`;

            fetch(apiUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json();
                })
                .then(data => {
                    // Displaying the contacts (or contact)
                    const contactsDiv = document.getElementById("contactsDisplay");
                    contactsDiv.innerHTML = "";

                    if (data.contacts && Array.isArray(data.contacts)) {
                        data.contacts.forEach(contact => {
                            const contactItem = `
                    <div id="contact-list">
                        <div id="contact">
                            <p id="nameDisplay">${contact.first_name} ${contact.last_name}</p>
                            <p id="emailDisplay">${contact.email}</p>
                            <p id="phoneDisplay">${contact.phone}</p>
                            <button id="delete">Delete</button>
                        </div>
                    </div>
                        `;
                            contactsDiv.innerHTML += contactItem;
                        });
                    } else {
                        contactsDiv.innerHTML = "No contacts found.";
                    }
                })
                .catch(error => {
                    console.error("There was a problem with the fetch operation:", error.message);
                });
        }
    </script>
</body>

</html>