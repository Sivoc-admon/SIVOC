 <!-- Modal -->
 <div class="modal fade" id="ModalRegisterUser" tabindex="-1" aria-labelledby="ModalRegisterUser" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registro Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <form id="formRegisterUser">
              @csrf
                <div class="row">
                  <h4>Datos Empleado</h4>
                </div>
                  
                <div class="row" style="background-color: #17a2b8">
                  
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="inputName">Nombre</label>
                        <input type="text" class="form-control" id="inputName" name="inputName" placeholder="Nombre" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="inputLastName">Apellido Paterno</label>
                        <input type="text" class="form-control" id="inputLastName" name="inputLastName" placeholder="Apellido Paterno" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="inputMotherLastName">Apellido Materno</label>
                        <input type="text" class="form-control" id="inputMotherLastName" name="inputMotherLastName" placeholder="Apellido Materno" required>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="inputEmail">Email</label>
                        <input type="email" class="form-control" id="inputEmail" name="inputEmail" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="inputPassword">Contraseña</label>
                        <input type="password" class="form-control" id="inputPassword" name="inputPassword" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="sltArea">Area</label>
                        <select class="form-control" id="sltArea" name="sltArea" required>
                          <option value="0">---</option>
                          @foreach ($areas as $area)
                            <option value="{{ $area->id }}">{{ $area->name }}</option>
                              
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="inputRole">Role</label>
                        <select class="form-control" id="inputRole" name="inputRole" required>
                          <option value="0">---</option>
                          @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                
                            @endforeach
                        </select>
                      </div>
                    </div>
                </div>
               

                <!-- <div class="row">
                  <h4>Antecedentes Académicos</h4>
                </div>
                <div class="row">
                  <h4>Datos Personales</h4>
                </div>
                <div class="row" style="background-color: #5da1acc2">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="inputEdad">Edad</label>
                      <input type="number" class="form-control" id="inputEdad" name="inputEdad">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="inputGenero">Genero</label>
                      <select class="form-control" name="sltGenero" id="sltGenero">
                        <option value="">Seleccione Genero</option>
                        <option value="Hombre">Hombre</option>
                        <option value="Mujer">Mujer</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="inputEstadoCivil">Estado Civil</label>
                      <input type="text" class="form-control" id="inputEstadoCivil" name="inputEstadoCivil">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="inputNSS">NSS</label>
                      <input type="number" class="form-control" id="inputNSS" name="inputNSS">
                    </div>
                  </div>
                  
                </div> -->

            </form>
          </div>
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" onclick="saveUser();">Guardar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
    </div>
</div>