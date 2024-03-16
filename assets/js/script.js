// hamburger menu
const sidebar = document.querySelector(".sidebar");
const hamber = document.querySelector(".hamber");
const mainContent = document.querySelector(".content");
const loading = document.querySelector(".loading-overlay");
const appBar = document.querySelector(".appBar");
const menuToggle = document.querySelector("#menu-toggle");

hamber.addEventListener("click", function () {
  sidebar.classList.toggle("active");
  mainContent.classList.toggle("active");
  appBar.classList.toggle("active");
  menuToggle.classList.toggle("active");
});

menuToggle.addEventListener("click", function () {
  sidebar.classList.toggle("active");
  mainContent.classList.toggle("active");
  loading.classList.toggle("active");
  appBar.classList.toggle("active");
  menuToggle.classList.toggle("active");
});
// end hamburger menu


// show password
var passwordInput = document.getElementById("passwordInput");
passwordInput.addEventListener("click", function () {
  if (passwordInput.type === "password") {
    passwordInput.type = "text";
  } else {
    passwordInput.type = "password";
  }
});
passwordInput.addEventListener("blur", function () {
  passwordInput.type = "password";
});


// copy phone number in password input
document.getElementById('phoneField').addEventListener('input', function() {
  document.getElementsByName('password')[0].value = this.value;
});
