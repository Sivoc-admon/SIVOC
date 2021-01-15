<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registro proyecto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
                <form method="POST" action="projects">
                  @csrf
                    <div class="row">
                      <h4>Datos de Proyecto</h4>
                    </div>
                      
                    <div class="row" style="background-color: rgb(144, 240, 144)">
                      
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="inputProyecto">Proyecto</label>
                            <input type="text" class="form-control" id="inputProyecto" name="inputProyecto" placeholder="Nombre del proyecto" required>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="sltCliente">Cliente</label>
                            <select class="form-control" name="sltCliente" id="sltCliente">
                                <option value="1">francisco</option>
                                <option value="2" selected>Miguel</option>
                                <option value="3">Fernando</option>
                                <option value="4">Isabel</option>
                                <option value="5">Norma</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="inputEstatus">Estatus</label>
                            <input type="text" class="form-control" id="inputEstatus" name="inputEstatus" value="Colocado" readonly required>
                          </div>
                        </div>
                    </div>
    
                    <button type="submit" class="btn btn-success btn-block">Guardar</button>
                
                </form>
              </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        </div>
    </div>
    </div>
</div>