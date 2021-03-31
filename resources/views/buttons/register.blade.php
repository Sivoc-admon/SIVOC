<!-- Modal Nuevo Boton -->
<div class="modal fade" id="ModalRegisterButton" tabindex="-1" aria-labelledby="ModalRegisterButton" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registro Boton</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <form id="formRegisterButton">
              @csrf
                <div class="row">
                  <h4>Datos Boton</h4>
                </div>
                  
                <div class="row" style="background-color: #17a2b8">
                  
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="inputButton">Nombre</label>
                        <input type="text" class="form-control" name="inputButton" id="inputButton">
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="sltColorButton">Color</label>
                        <select class="form-control" name="sltColorButton" id="sltColorButton">
                         <option value="0">Seleccione</option>
                         <option  style="background-color: blue" value="primary">Primary </option>
                         <option  style="background-color: green" value="success">Success </option>
                         <option  style="background-color: red" value="danger">Danger </option>
                         <option  style="background-color: orange" value="warning">Warning </option>
                         <option  style="background-color: #17a2b8" value="info">Info </option>
                         
                        </select>
                      </div>
                    </div>
                    
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="fileButton" class="form-label">Documentos</label>
                        <input class="form-control" type="file" id="fileButton" name="fileButton">
                      </div>
                    </div>
                </div>

            </form>
          </div>
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" onclick="saveButton();">Guardar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
    </div>
</div>

<!-- Modal Editar Boton -->
<div class="modal fade" id="ModalEditButton" tabindex="-1" aria-labelledby="ModalEditButton" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
  <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Registro Boton</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      <input type="hidden" name="idButon" id="idButon">
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <form id="formEditButton">
            @csrf
              <div class="row">
                <h4>Datos Boton</h4>
              </div>
                
              <div class="row" style="background-color: #17a2b8">
                
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="inputEditButton">Nombre</label>
                      <input type="text" class="form-control" name="inputEditButton" id="inputEditButton">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="sltEditColorButton">Color</label>
                      <select class="form-control" name="sltEditColorButton" id="sltEditColorButton">
                       <option value="0">Seleccione</option>
                       <option  style="background-color: blue" value="primary">Primary </option>
                       <option  style="background-color: green" value="success">Success </option>
                       <option  style="background-color: red" value="danger">Danger </option>
                       <option  style="background-color: orange" value="warning">Warning </option>
                       <option  style="background-color: #17a2b8" value="info">Info </option>
                       
                      </select>
                    </div>
                  </div>
                  
                  
              </div>

          </form>
        </div>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="updateButton();">Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
  </div>
  </div>
</div>