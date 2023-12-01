function confirmarUsuario(){

    let usuario = document.getElementById("txtUsuario").value;
    let contrasena = document.getElementById("txtContrasena").value;
  
        if(usuario.length == 0 && contrasena==0){
            return Swal.fire(
                'Mensaje de advertencia',
                'Los Campos usuario y contraseña son obligatorios',
                'warning'
              );
        }else if(usuario.length==0){
            return Swal.fire(
                'Mensaje de advertencia',
                'Ingrese el usuario para iniciar sessión',
                'warning'
              );
        }else if(contrasena.length==0){
            return Swal.fire(
                'Mensaje de advertencia',
                'Ingrese la contraseña para iniciar sessión',
                "warning")
        }

        $.ajax({
            url:'../controlador/usuario/controllerUsuarioConfirmar.php',
            type:"POST",
            data:{
                usuario,
                contrasena
            }

        }).done(resp => {
            if(resp==0){
            //Swal.fire("Mensaje de Error","Usuario y/o Contraseña Incorrecta","error")
            $.ajax({
                url: "../controlador/usuario/controllerIntentosUsuario.php",
                type:'POST',
                data:{
                    usuario
                }

            }).done(function(resp){
                    var intentos=parseInt(resp)+1;
                    var cont = 3-intentos;
                    if(resp<2){
                        
                        Swal.fire('Mensaje de Advertencia',`Usuario y/o Contraseña Incorrecta, intentos fallidos: ${intentos}, le quedan 
                        ${cont} intentos para acceder a su cuenta`, 'warning')
                    }
                    else{
                        
                        Swal.fire('Mensaje de Advertencia',`Usuario y/o Contraseña Incorrecta, intentos fallidos: ${intentos} ,para 
                        acceder a su cuenta restablezca su contraseña`, 'warning')
                }
            })
            }else{
                let data=JSON.parse(resp);
                if(data[0][5]==="inactivo"){
                    return Swal.fire("Mensaje de Advertecia",`Lo sentimos el usuario ${usuario} se encuentra inactivo 
                    comuniquese con el administrador`,"warning")
                }
            if(data[0][7]==2){
               return Swal.fire('Mensaje de Advertencia', `Su cuenta se encuentra actualmente bloqueada, 
                            para desbloquear restablezca su contraseña`,'warning');
            }

            
                $.ajax({
                    url:'../controlador/usuario/controllerSession.php',
                    type:"POST",
                    data:{
                        idusuario:data[0][0],
                        usuario:data[0][1],
                        rol:data[0][6],
                    }
                }
                ).done( resp => {
                    let timerInterval
                        Swal.fire({
                        title: 'Bienveido al Sistema',
                        html: 'En unos momentos sera redirrecionado <b></b> milliseconds.',
                        timer: 1000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading()
                            const b = Swal.getHtmlContainer().querySelector('b')
                            timerInterval = setInterval(() => {
                            b.textContent = Swal.getTimerLeft()
                            }, 100)
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                        }).then((result) => {
                        /* Read more about handling dismissals below */
                        if (result.dismiss === Swal.DismissReason.timer) {
                            location.reload()
                        }
                        })

                })
        
        
            }
        
        })

}

var  table;
function listarUsuario(){
   table = $("#tabla_usuario").DataTable({
       "ordering":false,
       "paging": false,
       "searching": { "regex": true },
       "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
       "pageLength": 100,
       "destroy":true,
       "async": false ,
       "processing": true,
       "ajax":{
           "url":"../controlador/usuario/controllerListarUsuario.php",
           type:'POST'
       },
       "columns":[
           {"data":"posicion"},
           {"data":"nombre"},
           {"data":"nombre_rol"},
           {"data":"sexo",
           render: function (data, type, row ) {
               if(data=='M'){
                   return "MASCULINO";                   
               }else{
                 return "FEMENINO";                 
               }
             }
           }, 
           {"data":"estado",
           render: function (data, type, row ) {
               if(data=='activo'){
                   return "<span class='label label-success'>"+data+"</span>";                   
               }else{
                 return "<span class='label label-danger'>"+data+"</span>";                 
               }
             }
           },  
           {
            "defaultContent":`
            <button style='font-size:13px;' type='button' class='editar btn btn-primary'><i class='fa fa-edit'></i></button>&nbsp;
            <button style='font-size:13px;' type='button' class='desactivar btn btn-danger'><i class='fa fa-trash'></i></button>&nbsp;
           <button style='font-size:13px;' type='button' class='activar btn btn-success'><i class='fa fa-check'></i></button>`
           },
       ],
   
   });


   document.getElementById("tabla_usuario_filter").style.display="none";
   $('input.global_filter').on( 'keyup click', function () {
    filterGlobal();
} );
$('input.column_filter').on( 'keyup click', function () {
    filterColumn( $(this).parents('tr').attr('data-column') );
});
}

/////////////////funcion para desactiar usuario
$('#tabla_usuario').on('click','.desactivar', function(){
    var data=table.row($(this).parents('tr')).data();
    if(table.row(this).child.isShown())
    {
        var data=table.row(this).data();
    }
    if(data.estado=="activo"){
    Swal.fire({
        title: `Esta seguro de desactiar al usuario ${data.nombre} ?`,
        text: "Una vez hecho esto, el usuario no tendra acceso al sistema",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si'
      }).then((result) => {
        if (result.isConfirmed) {
                modificarEstadoUsuario(data.id,data.nombre,"inactivo")

        }
      })
    }else{
        Swal.fire("Mesaje de Advertencia", "El usuario ya se encuentra desactivado","warning")
    }
})


////activar
$('#tabla_usuario').on('click','.activar', function(){
    var data=table.row($(this).parents('tr')).data();
    if(table.row(this).child.isShown())
    {
        var data=table.row(this).data();
    }
    if(data.estado=="inactivo"){
    Swal.fire({
        title: `Esta seguro de activar al usuario ${data.nombre} ?`,
        text: "Una vez hecho esto, el usuario tendra acceso al sistema",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si'
      }).then((result) => {
        if (result.isConfirmed) {
            modificarEstadoUsuario(data.id,data.nombre,"activo")

        }
      })
    }else{
        Swal.fire("Mesaje de Advertencia", "El usuario ya se encuentra activo","warning")
    }
    
})


function modificarEstadoUsuario(idusuario,nombre,estado){
    let mensaje=""
    if(estado=='inactivo'){
        mensaje="desactivo"
    }else{
        mensaje="activo"
    }
    $.ajax({
        "url":"../controlador/usuario/controllerModificarEstadoUsuario.php",
        type: 'POST',
        data: {
            idusuario,
            estado,
            
        }
    }).done(resp => {
        if(resp>0){
            Swal.fire("Mensaje de Confirmacion",`El usuario ${nombre} se ${mensaje} con exito`,"success")
                .then((value)=>{
               
                    table.ajax.reload();
                  
                });
        }
       
    })



}

////////////////////////fin para desactivar al usuario//////////////////////////////////////////

//////////////////////inicio del codigo de editar///////////////////////////

$('#tabla_usuario').on('click','.editar', function(){
    var data=table.row($(this).parents('tr')).data();
    if(table.row(this).child.isShown())
    {
        var data=table.row(this).data();
    }
    $("#modal_editar_usuario").modal({backdrop:'static',Keyboard:false})
    $("#modal_editar_usuario").modal('show');
    $("#idusuario").val(data.id)
    $("#txtUsuario_edit").val(data.nombre)
    $("cbm_sexo_edit").val(data.sexo).trigger("change");
    $("cbm_rol_edit").val(data.rol).trigger("change");

})

function editarUsuario(){

    var idusuario=document.getElementById("idusuario").value
    var sexo=document.getElementById("cbm_sexo_edit").value
    var rol=document.getElementById("cbm_rol_edit").value
    

    if(idusuario.length==0 || sexo.length==0 || rol.length==0){
        return Swal.fire("Mensaje de Advertencia","Todos los campos son obligatorios","warning")
    }

    $.ajax({
        "url":"../controlador/usuario/controllerEditarUsuario.php",
        type: 'POST',
        data: {
            idusuario,
            sexo,
            rol
        }
    }).done(resp => {
        if(resp>0){
                $("#modal_editar_usuario").modal('hide');
                Swal.fire("Mensaje de Confirmacion","Datos del usuario correctamete actualizados","success")
                .then((value)=>{
                    table.ajax.reload();
                    datosUsuario();
                   
                });
        }else{
            return Swal.fire("Mensaje de Error","Lo sentimos, no se puede actualizar datos del usuario","error")
        }
    })
}


/////////////////////fin del codigo editar/////////////

function filterGlobal() {
    $('#tabla_usuario').DataTable().search(
        $('#global_filter').val(),
    ).draw();
    }
    
function abrirModalRegistro(){
    $("#modal_usuario").modal({backdrop:'static',Keyboard:false})
    $("#modal_usuario").modal('show');
    }

function listarComboRol(){
    $.ajax({
        "url":"../controlador/usuario/controllerListarComboRol.php",
        type:'POST'
    }).done(function (resp){
        var data=JSON.parse(resp);
        
        var cadena="";
        if(data.length>0){
            for(var i=0; i < data.length; i++){
                //cadena +="<option value='"+data[i][0]+"'>"+data[i][1]+"</option>"
               cadena +=`<option value=${data[i][0]}>${data[i][1]}</option>`
            }
            $("#cbm_rol").html(cadena)
            $("#cbm_rol_edit").html(cadena)

        }else{
            cadena+="<option value=''>No se encontraron Registros</option>";
            $("#cbm_rol").html(cadena)
            $("#cbm_rol_edit").html(cadena)
        }

    })
}


function registrarUsuario(){

    var usuario=document.getElementById("txtUsuario").value
    var contrasena=document.getElementById("txtContrasena").value
    var contrasena2=document.getElementById("txtContrasena2").value
    var sexo=document.getElementById("cbm_sexo").value
    var rol=document.getElementById("cbm_rol").value

    if(usuario.length==0 || contrasena.length==0 || contrasena2==0|| sexo.length==0 || rol.length==0){
        return Swal.fire("Mensaje de Advertencia","Todos los campos son obligatorios","warning")
    }
    if(contrasena!=contrasena2){
        return Swal.fire("Mensaje de Advertencia","Las Contraseña deben coincidir","warning")
    }

    $.ajax({
        "url":"../controlador/usuario/controllerRegistrarUsuario.php",
        type: 'POST',
        data: {
            usuario,
            contrasena,
            sexo,
            rol
        }
    }).done(resp => {
        if(resp>0){
            if(resp==1){
                $("#modal_usuario").modal('hide');
                Swal.fire("Mensaje de Confirmacion","Datos Correctamente, Nuevo Usuario Registrado","success")
                .then((value)=>{
                    limpiarCamposUsuario();
                    table.ajax.reload();
                   
                });
            }else{
                return Swal.fire("Mensaje de Advertencia",`El Usuario ${usuario} ya se encuentra registrado`,"warning")
            }
        }else{
            return Swal.fire("Mensaje de Error","Lo sentimos, no se puede completar el registro","error")
        }
    })



}


function limpiarCamposUsuario(){
    $("#txtUsuario").val("")
    $("#txtContrasena").val("")
    $("#txtContrasena2").val("")
}

var contra;
function datosUsuario(){
    var usuario=document.getElementById("usuarioPrincipal").value;
    $.ajax({
        "url":"../controlador/usuario/controllerTraerDatosUsuario.php",
        type: 'POST',
        data:{
            usuario:usuario
        }

    }).done(function(resp){

        var data=JSON.parse(resp);
        contra=data[0][2];
        if(data.length>0){
            if(data[0][3]==="M"){
                $("#img_nav").attr("src","../plantillas/dist/img/avatar5.PNG");
                $("#img_subnav").attr("src","../plantillas/dist/img/avatar5.PNG");
                $("#img_lateral").attr("src","../plantillas/dist/img/avatar5.PNG");
            }else{
                $("#img_nav").attr("src","../plantillas/dist/img/avatar3.png");
                $("#img_subnav").attr("src","../plantillas/dist/img/avatar3.png");
                $("#img_lateral").attr("src","../plantillas/dist/img/avatar3.png");
            }
        }
    })
}

function abrirModalPassword(){
    $('#modalEditarPass').modal({backdrop:'static', Keyboard:false})
    $('#modalEditarPass').modal('show')
    $('#modalEditarPass').on('shown.bs.modal',()=>{
        $("#txtContrasenaActual").focus()
      })
}


//inicio funcion para modificar contraseña y limpiar cammpos/////////////
function modificarContraseña(){
    var idusuario=$("#txtidPrincipal").val()
    var passActual=$("#txtContrasenaActual").val()
    var passNueva=$("#txtNuevaContrasena").val()
    var passNueva2=$("#txtNuevaContrasena2").val()
    if(passActual.length==0 || passNueva.length==0 || passNueva2.length==0){
        return Swal.fire('Mensaje de Advertencia','Todos los campos son obligatorios','warning')
    }
    if(passNueva!=passNueva2){
        return Swal.fire('Mensaje de Advertencia','Debes ingresar las contraseñas igual dos veces para confirmarla','warning')
    }
    $.ajax({
        url:"../controlador/usuario/controllerModificarPass.php",
        type: 'POST',
        data:{
            idusuario,
            contra,
            passActual,
            passNueva
        }

    }).done( resp => {
        if(resp > 0){
            if(resp==1){
                $("#modalEditarPass").modal('hide');
                limpiarCamposPass()
                Swal.fire("Mensaje de Confirmacion",`La contraseña fue actualizada exitosamente`,"success")
                .then((value)=>{
                    datosUsuario();
                  
                })
            }else{
                Swal.fire('Mensaje de error','La contraseña actual no coincide con la que se encuentra en la base de datos ','error')
            }


        }else{
            Swal.fire('Mensaje de error','La contraseña no se pudo actualizar','error')
        }
    })
}
function limpiarCamposPass(){
    $("#txtContrasenaActual").val("")
    $("#txtNuevaContrasena").val("")
    $("#txtNuevaContrasena2").val("")
}

function abrirModalRestablecer(){
    $('#modalRestablecerPass').modal({backdrop:'static', Keyboard:false})
    $('#modalRestablecerPass').modal('show')
    $('#modalRestablecerPass').on('shown.bs.modal',()=>{
        $("#txtConfirmarCorreo").focus()
      })
}


function restablecer_contra(){
    const correo =document.getElementById('txtConfirmarCorreo').value;

    if(correo.length==0){
        return Swal.fire('Mensaje de Advertencia','Ingrese su correo para restablecer su contraseña', 'warning')
    }

    var caracteres="abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ1234567890"
    var pass="";
    for(var i=0;i<6;i++){
        pass += caracteres.charAt(Math.floor(Math.random()*caracteres.length))
    }
    $.ajax ({
        url:'../controlador/usuario/controllerRestablecerPass.php',
        type:'POST',
        data:{
            correo,
            pass
        }
    }).done(function(resp){
        if(resp > 0){
            if(resp==1){
                $("#modalRestablecerPass").modal('hide');
                Swal.fire('Mensaje de Confirmacion',`Su contraseña se restablecio al correo: ${correo} con exito`,'success')
            }else{
                Swal.fire('Mensaje de Advertencia', 'El correo no se encuntra registrado','warning')
            }
        }else{
            Swal.fire('Mensaje de Advertencia','No se pudo restablecer su contraseña','warning')
        }
    })
}

