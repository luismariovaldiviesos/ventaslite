<div class="row sales layout-top-spacing">

    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal" data-target="#theModal">Agregar</a>
                    </li>
                </ul>
            </div>
            @include('common.searchbox')

            <div class="widget-content">

                <div class="table-responsive">
                    <table class="table table-bordered table striped mt-1">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-white">NOMBRE</th>
                                <th class="table-th text-white text-center">RUC</th>
                                <th class="table-th text-white text-center">TELEFONO</th>
                                <th class="table-th text-white text-center">DIRECCION</th>
                                <th class="table-th text-white text-center">EMAIL</th>
                                 <th class="table-th text-white text-center">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $r)
                            <tr>
                                <td><h6>{{$r->nombre}}</h6></td>
                                <td class="text-center"><h6>{{$r->ruc}}</h6></td>
                                <td class="text-center"><h6>{{$r->telefono}}</h6></td>
                                <td class="text-center"><h6>{{$r->direccion}}</h6></td>
                                <td class="text-center"><h6>{{$r->email}}</h6></td>
                             <td class="text-center">
                                <a href="javascript:void(0)"
                                wire:click="edit({{$r->id}})"
                                class="btn btn-dark mtmobile" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            <a href="javascript:void(0)"
                            onclick="Confirm('{{$r->id}}')"
                            class="btn btn-dark" title="Delete">
                            <i class="fas fa-trash"></i>
                            </a>



                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{$data->links()}}
    </div>

</div>


</div>


</div>

@include('livewire.cliente.form')
</div>


<script>
    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('cliente-added', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('cliente-updated', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('cliente-deleted', Msg => {
            noty(Msg)
        })
        window.livewire.on('hide-modal', Msg => {
            $('#theModal').modal('hide')
        })
        window.livewire.on('show-modal', Msg => {
            $('#theModal').modal('show')
        })
        window.livewire.on('user-withsales', Msg => {
            noty(Msg)
        })

    });

    function Confirm(id)
    {

        swal({
            title: 'CONFIRMAR',
            text: '¿CONFIRMAS ELIMINAR EL REGISTRO?',
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#fff',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if(result.value){
                window.livewire.emit('deleteRow', id)
                swal.close()
            }

        })
    }
</script>
