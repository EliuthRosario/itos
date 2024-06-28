//Boton de ir hacia arriba
let btnTop = document.getElementById("btn-top");
btnTop.addEventListener("click", () => (document.documentElement.scrollTop = 0));

window.addEventListener("scroll", () => {
  if (document.documentElement.scrollTop > 100) { 
    btnTop.style.display = "flex"; 
  } else {
    btnTop.style.display = "none";
  }
});


//menu mobile
let btnMenu = document.getElementById('btn-menu');
let menu = document.getElementById('menu-mobile');
let btnClose = document.getElementById('btn-close');
let options = document.querySelectorAll('.option-link');
let categorys = document.querySelectorAll('.category');

btnMenu.addEventListener('click', () => {
  menu.style.visibility = 'visible';
  menu.style.left = '0';
});

btnClose.addEventListener('click', () => {
  menu.style.left = '-420px';
  menu.style.visibility = 'hidden';
});

options.forEach(option => {
  option.addEventListener('click', () => {
    menu.style.left = '-420px';
    menu.style.visibility = 'hidden';
  })
})

categorys.forEach(category => {
  category.addEventListener('click', () => {
    menu.style.left = '-420px';
    menu.style.visibility = 'hidden';
  })
})
