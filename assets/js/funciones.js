//Boton de ir hacia arriba
let btnTop = document.getElementById("btn-top");
btnTop.addEventListener("click", () => (document.documentElement.scrollTop = 0) 
);

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
let options = document.querySelectorAll('.option');

btnMenu.addEventListener('click', () => {
  menu.style.visibility = 'visible';
  menu.style.left = '0';
});

btnClose.addEventListener('click', () => {
  menu.style.visibility = 'hidden';
  menu.style.left = '-420px';
});


//enviar datos del formulario de contacto
const contactForm = document.getElementById('contactForm');
contactForm.addEventListener('submit', handleSubmit);

function handleSubmit(e) {
  e.preventDefault();
  const formData = new FormData(this);
  fetch(this.action, {
    method: this.method,
    body: formData,
    headers: {
      'Accept': 'application/json'
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.ok) {
      this.reset();
      alert('Gracias por contatactarnos, pronto te escribiremos')
    }
  })

}