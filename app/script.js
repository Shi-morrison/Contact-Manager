function toggleMenu() {
    var navbarRight = document.querySelector(".navbar-right");
    var navbarLeft = document.querySelector(".navbar-left");
    var navbar = document.querySelector(".navbar");
    var menuToggle = document.querySelector(".menu-toggle");
    navbarRight.classList.toggle("active");
    navbarLeft.classList.toggle("active");
    navbar.classList.toggle("active");

    if (menuToggle.textContent === "☰") { // If it's a hamburger
        menuToggle.textContent = "✕"; // Change to "x"
    } else {
        menuToggle.textContent = "☰"; // Change back to hamburger
    }
}

function toggleButton() {

}
function showLoginModal() {
    var modal = document.getElementById("loginModal");
    modal.style.display = "flex";
}

function hideLoginModal() {
    var modal = document.getElementById("loginModal");
    modal.style.display = "none";
}