<?php
session_start(); // Ensure you start the session at the top of your PHP script
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
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
              Hello, <?php echo $_SESSION['username']; ?>
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
          <input type="text" class="searchTerm" placeholder="Search for Contact" id="searchBar" oninput="liveSearch()">
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
    </div>

  </header>
  <!-- End Navbar -->

  <!-- Start hero section -->
  <main>
    <section id="hero">

      <!-- Where contacts are displayed -->
      <section class="contact-list">
        <div id="contactsDisplay">
        </div>
      </section>

      <!-- Pagination Controls -->
      <div id="paginationControls">
        <button id="prevPageBtn" onclick="prevPage()">Previous</button>
        <span id="pageInfo">Page <span id="currentPage">1</span> of <span id="totalPages">?</span></span>
        <button id="nextPageBtn" onclick="nextPage()">Next</button>
      </div>

      <!-- Backround Art -->
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

      <!-- Logout Popup -->
      <div id="logoutPopup" class="logout-modal">
        <h3>Abandon the Haunted Mansion?</h3>
        <p>Are you sure you want to log out?</p>
        <button id="confirmLogout" class="confirm-btn">Yes</button>
        <button id="cancelLogout" class="cancel-btn">No</button>
      </div>

      <!-- Delete Confirmation Popup -->
      <div id="deletePopup" class="delete-modal">
        <h3>Confirm Deletion</h3>
        <p>Are you sure you want to delete this contact?</p>
        <button id="confirmDelete" class="confirm-btn1">Yes</button>
        <button id="cancelDelete" class="cancel-btn1">No</button>
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
    window.onload = function() {
      fetchContacts(1); // Calling fetchContacts with a specific page number
    };



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

    // Add Contact Function
    function submitForm() {
      const userId = document.getElementById("loggedInUserId").value; // Fetch user_id of logged-in user
      let data = {
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
    function fetchContacts(page = 1, itemsPerPage = 9) {
      const userId = document.getElementById("loggedInUserId").value;
      const apiUrl = `./LAMPAPI/Contact.php?user_id=${userId}&page=${page}&items_per_page=${itemsPerPage}`;

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
                          <h3 class="email">Date Created: ${contact.date_created}</h3>
                          <div class="contact-actions">
                            <button class="custom-btn edit-btn" onclick="openEditModal(${contact.contact_id}, '${contact.first_name}', '${contact.last_name}', '${contact.email}', '${contact.phone}')">Edit</button>
                            <button class="custom-btn delete-btn" onclick="deleteContact(${contact.contact_id})">Delete</button>
                          </div>
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

          // Update pagination info
          document.getElementById("currentPage").textContent = page;
          // Assume total pages is 10 for now
          document.getElementById("totalPages").textContent = 10;

        })
        .catch(error => {
          console.error("There was a problem with the fetch operation:", error.message);
        });
    }

    function prevPage() {
      const currentPage = parseInt(document.getElementById("currentPage").textContent);
      if (currentPage > 1) {
        fetchContacts(currentPage - 1);
      }
    }

    function nextPage() {
      const currentPage = parseInt(document.getElementById("currentPage").textContent);
      const totalPages = parseInt(document.getElementById("totalPages").textContent);
      if (currentPage < totalPages) {
        fetchContacts(currentPage + 1);
      }
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


    let currentContactId;

    function confirmDelete() {
      document.getElementById('deletePopup').style.display = 'none'; // Hide the popup

      console.log('deleteContact called with contactId:', currentContactId);
      // Your existing code for deleting the contact
      const data = {
        contact_id: currentContactId
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

    function cancelDelete() {
      document.getElementById('deletePopup').style.display = 'none'; // Hide the popup
    }

    function deleteContact(contactId) {
      // Update the current contact id
      currentContactId = contactId;


      // Display the delete confirmation popup
      document.getElementById('deletePopup').style.display = 'block';

      // Remove the previous event listeners
      document.getElementById('cancelDelete').removeEventListener('click', cancelDelete);
      document.getElementById('confirmDelete').removeEventListener('click', confirmDelete);

      // Add the new event listeners
      document.getElementById('cancelDelete').addEventListener('click', cancelDelete);
      document.getElementById('confirmDelete').addEventListener('click', confirmDelete);
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



    function liveSearch() {
      let searchBarText = document.getElementById("searchBar").value;
      if (searchBarText.length >= 1) { // Optional: only search when at least 1 character is typed
        onSearch();
      } else {
        // Optionally: clear the search results when the search bar is empty
        fetchContacts();
      }
    }

    function onSearch() {
      let searchBarText = document.getElementById("searchBar").value.trim();
      let searchBarTextArr = searchBarText.split(" ");

      // Object to hold user search data
      const userObject = {
        firstName: "",
        lastName: "",
        singularSearchName: "",
        onlyOneName: false
      };

      if (searchBarTextArr.length === 1) {
        userObject.singularSearchName = searchBarTextArr[0];
        userObject.onlyOneName = true;
      } else if (searchBarTextArr.length === 2) {
        userObject.firstName = searchBarTextArr[0];
        userObject.lastName = searchBarTextArr[1];
      } else {
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
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
          }
          return response.json();
        })
        .then(data => {
          renderSearchResults(data.contact_id);
        })
        .catch(error => console.error('Error:', error));
    }

    function renderSearchResults(contactIds) {
      const apiUrl = `./LAMPAPI/Contact.php`;
      const userId = document.getElementById("loggedInUserId").value;
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

      contactIds.forEach(contactId => {
        fetch(`${apiUrl}?user_id=${userId}&contact_id=${contactId}`)
          .then(response => response.json())
          .then(contactData => {
            contactsDiv.innerHTML += renderContact(contactData);
          })
          .catch(error => console.error('Error fetching contact:', error));
      });
    }
  </script>

</body>

</html>