@extends('backend.menus.superior')

@section('content-admin-css')
    <link href="{{ asset('css/adminlte.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/buttons_estilo.css') }}" rel="stylesheet">
@stop

<style>
    table{
        /*Ajustar tablas*/
        table-layout:fixed;
    }
</style>

<div id="divcontenedor" style="display: none">
    <section class="content-header">
        <div class="container-fluid">
            <div class="col-sm-12">
                <h1>Rol y Permisos</h1>
            </div>
            <br>

            <button type="button" style="font-weight: bold; background-color: #28a745; color: white !important;" value="Nuevo Rol" onclick="modalAgregar()" class="button button-3d button-rounded button-pill button-small">
                <i class="fas fa-edit"></i>
                Nuevo Rol
            </button>

            <button type="button" style="font-weight: bold; background-color: #28a745; color: white !important;" value="Lista de Permisos" onclick="vistaPermisos()" class="button button-3d button-rounded button-pill button-small">
                <i class="fas fa-list-alt"></i>
                Lista de Permisos
            </button>

           <!-- <button type="button" style="font-weight: bold; background-color: #28a745; color: white !important;" value="Actualizar" onclick="actualizarTabla()" class="button button-3d button-rounded button-pill button-small">
                <i class="fas fa-list-alt"></i>
                Actualizar Tabla
            </button>-->

        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Lista</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="tablaDatatable"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modalAgregar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nuevo Rol</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario-nuevo">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label>Nombre</label>
                                        <input type="text" maxlength="30" autocomplete="off" class="form-control" id="nombre-nuevo" placeholder="Nombre">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" style="background-color: #28a745; color: white !important;" class="button button-3d button-rounded button-pill button-small" onclick="agregarRol()">Agregar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalBorrar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Borrar Rol Global</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario-borrar">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <p>Esta acción eliminara el Rol con todos sus Permisos.</p>

                                    <div class="form-group">
                                        <input type="hidden" id="idborrar">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" style="font-weight: bold; background-color: #ff4351; color: white !important;" class="button button-3d button-rounded button-pill button-small" onclick="borrar()">Borrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

@extends('backend.menus.footerjs')
@section('archivos-js')

    <script src="{{ asset('js/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.js') }}" type="text/javascript"></script>

    <script src="{{ asset('js/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/axios.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/alertaPersonalizada.js') }}"></script>


    <!-- incluir tabla -->
    <script type="text/javascript">
        $(document).ready(function(){
            var ruta = "{{ URL::to('/admin/roles/tabla') }}";
            $('#tablaDatatable').load(ruta);
            document.getElementById("divcontenedor").style.display = "block";
        });
    </script>

    <script>

        function verInformacion(id){
            window.location.href="{{ url('/admin/roles/lista/permisos') }}/"+id;
        }

        // ver todos los permisos que existen
        function vistaPermisos(){
            window.location.href="{{ url('/admin/roles/permisos/lista') }}";
        }

        function modalAgregar(){
            document.getElementById("formulario-nuevo").reset();
            $('#modalAgregar').modal('show');
        }

        function modalBorrar(id){
            // se obtiene el id del Rol a eliminar globalmente

            $('#idborrar').val(id);
            $('#modalBorrar').modal('show');
        }

        function borrar(){
            openLoading()
            // se envia el ID del Rol
            var idrol = document.getElementById('idborrar').value;

            var formData = new FormData();
            formData.append('idrol', idrol);

            axios.post(url+'/roles/borrar-global', formData, {
            })
                .then((response) => {
                    closeLoading()
                    $('#modalBorrar').modal('hide');

                    if(response.data.success === 1){
                        toastr.success('Rol global eliminado');
                        recargar();
                    }else{
                        toastr.error('Error al eliminar');
                    }
                })
                .catch((error) => {
                    closeLoading();
                    toastr.error('Error al eliminar');
                });
        }

        function agregarRol(){
            var nombre = document.getElementById('nombre-nuevo').value;

            if(nombre === ''){
                toastr.error('Nombre es requerido')
                return;
            }

            if(nombre.length > 30){
                toastr.error('Máximo 30 caracteres para Nombre')
                return;
            }

            openLoading()
            var formData = new FormData();
            formData.append('nombre', nombre);

            axios.post(url+'/permisos/nuevo-rol', formData, {
            })
                .then((response) => {
                    closeLoading()

                    if (response.data.success === 1) {
                        toastr.error('Rol Repetido', 'Cambiar de nombre');
                    }
                    else if(response.data.success === 2){
                        $('#modalAgregar').modal('hide');
                        recargar();
                    }
                    else {
                        toastr.error('Error al guardar');
                    }
                })
                .catch((error) => {
                    closeLoading()
                    toastr.error('Error al guardar');
                });
        }

        function recargar(){
            var ruta = "{{ url('/admin/roles/tabla') }}";
            $('#tablaDatatable').load(ruta);
        }


        // PARA ACTUALIZAR TABLA DE COSTOS
        function actualizarTabla(){

            openLoading()

            axios.post(url+'/actualizartabla', {
            })
                .then((response) => {
                    closeLoading()

                    if (response.data.success === 1) {
                        toastr.success('completado');
                    }
                    else {
                        toastr.error('Error al guardar');
                    }
                })
                .catch((error) => {
                    closeLoading()
                    toastr.error('Error al guardar');
                });
        }






    </script>



@stop
