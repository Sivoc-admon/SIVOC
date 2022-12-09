
<!-- Modal  REGISTRAR PROYECTO-->
<div class="modal fade bd-example-modal-lg" id="modalUploadFile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Subir Archivo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
          </div>
          <div class="modal-body">
              <div class="container-fluid">
                  <form method="POST" id="formRegisterProject">
                    @csrf
                      <div class="row">
                        <h4>Archivo</h4>
                      </div>

                      <div class="row" style="background-color: rgb(144, 240, 144)">
                        <div class="col-md-4">
                          <div class="form-group">
                            <input type="hidden" name="hiddenAddFilefolder" id="hiddenAddFilefolder">
                            <label for="sltProyecto">Solo archivos excel</label>
                            <input id="inputFile" name="inputFile" class="form-control" type="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
                          </div>
                        </div>

                      </div>

                  </form>
                </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success" onclick="uploadFile()">Crear</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
      </div>
    </div>
</div>
