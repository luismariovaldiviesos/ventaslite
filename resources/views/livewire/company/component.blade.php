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
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label >Razón Social</label>
                            <input type="text" wire:model.lazy="razonSocial" class="form-control">
                            @error('razonSocial') <span class="text-danger er">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label >Nombre Comercial</label>
                            <input type="text" wire:model.lazy="nombreComercial" class="form-control">
                            @error('nombreComercial') <span class="text-danger er">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <label >RUC</label>
                            <input type="text" wire:model.lazy="ruc" class="form-control" placeholder="ej:0101049643001" maxlength="13">
                            @error('ruc') <span class="text-danger er">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <label >Establecimiento</label>
                            <input type="text" wire:model.lazy="estab" class="form-control" placeholder="ej:001" maxlength="3">
                            @error('estab') <span class="text-danger er">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <label >Pto Emision</label>
                            <input type="text" wire:model.lazy="ptoEmi" class="form-control" placeholder="ej:001" maxlength="3">
                            @error('ptoEmi') <span class="text-danger er">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label >Matriz</label>
                            <input type="text" wire:model.lazy="dirMatriz" class="form-control">
                            @error('dirMatriz') <span class="text-danger er">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label >Sucursal</label>
                            <input type="text" wire:model.lazy="dirEstablecimiento" class="form-control">
                            @error('dirEstablecimiento') <span class="text-danger er">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <label >Teléfono</label>
                            <input type="text" wire:model.lazy="telefono" class="form-control" maxlength="10">
                            @error('telefono') <span class="text-danger er">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <label >Email</label>
                            <input type="text" wire:model.lazy="email" class="form-control">
                            @error('email') <span class="text-danger er">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <label >Ambiente</label>
                            <input type="text" wire:model.lazy="ambiente" class="form-control" maxlength="1">
                            @error('ambiente') <span class="text-danger er">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <label >Emisión</label>
                            <input type="text" wire:model.lazy="tipoEmision" class="form-control" maxlength="1">
                            @error('tipoEmision') <span class="text-danger er">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <label >Cont Espcial</label>
                            <input type="text" wire:model.lazy="contribuyenteEspecial" class="form-control">
                            @error('contribuyenteEspecial') <span class="text-danger er">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <label >Contabilidad</label>
                            <input type="text" wire:model.lazy="obligadoContabilidad" class="form-control" maxlength="2">
                            @error('obligadoContabilidad') <span class="text-danger er">{{ $message }}</span> @enderror
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
