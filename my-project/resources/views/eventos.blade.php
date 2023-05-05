@extends('layouts.app')
@section('content')

<h2 class="center">Eventos</h2>
<table class="striped centered responsive-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Evento</th>
            <th>Puestos</th>
            <th>Disponible</th>
            <th>Ocupado</th>
            <th>Generado</th>
            <th>Acción</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($eventos as $item)
        <tr>
            <td>
                {{$item->id}}
            </td>
            <td>
                {{$item->nombre}}
            </td>
            <td>
                {{$item->puestos_totales}}
            </td>
            <td>
                {{$item->puestos_disponibles}}
            </td>
            <td>
                {{$item->puestos_ocupados}}
            </td>
             <td>
                {{$item->created_at}}
            </td>
            <td>
                <a href="{{route('puestos',["id"=>$item->id])}}" class="btn green">Ver</a>
                <a href="{{route('eventos.destroy',["id"=>$item->id])}}" class="btn red">Eliminar</a>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>
<div>
    {{$eventos->links()}}
</div>
<div class="fixed-action-btn">
    <a class="btn-floating btn-large green  modal-trigger" href="#create">
        <i class="material-icons">add</i>
    </a>
</div>
  <!-- Modal Structure -->
  <div id="create" class="modal modal-fixed-footer" style="min-width:50vw;min-height:50vh">
    <div class="modal-content">
      <h4>Crear Evento</h4>
        <form id='data' class="row">
            <div class="input-field col s12 m6">
                <input id="nombre" type="text" class="validate" name="nombre">
                <label for="nombre">Nombre</label>
            </div>
            <div class="input-field col s12 m6">
                <input id="descripcion" type="text" class="validate" name="descripcion">
                <label for="descripcion">Descripcion</label>
            </div>
            <div class="input-field col s12 m6">
                <input id="lugar" type="text" class="validate" name="lugar">
                <label for="lugar">Lugar</label>
            </div>
            <div class="input-field col s12 m6">
                <input id="precio" type="number" class="validate" name="precio">
                <label for="precio">Precio</label>
            </div>
            <div class="col s12">
                <h5>Para el esquema de puestos</h5>
            </div>
            <div class="input-field col s12 m6">
                <input id="columnas" type="number" class="validate" name="columnas">
                <label for="columnas">Columnas</label>
            </div>
            <div class="input-field col s12 m6">
                <input id="filas" type="number" class="validate" name="filas">
                <label for="filas">Filas</label>
            </div>
        </form>
    </div>
    <div class="modal-footer">
      <a class="waves-effect waves-green btn green" onclick="crear()">Crear</a>
      <a href="#!" class="modal-close waves-effect waves-red btn red">Salir</a>
    </div>
  </div>
<script>
$(document).ready(function(){
    $('.modal').modal();
});
const crear=()=>{
    let data=$('#data').serialize();
    $.ajax({
        url:'/api/eventos',
        method:'POST',
        data:data,
        success:(res)=>{
            //M.toast({html: 'Evento creado',classes:'green'});
            $(".modal").modal('close');
            window.location="/eventos";
        },
        error:(err)=>{
             //M.toast({html: 'Evento creado',classes:'red'});
        }
    });
}
</script>
@endsection
