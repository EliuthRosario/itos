let editaProducto = document.getElementById('editarProducto'); //modal para editar producto
let eliminaProducto = document.getElementById('eliminarProducto'); //modal para eliminar producto

let inputIdProducto = editaProducto.querySelector('.modal-body #idProducto');
let inputNombre = editaProducto.querySelector('.modal-body #nombreProducto');
let inputPrecio = editaProducto.querySelector('.modal-body #precio');
let inputDescuento = editaProducto.querySelector('.modal-body #descuento');
let inputImagen = editaProducto.querySelector('.modal-body #imagen');
let inputDescripcion = editaProducto.querySelector('.modal-body #descripcion');
let inputCategoria = editaProducto.querySelector('.modal-body #categoria');

//obtener los datos del producto para editar
editaProducto.addEventListener('show.bs.modal', (e) => {
    let boton = e.relatedTarget;
    let idProducto = boton.getAttribute('data-bs-idProducto');

    let url = '../../assets/ajax/productoAjax.php';
    let formData = new FormData();
    formData.append('idProducto', idProducto);

    fetch(url, {
        method: 'post',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        inputIdProducto.value = data.idProducto;
        inputNombre.value = data.nombreProducto;
        inputPrecio.value = data.precio;
        inputDescuento.value = data.descuento;
        // inputImagen.value = data.imagen;
        inputDescripcion.value = data.descripcion;
        inputCategoria.value = data.idCategoria;
    })
});

//obtener los datos del producto para eliminar
eliminaProducto.addEventListener('show.bs.modal', (e) => {
    let boton = e.relatedTarget;
    let idProducto = boton.getAttribute('data-bs-idProducto');

    let url = '../../assets/ajax/productoAjax.php';
    let formData = new FormData();
    formData.append('idProducto', idProducto);

    fetch(url, {
        method: 'post',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        eliminaProducto.querySelector('.modal-body #idProducto').value = data.idProducto;
    })
});