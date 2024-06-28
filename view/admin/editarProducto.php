  <!--modal para editar producto-->
  <div class="modal fade" id="editarProducto" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitleId">
            Editar producto
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="../../controller/productoController.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="idProducto" id="idProducto">
            <div class="mb-2">
              <label for="" class="form-label">Nombre</label>
              <input type="text" class="form-control" name="nombreProducto" id="nombreProducto" aria-describedby="helpId" placeholder="Nombre producto" required/>
            </div>
            <div class="mb-2">
              <label for="" class="form-label">Precio</label>
              <input type="number" class="form-control" name="precio" id="precio" aria-describedby="helpId" placeholder="20000" required/>
            </div>
            <div class="mb-2">
              <label for="" class="form-label">Descuento</label>
              <input type="number" class="form-control" name="descuento" id="descuento" aria-describedby="helpId" placeholder="10" required/>
            </div>
            <div class="mb-2">
              <label for="" class="form-label">Imagen</label>
              <input type="file" class="form-control" name="imagen" id="imagen" accept=".png, .jpg, jpeg, .svg" aria-describedby="helpId" required/>
            </div>
            <div class="mb-2">
              <label for="" class="form-label">Descripción</label>
              <textarea class="form-control" name="descripcion" id="descripcion" rows="3" placeholder="Escriba aquí..." required></textarea>
            </div>
            <div class="mb-2">
              <label for="" class="form-label">Categoría</label>
              <select name="categoria" id="categoria" class="form-select" required>
                <option value="">Seleccione una categoría</option>
                <?php  
                $sql = $con->prepare("SELECT * FROM categorias");
                $sql->execute();
                $result = $sql->get_result();
                if ($result->num_rows > 0) {
                  while ($categoria = $result->fetch_assoc()) { ?>
                    <option value="<?= $categoria['idCategoria']; ?>"><?= $categoria['nombreCategoria']; ?></option>
                <?php
                  }
                } else {
                  echo 'No hay categorias disponibles';
                }
                ?>
              </select>
            </div>
            <div>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
              <input type="submit" class="btn btn-primary" name="btnEditar" value="Guardar">
            </div>
          </form>
        </div>
        <div class="modal-footer"></div>
      </div>
    </div>
  </div>