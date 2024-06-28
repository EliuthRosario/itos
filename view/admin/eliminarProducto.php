  <!--modal para editar producto-->
  <div class="modal fade" id="eliminarProducto" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitleId">
            Alerta
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="../../controller/productoController.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="idProducto" id="idProducto">
            <div class="mb-2">
              ¿Seguro que deseas eliminar este producto?
            </div>
            <div>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <input type="submit" class="btn btn-danger" name="btnEliminar" value="Eliminar">
            </div>
          </form>
        </div>
        <div class="modal-footer"></div>
      </div>
    </div>
  </div>