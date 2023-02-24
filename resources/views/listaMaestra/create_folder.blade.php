<!-- Modal  REGISTRAR LISTA MAESTRA-->
<div class="modal fade bd-example-modal-lg" id="modalCreateFolder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Registro lista maestra</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
          </div>
          <div class="modal-body">
              <div class="container-fluid">
                  <form method="POST" id="formCreateFolder">
                    @csrf
                      <div class="row">
                        <h4>Datos de Proyecto</h4>
                      </div>

                      <div class="row" style="background-color: rgb(144, 240, 144)">
                        <div class="col-md-4">
                          <div class="form-group">
                            <input type="hidden" name="hiddenInputIdPadre" id="hiddenInputIdPadre" value="0">
                            <label for="sltProyecto">Proyecto</label>
                            <select class="form-control" name="sltProyecto" id="sltProyecto">
                                <option value="0">---</option>
                                @foreach ($projects as $project)
                                  <option value="{{$project->id}}">{{$project->name_project}}-{{$project->name}}</option>
                                @endforeach
                            </select>
                          </div>
                        </div>

                      </div>

                  </form>
                </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success" onclick="saveFolder()">Crear</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
      </div>
    </div>
</div>

<!-- Modal  EDITA LISTA MAESTRA-->
<div class="modal fade bd-example-modal-lg" id="modalEditMaterial" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" id="formCreateFolder">
                    @csrf
                        <div class="row">
                            <h4>Datos de Material</h4>
                        </div>

                        <div class="row" style="background-color: rgb(144, 240, 144)">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="hidden" name="hideFolio" id="hideFolio">
                                    <label for="sltProyecto">Folio</label>
                                    <select class="form-control" name="sltFolioMaterial" id="sltFolioMaterial" disabled>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="txtDescripcionMaterial">Descripción</label>
                                    <textarea name="txtDescripcionMaterial" id="txtDescripcionMaterial" class="form-control" cols="10" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="txtModeloMaterial">Modelo</label>
                                    <input type="text" name="txtModeloMaterial" id="txtModeloMaterial" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="background-color: rgb(144, 240, 144)">
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label for="txtFabricante">Fabricante</label>
                                  <input type="text" name="txtFabricanteMaterial" id="txtFabricanteMaterial" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label for="txtCantidadMaterial">Cantidad</label>
                                  <input type="number" name="txtCantidadMaterial" id="txtCantidadMaterial" class="form-control" min="1">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sltUnidadMaterial">Unidad</label>
                                    <select class="form-control" name="sltUnidadMaterial" id="sltUnidadMaterial" disabled>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="background-color: rgb(144, 240, 144)">
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label for="sltProyecto">Tipo de Accion</label>
                                  <select class="form-control" name="sltAccion" id="sltAccion" onChange="habilitaInput()">
                                      <option value="0">Seleccione Accion</option>
                                      <option value="Editar">Editar</option>
                                      <option value="Cambiar">Cambiar</option>
                                  </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success" onclick="modificarMaterial()">Editar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
      </div>
    </div>
</div>
