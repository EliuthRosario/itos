//buscar un producto
document.addEventListener('keydown', (e) => {
    if (e.target.matches('#nombreProducto')) {
        document.querySelectorAll('.item-producto').forEach(item => {
            item.textContent.toLowerCase().includes(e.target.value) 
            ? item.classList.remove('filtro') 
            : item.classList.add('filtro');
        });
    }
});

