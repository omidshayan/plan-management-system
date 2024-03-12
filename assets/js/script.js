const sidebar = document.querySelector('.sidebar');
const hamber = document.querySelector('.hamber');
const mainContent = document.querySelector('.content');
const appBar = document.querySelector('.appBar');
const menuToggle = document.querySelector('#menu-toggle');

hamber.addEventListener('click', function(){
     sidebar.classList.toggle('active')
     mainContent.classList.toggle('active');
     appBar.classList.toggle('active');
     menuToggle.classList.toggle('active')
})

menuToggle.addEventListener('click', function(){
     sidebar.classList.toggle('active')
     mainContent.classList.toggle('active');
     appBar.classList.toggle('active');
     menuToggle.classList.toggle('active')
})

