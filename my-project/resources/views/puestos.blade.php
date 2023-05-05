@extends('layouts.app')
@section('content')

<div class="row">
@foreach($puestos as $item)
    <div class="col s3 m4 l2"
        @if($item->disponible ==true)
            onclick="agregar('{{$item->id}}','{{$item->disponible}}')"
        @else
            onclick="quitar('{{$item->id}}','{{$item->disponible}}')"
        @endif
    style="cursor:pointer">
        <section class="center">
            @if($item->disponible ==true)
                <img src="https://img.icons8.com/color/96/null/scandinavian-desk.png"/>
            @else
                <img src="https://img.icons8.com/bubbles/100/null/man-with-a-calendar.png"/>
            @endif
        </section>
        <div class="center">
            #{{$item->id}}
            <br>
            @if($item->disponible ==true)
                Disponible
            @else
                Ocupado
            @endif
            <br>
            @if($item->ticket!=null)
                <h5>
                    Ocupado por:
                    <br>
                    {{$item->ticket->nombre}}
                </h5>
            @endif
        </div>
    </div>
@endforeach
</div>

<!-- Fixed action BTN-->
<div class="fixed-action-btn">
    <a class="btn-floating btn-large red  modal-trigger" href="/eventos">
        <i class="material-icons">exit_to_app</i>
    </a>
</div>
<script>
const quitar=(id,status)=>{
Swal.fire({
  title: 'La mesa ya esta ocupada',
  text: "Desea retirar al comprador?",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Si deseo anular el ticket'
}).then((result) => {
  if (result.isConfirmed) {
         fetch("{{url('api/ocupar')}}/"+id,{
            method:"PUT",
            headers:{
                "Content-Type":"application/json"
            },
            body:JSON.stringify({
                disponible:status,
            })
        }).then(res=>res.json()).then(res=>{
            if(res.data){
                Swal.fire(
                    'Reservacion anulada',
                    'Datos actualizados',
                    'success'
                )
                window.location.reload();
            }
        }).catch(e=>{
             Swal.fire(
                'Error en conexion',
                'Contacte con el administrador',
                'error'
            )
        })
  }
})
}
const agregar =(id,status)=>{
    Swal.fire({
    title: 'Nombre del comprador',
    input: 'text',
    inputAttributes: {
        autocapitalize: 'off'
    },
    showCancelButton: true,
    confirmButtonText: 'Look up',
    showLoaderOnConfirm: true,
    preConfirm: async (nombre2) => {
    await fetch("{{url('api/ocupar')}}/"+id,{
            method:"PUT",
            headers:{
                "Content-Type":"application/json"
            },
            body:JSON.stringify({
                disponible:status,
                nombre:nombre2
            })
        }).then(res=>res.json()).then(res=>{
             allowOutsideClick: () => !Swal.isLoading()
            if(res.data){
                Swal.fire(
                    'Registro exitoso',
                    'Actualizando datos',
                    'success'
                )
                window.location.reload();
            }
        }).catch(e=>{
             allowOutsideClick: () => !Swal.isLoading()
             Swal.fire(
                'Error en conexion',
                'Contacte con el administrador',
                'error'
            )
        })
    },

});
}
</script>
@endsection
