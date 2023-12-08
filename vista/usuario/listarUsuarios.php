
<script type="text/javascript" src="../js/usuario.js?rev=<?php echo time();?>"></script>
<div class="col-md-12">
    <div class="box box-success box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">BIENVENIDO AL CONTENIDO DE USUARIOS</h3>

            <div class="box-tools pull-right">
                
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="form-group">
                  <div class="col-lg-10">
                  <div class="input-group">
                        <input type="text" class="global-filter form-control" id="global-filter"    placeholder="ingresar dato a buscar">
                        <span class="input-group-addon"><i class="fa fa-search"></i></span>
                        
                  </div>
                  </div>
                  <div class="col-lg-2">
                  <button class="btn btn-danger" style="width: 100%;" onclick="abrirModalRegistro()"><i class="glyphicon glyphicon-plus" >
                    Nuevo Usuario</i>
                    </button>
                  </div>
                </div>
        <table id="tabla_usuario" class="display responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>N°</th>
                <th>Usuario</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Sexo</th>
                <th>Estatus</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
          
        </tbody>
        <tfoot>
            <tr>
                <th>N°</th>
                <th>Usuario</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Sexo</th>
                <th>Estatus</th>
                <th>Acción</th>
            </tr>
        </tfoot>
    </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>
<form autocomplete="false" onsubmit="return false">
  <div class="modal fade" id="modal_usuario" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Registro de Usuarios</h4>
        </div>
        <div class="modal-body">
          <div class="col-lg-12">
            <label for="">Usuario</label>
            <input type="text" class="form-control" id="txtUsuario" placeholder="Ingrese el Usuario">
          </div>
          <div class="col-lg-12">
            <label for="">Correo</label>
            <input type="text" class="form-control" id="txtCorreo" placeholder="Ingrese un Correo">
            
          </div>

          <div style="margin: 0 1.5rem">
          <label for="" id="correoOK" style="color:red "></label>
          <input type="text" id="validarCorreo" hidden>
          </div>
      
          <div class="col-lg-12">
            <label for="">Contraseña</label>
            <input type="password" class="form-control" id="txtContrasena" placeholder="Ingrese la Contraseña">
          </div>
          <div class="col-lg-12">
           <label for="">Repita la Contraseña</label>
            <input type="password" class="form-control" id="txtContrasena2" placeholder="Repita la Contraseña">
          </div>
          <div class="col-lg-12">
           <label for="">Sexo</label>
           <select class="js-example-basic-single" name="state" id="cbm_sexo" style="width: 100%; margin: 1rem;" >
            <option value="M">MASCULINO</option>
            <option value="F">FEMENINA</option>
          </select>
           
          </div>
          <div class="col-lg-12">
           <label for="">Rol</label>
             <select class="js-example-basic-single" name="state" id="cbm_rol" style="width: 100%; margin: 1rem;" >
            </select>
          </div>
          
        </div>
          
        <div class="modal-footer" >
          <button class="btn btn-primary" onclick="registrarUsuario()"><i class="fa fa-check">Registrar</i></button>
          <button class="btn btn-danger" type="button" data-dismiss="modal" style="margin: 1.5rem;"><i class="fa fa-close">Close</i></button>
        </div>
      </div>
    </div>
  </div>

</form>
<form autocomplete="false" onsubmit="return false">
  <div class="modal fade" id="modal_editar_usuario" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Registro de Editar Usuarios</h4>
        </div>
        <div class="modal-body">

          <input type="text" id="idusuario" hidden>
          <div class="col-lg-12">
            <label for="">Usuario</label>
            <input type="text" class="form-control" id="txtUsuario_edit" >
          </div>
          <div class="col-lg-12">
           <label for="">Sexo</label>
           <select class="js-example-basic-single" name="state" id="cbm_sexo_edit" style="width: 100%; margin: 1rem;" >
            <option value="M">MASCULINO</option>
            <option value="F">FEMENINA</option>
          </select>
           
          </div>
          <div class="col-lg-12">
           <label for="">Rol</label>
             <select class="js-example-basic-single" name="state" id="cbm_rol_edit" style="width: 100%; margin: 1rem;" >
            </select>
          </div>
          
        </div>
          
        <div class="modal-footer" >
          <button class="btn btn-primary" onclick="editarUsuario()"><i class="fa fa-check">Editar</i></button>
          <button class="btn btn-danger" type="button" data-dismiss="modal" style="margin: 1.5rem;"><i class="fa fa-close">Close</i></button>
        </div>
      </div>
    </div>
  </div>
</form>
  


<script>

    document.getElementById('txtCorreo').addEventListener('input',function(){
      campo = event.target;
      emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;

      if(emailRegex.test(campo.value)){
        $(this).css('border','')
        $('#correoOK').html('')
        $('#validarCorreo').val('correcto')
      }else{
        $(this).css('border','1px solid red')
        $('#correoOK').html('Correo incorrecto')
        $('#validarCorreo').val('incorrecto')
      }
    })



    $(document).ready( ()=>{

        listarUsuario();
        $('.js-example-basic-single').select2();
        listarComboRol()
        //para colocar el putero e el prier iput

        $("#modal_usuario").on('shown.bs.modal',()=>{
          $("#txtUsuario").focus()
        })
    });
</script>