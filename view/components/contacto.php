  <!--modal para contacto-->
  <div class="modal fade" id="modalContacto" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitleId">
            Contacto
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="https://formspree.io/f/xldrrvjj" method="post" id="contactForm">
            <div class="mb-2">
              <label for="" class="form-label">Nombre</label>
              <input type="text" class="form-control" name="nombre" id="nombre" aria-describedby="helpId" placeholder="Nombre completo" required/>
            </div>
            <div class="mb-2">
              <label for="" class="form-label">Email</label>
              <input type="text" class="form-control" name="correo" id="correo" aria-describedby="helpId" placeholder="Email" required/>
            </div>
            <div class="mb-2">
              <label for="" class="form-label">Asunto</label>
              <input type="text" class="form-control" name="asunto" id="asunto" aria-describedby="helpId" placeholder="Asunto" required/>
            </div>
            <div class="mb-2">
              <label for="" class="form-label">Mensaje</label>
              <textarea class="form-control" name="mensaje" id="mensaje" rows="3" placeholder="Escriba aquí..." required></textarea>
            </div>
            <div>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
              <input type="submit" class="btn btn-primary" value="Enviar">
            </div>
          </form>
        </div>
        <div class="modal-footer"></div>
      </div>
    </div>
  </div>