 <!-- Modal -->
 <div class="modal fade" id="ModalCreateFolder" tabindex="-1" aria-labelledby="ModalRegisterUser" aria-hidden="true"
 data-controls-modal="ModalCreateFolder" data-backdrop="static" data-keyboard="false">
     <div class="modal-dialog modal-md modal-dialog-scrollable">
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
                             <h4>Crear nueva carpeta</h4>
                         </div>

                         <input type="hidden" id="nivelFolder">
                         <input type="hidden" id="areaIdFolder">

                         <div class="row" style="background-color: #17a2b8">
                             <div class="col-md-12">
                                 <div class="form-group">
                                     <label for="inputName">Nombre de la carpeta</label>
                                     <input type="text" class="form-control" id="inputName" name="inputName" placeholder="Nombre" required>
                                 </div>
                             </div>
                         </div>
                     </form>
                 </div>

             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-success">Guardar</button>
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
             </div>
         </div>
     </div>
 </div>