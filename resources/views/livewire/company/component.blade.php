<div class="row sales layout-top-spacing">


    <div class="col-sm-12">

        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    DATOS DE LA EMPRESA
                </h4>

            </div>


            <div class="widget-content">

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label >Nombre</label>
                            <input type="text" wire:model.lazy="name" class="form-control">
                            @error('name') <span class="text-danger er">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label >Dirección</label>
                            <input type="text" wire:model.lazy="address" class="form-control">
                            @error('address') <span class="text-danger er">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label >Teléfono</label>
                            <input type="text" wire:model.lazy="phone" class="form-control" maxlength="10">
                            @error('phone') <span class="text-danger er">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label >RUC</label>
                            <input type="text" wire:model.lazy="ruc" class="form-control" placeholder="ej:099999999" maxlength="10">
                            @error('ruc') <span class="text-danger er">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label >Email</label>
                            <input type="text" wire:model.lazy="email" class="form-control" placeholder="ej:mails@mail.com" >
                            @error('email') <span class="text-danger er">{{ $message }}</span> @enderror
                        </div>
                    </div>

                </div>

            </div>

        </div>
        <br>
        <div>

           <button type="button" wire:click.prevent="Guardar()" class="btn btn-dark close-modal">
            Guardar
        </button>

        </div>



    </div>



   {{-- @include('livewire.permisos.form') --}}


</div>


<script>

    document.addEventListener('DOMContentLoaded', function(){



        window.livewire.on('empresa-added', Msg=> {
            noty(Msg)
        })

        window.livewire.on('permiso-exists', Msg=> {
            noty(Msg)
        })
        window.livewire.on('permiso-error', Msg=> {
            noty(Msg)
        })
        window.livewire.on('hide-modal', Msg=> {
            $('#theModal').modal('hide')
        })
        window.livewire.on('show-modal', Msg=> {
            $('#theModal').modal('show')
        })




    });

    function Confirm(id)
     {
         swal({
             title: 'CONFIRMAR',
             text: '¿ DESEA ELIMINAR EL REGISTRO ?',
             type: 'warning',
             showCancelButton: true,
             cancelButtonText: 'Cerrar',
             cancelButtonColor: '#fff',
             confirmButtonColor: '#3B3F5C',
             confirmButtonText: 'Aceptar'
         }).then(function(result){
             if(result.value)
             {
                 window.livewire.emit('destroy', id) //deleteRow va al listener del controller
                 swal.close()
             }
         })
     }

</script>
