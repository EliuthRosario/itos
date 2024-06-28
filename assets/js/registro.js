//validar si el usuario ya existe
let txtUsuario = document.getElementById("usuario");
txtUsuario.addEventListener("blur", () => {
    existeUsuario(txtUsuario.value);
  },
  false
);

//validar si el email ya existe
let txtEmail = document.getElementById("email");
txtEmail.addEventListener("blur", () => {
    existeEmail(txtEmail.value);
  },
  false
);

//validar que las contraseñas coincidan
let txtPassword = document.getElementById("password");
let txtRepassword = document.getElementById("repassword");
txtRepassword.addEventListener("blur", () => {
    validarPassword(txtPassword.value, txtRepassword.value);
  },
  false
);

//funcion para hacer la peticion AJAX y verificar si el usuario ya existe en la base de datos
function existeUsuario(usuario) {
  let url = "../../assets/ajax/clienteAjax.php";
  let formData = new FormData();
  formData.append("action", "existeUsuario");
  formData.append("usuario", usuario);

  fetch(url, {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.ok) {
        document.getElementById("usuario").value = "";
        document.getElementById("validaUsuario").innerHTML = "El usuario ya existe";
      } else {
        document.getElementById("validaUsuario").innerHTML = "";
      }
    });
}

//funcion para hacer la peticion AJAX y verificar si el email ya existe
function existeEmail(email) {
  let url = "../../assets/ajax/clienteAjax.php";
  let formData = new FormData();
  formData.append("action", "existeEmail");
  formData.append("email", email);

  fetch(url, {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.ok) {
        document.getElementById("email").value = "";
        document.getElementById("validaEmail").innerHTML = "El email ya existe";
      } else {
        document.getElementById("validaEmail").innerHTML = "";
      }
    });
}

//funcion para vaalidar si las contraseñas coinciden
function validarPassword(password, repassword) {
  if (password != repassword) {
    document.getElementById("validaPassword").innerHTML = "Las contraseñas no coinciden";
  } else {
    document.getElementById("validaPassword").innerHTML = "";
  }
}