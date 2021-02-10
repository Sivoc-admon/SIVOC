<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registro proyecto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
                <form method="POST" id="formRegisterProject">
                  @csrf
                    <div class="row">
                      <h4>Datos de Proyecto</h4>
                    </div>
                      
                    <div class="row" style="background-color: rgb(144, 240, 144)">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="sltTypeProject">Tipo</label>
                          <select class="form-control" id="sltTypeProject" name="sltTypeProject" placeholder="Tipo de proyecto" required>
                            <option value="0">---</option>
                            <option value="PE">PUESTA EN MARCHA</option>
                            <option value="PO">OPERACIONAL</option>
                          </select>
                        </div>
                      </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="inputProyecto">Referencia de proyecto</label>
                            <input type="text" class="form-control" id="inputProyecto" name="inputProyecto" placeholder="Nombre del proyecto" required>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="sltCliente">Cliente</label>
                            <select class="form-control" name="sltCliente" id="sltCliente">
                                <option value="0">---</option>
                                @foreach ($customers as $customer)
                                 <option value="{{$customer->id}}">{{$customer->name}}</option>
                                @endforeach
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

                </form>
              </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success" onclick="saveProject()">Guardar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>

