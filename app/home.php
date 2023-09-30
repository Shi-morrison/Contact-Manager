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
      <div class="transparent">
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
            <button class="contact-button" onClick="window.location.href='addContact.php'">Add Contact</button>
          </div>
        </div>
        <section class="contact-list">
          <ul>
            <script>
              function deleteItem() {
                confirm("Are you sure?");
              }
            </script>
            <div class="contact">
              <img style="justify-content: center; width: 30px;" class="profile-pic"
                src="https://i.pinimg.com/originals/c9/f2/6d/c9f26d445db1d64bfc1bdccc40dbdf4c.jpg">
              <h2>Mohamad Mustafa</h2>
              <h3>Phone: 123-456-7890</h3>
              <h3>Email: example@example.com</h3>
              <div>
                <button class="contact-button">Edit</button>
                <button class="contact-button" onClick="deleteItem()">Delete</button>
              </div>
            </div>
            <div class="spacing"></div>
            <div class="contact">
              <img style="justify-content: center; width: 30px;" class="profile-pic"
                src="https://i.pinimg.com/originals/c9/f2/6d/c9f26d445db1d64bfc1bdccc40dbdf4c.jpg">
              <h2>John Doe</h2>
              <h3>Phone: 123-456-7890</h3>
              <h3>Email: example@example.com</h3>
              <div>
                <button class="contact-button">Edit</button>
                <button class="contact-button" onClick="deleteItem()">Delete</button>
              </div>
            </div>
            <div class="spacing"></div>
            <div class="contact">
              <img style="justify-content: center; width: 30px;" class="profile-pic"
                src="https://i.pinimg.com/originals/c9/f2/6d/c9f26d445db1d64bfc1bdccc40dbdf4c.jpg">
              <h2>Another Name</h2>
              <h3>Phone: 123-456-7890</h3>
              <h3>Email: example@example.com</h3>
              <div>
                <button class="contact-button">Edit</button>
                <button class="contact-button" onClick="deleteItem()">Delete</button>
              </div>
            </div>
          </ul>
        </section>
      </div>


    </section>
  </main>

</body>

</html>