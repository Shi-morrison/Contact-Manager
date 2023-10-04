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

  <video autoplay loop muted src="./assets/backround.mov" type="video/mov"></video>
  <!-- Start Navbar -->
  <header>
    <div class="navbar">
      <!-- Welcome User -->
      <div>
        Welcome, <?php echo $_SESSION["username"]; ?>
      </div>
      <!-- Search bar -->
      <div class="wrap">
        <div class="search">
          <input type="text" class="searchTerm" placeholder="Search for Contact">
          <button type="submit" class="searchButton">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
      <button id="show-contact" class="custom-btn btn-15 contact">Create Contact</button>
      <!-- Dropdown Menu -->
      <div class="toggle_btn">
        <i class="fa-solid fa-bars"></i>
      </div>
    </div>
    <div class="dropdown_menu">
      <li>
        <button id="show-contact-dropdown" class="custom-btn btn-15 contact">Create Contact</button>
      </li>
    </div>
  </header>
  <!-- End Navbar -->

  <!-- Start hero section -->
  <main>
    <section id="hero">
      <!-- Add contact -->
      <div class="center">
      </div>
      <div class="popup2">
        <div class="close-btn">&times;</div>
        <form class="form" onsubmit="event.preventDefault(); submitForm();">
          <h2>Add Contact</h2>
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

      <!-- <div class="transparent">
        <div class="outline" style="justify-content: left; background: #72757e;">
          <div class="info">
            <img style="justify-content: center; margin-top: 10px;" class="profile-pic"
              src="https://i.pinimg.com/originals/c9/f2/6d/c9f26d445db1d64bfc1bdccc40dbdf4c.jpg">
          </div>
          <div class="spacing"></div>
          <div class="info">
            <h3 style="color: #fffffe;">User</h3>
          </div>
          <div class="spacing"></div>
          <div class="info">
            <h3 style="color: #fffffe;">000-000-0000</h3>
          </div>
          <div class="spacing"></div>
          <div class="info">
            <button id="show-contact" class="custom-btn btn-15 contact">Create Contact</button>

          </div>
        </div> -->
      <section class="contact-list">
        <ul id="contactsDisplay">

        </ul>
      </section>
      </div>


    </section>
  </main>
  <script>
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
          // Close the modal
          document.querySelector(".popup2").classList.remove("active");
          // Refresh the contacts list to reflect changes
          fetchContacts();
          console.log(data);
        });
    }

    // Get Contact(s) Function
    function fetchContacts() {
      const userId = document.getElementById("loggedInUserId").value; // changed to retrieve from hidden input
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
          const contactsDiv = document.getElementById("contactsDisplay");
          contactsDiv.innerHTML = "";

          const renderContact = (contact) => {
            return `
                <div class="contact">
                    <img class="profile-pic"
                      src="https://i.pinimg.com/originals/c9/f2/6d/c9f26d445db1d64bfc1bdccc40dbdf4c.jpg">
                    <div class="contact-info">
                        <h2>Name: ${contact.first_name} ${contact.last_name}</h2>
                        <h3>Phone: ${contact.phone}</h3>
                        <h3>Email: ${contact.email}</h3>
                    </div>
                    <div class="contact-actions">
                        <button class="custom-btn btn-15 contact" onclick="openEditModal(${contact.contact_id}, '${contact.first_name}', '${contact.last_name}', '${contact.email}', '${contact.phone}')">Edit</button>
                        <button class="custom-btn btn-15 contact" onclick="deleteContact(${contact.contact_id})">Delete</button>
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
  </script>

</body>

</html>