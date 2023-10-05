<?php
session_start(); // Ensure you start the session at the top of your PHP script
$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];
?>

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
  <input type="hidden" id="loggedInUserId" value="<?php echo $user_id; ?>">

  <!-- <video autoplay loop muted src="./assets/backround.mov" type="video/mov"></video> -->
  <!-- Start Navbar -->
  <header>
    <div class="navbar">
      <!-- Welcome User -->

      <div class="container">
        <a href="#" class="social-container twitter userNameDisplay">
          <div class="social-cube">
            <div class="front">
              Hello, <?php echo $_SESSION["username"]; ?>
            </div>
            <div class="bottom">
              Log Out
            </div>
          </div>
        </a>
      </div>

      <!-- Search bar -->
      <div class="wrap">
        <div class="search">
          <input type="text" class="searchTerm" placeholder="Search for Contact" id="searchBar">
          <button type="submit" class="searchButton" onClick="onSearch()">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>

      <div class="">
        <button class="icon-btn add-btn " id="show-contact">
          <div class="add-icon"></div>
          <div class="btn-txt">Add Contact</div>
        </button>
      </div>
      <!-- <button id="show-contact" class="custom-btn btn-15 contact">Create Contact</button> -->
      <!-- Dropdown Menu -->

    </div>

  </header>
  <!-- End Navbar -->

  <!-- Start hero section -->
  <main>
    <section id="hero">


      <div class='gravestones'>
        <div class='cross'></div>
        <div class='cross'></div>
        <div class='cross'></div>
      </div>

      <div class='crypt'>
        <div class='roof'></div>
        <div class='body'>
          <div class='door'></div>
        </div>
      </div>
      <div class='fog'></div>


      <!-- Add contact -->
      <div class="center">
      </div>
      <div class="popup2">
        <div class="close-btn">&times;</div>
        <form class="form" id="addContactForm" onsubmit="event.preventDefault(); submitForm();">
          <h2>Add Contact</h2>
          <div class="form-element">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" placeholder="First Name" autocomplete="off">

          </div>
          <div class="form-element">
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" placeholder="Last Name" autocomplete="off">
          </div>
          <div class="form-element">
            <label for="email">Email</label>
            <input type="text" id="email" placeholder="Email" autocomplete="off">
          </div>
          <div class="form-element">
            <label for="phone">Phone Number</label>
            <input type="text" id="phone" placeholder="Phone" autocomplete="off">
          </div>
          <div id="contactError" class="error"></div>
          <div class="form-element">
            <button type="submit" value="Submit">Create Contact</button>
          </div>
        </form>
      </div>
      <!-- End Add Contact -->

      <!-- Edit Contact -->
      <div class="center">
      </div>
      <div class="popup3">
        <div class="close-btn">&times;</div>
        <form class="form" onsubmit="event.preventDefault(); submitEditForm();">
          <h2>Edit Contact</h2>
          <div class="form-element">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" placeholder="First Name">

          </div>
          <div class="form-element">
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" placeholder="Last Name">
          </div>
          <div class="form-element">
            <label for="email">Email</label>
            <input type="text" id="email" placeholder="Email">
          </div>
          <div class="form-element">
            <label for="phone">Phone Number</label>
            <input type="text" id="phone" placeholder="Phone">
          </div>
          <div class="form-element">
            <button type="submit" value="Submit">Edit Contact</button>
          </div>
          <input type="hidden" id="editContactId">
        </form>
      </div>
      <!-- End Edit Contact -->
      <section class="contact-list">
        <div id="contactsDisplay">

        </div>

      </section>
      <div id="logoutPopup" class="logout-modal">
        <h3>Abandon the Haunted Mansion?</h3>
        <p>Are you sure you want to log out?</p>
        <button id="confirmLogout" class="confirm-btn">Yes</button>
        <button id="cancelLogout" class="cancel-btn">No</button>
      </div>



    </section>
  </main>
  <script>
    // Log out button and Logic
    document.querySelector('.userNameDisplay').addEventListener('click', function() {
      document.getElementById('logoutPopup').style.display = 'block';
    });

    document.getElementById('cancelLogout').addEventListener('click', function() {
      document.getElementById('logoutPopup').style.display = 'none';
    });

    document.getElementById('confirmLogout').addEventListener('click', function() {
      // Log out using AJAX and then redirect
      fetch('./LAMPAPI/LogoutUser.php', {
          method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
          if (data.msg === "Logout was successful") {
            window.location.href = 'index.php';
          } else {
            // Handle the logout error
            alert(data.msg);
          }
        })
        .catch(error => {
          console.error('Error logging out:', error);
        });
    });

    // DONT CHANGE !!

    // Fetch contacts on page load
    window.onload = fetchContacts;


    // Add contact button
    document.querySelector("#show-contact").addEventListener("click", function() {
      document.querySelector(".popup2").classList.add("active");

    });
    document.querySelector(".popup2 .close-btn").addEventListener("click", function() {
      document.querySelector(".popup2").classList.remove("active");
    });

    // Edit contact button
    function openEditModal(contactId, firstName, lastName, email, phone) {
      document.querySelector(".popup3 #first_name").value = firstName;
      document.querySelector(".popup3 #last_name").value = lastName;
      document.querySelector(".popup3 #email").value = email;
      document.querySelector(".popup3 #phone").value = phone;
      document.querySelector(".popup3 #editContactId").value = contactId;
      document.querySelector(".popup3").classList.add("active");
    }
    document.querySelector(".popup3 .close-btn").addEventListener("click", function() {
      document.querySelector(".popup3").classList.remove("active");
    });

    // Add contact dropdown
    document.querySelector("#show-contact-dropdown").addEventListener("click", function() {
      document.querySelector(".popup2").classList.add("active");
    });

    // Responsive dropdown menu
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

    // Add Contact Function
    function submitForm() {
      const userId = document.getElementById("loggedInUserId").value; // Fetch user_id of logged-in user
      const data = {
        user_id: userId,
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
          console.log(data); // let's log the data to see what's returned
          if (data.success) {
            document.getElementById("addContactForm").reset();
            // Close the modal
            document.querySelector(".popup2").classList.remove("active");
            // Maybe refresh the contacts list or other actions post successful addition
            fetchContacts();
          } else if (data.error) {
            // Display the error message at the bottom of the form
            displayError('contact', data.error);
          } else {
            // A general error for the form
            displayError('contact', 'Failed to add contact. Please try again.');
          }
        })
        .catch(error => {
          console.error('Error during the contact addition process:', error);
          displayError('contact', 'Failed to add contact due to a network issue. Please try again.');
        });
    }

    function displayError(formType, errorMessage) {
      let errorDiv;

      if (formType === 'contact') {
        errorDiv = document.getElementById('contactError');
      }

      if (errorDiv) {
        errorDiv.textContent = errorMessage;
      }
    }



    // Get Contact(s) Function
    function fetchContacts() {
      const userId = document.getElementById("loggedInUserId").value; // changed to retrieve from hidden input
      let contactId = ""; // Initialize contactId to empty string

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
          const contactsDiv = document.getElementById("contactsDisplay");
          contactsDiv.innerHTML = "";

          const renderContact = (contact) => {
            return `
                <div class="contact-card">
                  <div class="contact-details">
                      <h2 class="name">${contact.first_name} ${contact.last_name}</h2>
                      <h3 class="phone">Phone: ${contact.phone}</h3>
                      <h3 class="email">Email: ${contact.email}</h3>
                  </div>
                  <div class="contact-actions">
                      <button class="custom-btn edit-btn" onclick="openEditModal(${contact.contact_id}, '${contact.first_name}', '${contact.last_name}', '${contact.email}', '${contact.phone}')">Edit</button>
                      <button class="custom-btn delete-btn" onclick="deleteContact(${contact.contact_id})">Delete</button>
                  </div>
                </div>
            `;

          };

          if (data.contacts && Array.isArray(data.contacts)) {
            data.contacts.forEach(contact => {
              contactsDiv.innerHTML += renderContact(contact);
            });
          } else if (data.user_id && data.contact_id) { // Check if the single contact properties exist in the data
            contactsDiv.innerHTML = renderContact(data);
          } else {
            contactsDiv.innerHTML = "No contacts found.";
          }
        })
        .catch(error => {
          console.error("There was a problem with the fetch operation:", error.message);
        });
    }

    // Edit Contact Function
    function submitEditForm() {
      const contactId = document.getElementById("editContactId").value; // Ensure you've added this hidden field to your "Edit Contact" form
      const data = {
        contact_id: contactId,
        first_name: document.querySelector(".popup3 #first_name").value,
        last_name: document.querySelector(".popup3 #last_name").value,
        email: document.querySelector(".popup3 #email").value,
        phone: document.querySelector(".popup3 #phone").value
      };

      fetch('./LAMPAPI/Contact.php', {
          method: 'PUT', // Changed to PUT
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
          // Close the modal
          document.querySelector(".popup3").classList.remove("active");
          // Refresh the contacts list to reflect changes
          fetchContacts();
        })
        .catch(error => console.error('Error:', error));
    }

    // Delete Contact Function
    function deleteContact(contactId) {
      const data = {
        contact_id: contactId
      };

      fetch('./LAMPAPI/Contact.php', {
          method: 'DELETE',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(data)
        })
        .then(response => {
          if (!response.ok) {
            throw new Error("Network response was not ok");
          }
          return response.json();
        })
        .then(data => {
          console.log(data);
          fetchContacts(); // Refresh the displayed contacts after deletion
        })
        .catch(error => {
          console.log(error.message);
          console.error("There was a problem with the delete operation:", error.message);
        });
    }




    // CHANGE AFTER THIS

    // search bar object
    // use anywhere in document will be hoisted
    const searchBar = document.getElementById("searchBar");

    // event listener on search text box for enter key
    searchBar.addEventListener("keyup", function(event) {
      // event.KeyCode === 13 is the enter key
      if (event.keyCode === 13) {
        event.preventDefault();
        onSearch();
      }
    });

    function onSearch(){
      let searchBarText = document.getElementById("searchBar").value;
      let searchBarTextArr = searchBarText.split(" ");

      // filters all empty strings out of the array
      searchBarTextArr = searchBarTextArr.filter(function (element) {
        return element != "";
      });

      let len = searchBarTextArr.length;

      // object to hold user search data
      // if there is only one input, set that to singularSearchName <- use this to query the database
      // a bool is set in the object to check in the api code if the user only entered one name
      const userObject = {firstName: "", lastName: "", singularSearchName: "", onlyOneName: false};

      // if the user only enters one name, set the first and last name to the same value
      if (len === 1){
        userObject.singularSearchName = searchBarTextArr[0]
        userObject.onlyOneName = true;
      // if the user enters two names, set the first and last name to the respective values
      }else if(len === 2){
        userObject.firstName = searchBarTextArr[0]
        userObject.lastName = searchBarTextArr[1]
      }else{
        // TODO: can change this to alert to something fancy? this is just for utility
        alert("Enter first and/or last name");
        return;
      }

      fetch('./LAMPAPI/Search.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(userObject)
        })
        .then(response => response.text())
        .then(data => {
          // TODO: add appropriate code here?
          console.log(data);
        })
        .catch(error => console.error('Error:', error));
    }


  </script>

</body>

</html>