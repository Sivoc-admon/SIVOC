 <!-- Modal Nueva Asset -->
 <div class="modal fade" id="ModalRegisterAsset" tabindex="-1" aria-labelledby="ModalRegisterAsset" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registro de Activo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <form id="formRegisterMinute">
              @csrf
                <div class="row">
                  <h4>Datos de Activo</h4>
                </div>
                  
                <div class="row" style="background-color: #17a2b8">
                  
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="inputDescriptionAsset">Descripción</label>
                        <textarea class="form-control" id="inputDescriptionAsset" name="inputDescriptionAsset" rows="5" cols="5"></textarea>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="inputCostoAsset">Costo</label>
                        <input type="number" class="form-control" id="inputCostoAsset" name="inputCostoAsset">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="inputBuyAsset">Fecha de Compra</label>
                        <input type="date" class="form-control" id="inputBuyAsset" name="inputBuyAsset" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="checkAsset" name="checkAsset" onclick="muestraOculta('checkAsset', 'divCalibration', 'fileAssetCalibration')">
                        <label class="form-check-label" for="checkAsset">Calibración</label>
                        
                      </div>
                    </div>
                    
                    <div class="col-md-4" id="divCalibration" style="display: none">
                      <div class="form-group">
                        <label for="inputCalibrationDayAsset">Fecha de Calibración</label>
                        <input type="date" class="form-control" id="inputCalibrationDayAsset" name="inputCalibrationDayAsset" required>
                      </div>
                      <div class="form-group">
                        <label for="fileAssetCalibration" class="form-label">Documentos de Calibración</label>
                        <input class="form-control" type="file" id="fileAssetCalibration" name="fileAssetCalibration" multiple>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="fileAsset" class="form-label">Documentos Generales</label>
                        <input class="form-control" type="file" id="fileAsset" name="fileAsset" multiple>
                      </div>
                    </div>
                </div>

            </form>
          </div>
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" onclick="saveAsset();">Guardar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
    </div>
</div>

<!-- Modal Nueva Asset -->
<div class="modal fade" id="ModalEditAsset" tabindex="-1" aria-labelledby="ModalEditAsset" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Activo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <input type="hidden" name="hidAsset" id="hidAsset">
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <form id="formRegisterMinute">
              @csrf
                <div class="row">
                  <h4>Datos de Activo</h4>
                </div>
                  
                <div class="row" style="background-color: #17a2b8">
                  
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="inputEditDescriptionAsset">Descripción</label>
                        <textarea class="form-control" id="inputEditDescriptionAsset" name="inputEditDescriptionAsset" rows="5" cols="5"></textarea>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="inputEditCostoAsset">Costo</label>
                        <input type="number" class="form-control" id="inputEditCostoAsset" name="inputEditCostoAsset">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="inputEditBuyAsset">Fecha de Compra</label>
                        <input type="date" class="form-control" id="inputEditBuyAsset" name="inputEditBuyAsset" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="checkEditAsset" name="checkEditAsset" onclick="muestraOculta('checkEditAsset','divEditCalibration', 'fileEditAssetCalibration');">
                        <label class="form-check-label" for="checkEditAsset">Calibración</label>
                        
                      </div>
                    </div>
                    
                    <div class="col-md-4" id="divEditCalibration" style="display:none">
                      <div class="form-group">
                        <label for="inputEditCalibrationDayAsset">Fecha de Calibración</label>
                        <input type="date" class="form-control" id="inputEditCalibrationDayAsset" name="inputEditCalibrationDayAsset" required>
                      </div>
                      <div class="form-group">
                        <label for="fileEditAssetCalibration" class="form-label">Documentos de Calibración</label>
                        <input class="form-control" type="file" id="fileEditAssetCalibration" name="fileEditAssetCalibration" multiple>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="fileEditAsset" class="form-label">Documentos Generales</label>
                        <input class="form-control" type="file" id="fileEditAsset" name="fileEditAsset" multiple>
                      </div>
                    </div>
                </div>

            </form>
          </div>
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" onclick="updateAsset();">Guardar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
    </div>
</div>