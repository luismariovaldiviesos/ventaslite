@include('common.modalHead')

<div class="row">

    <div class="col-sm-12 col-md-8">
        <div class="form-group">
            <label >Nombre</label>
            <input type="text" wire:model.lazy="name"
            class="form-control product-name" placeholder="ej: taco bajo" autofocus >
            @error('name') <span class="text-danger er">{{ $message}}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label >Código</label>
            <input type="text" wire:model.lazy="barcode"
            class="form-control"
            {{ $selected_id > 0 ? 'disabled' : '' }}
            placeholder="ej: 025974" >
            @error('barcode') <span class="text-danger er">{{ $message}}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label >Costo</label>
            <input type="text" data-type='currency' wire:model.lazy="cost" class="form-control" placeholder="ej: 0.00" >
            @error('cost') <span class="text-danger er">{{ $message}}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label >Precio</label>
            <input type="text" data-type='currency' wire:model.lazy="price" class="form-control" placeholder="ej: 0.00" >
            @error('price') <span class="text-danger er">{{ $message}}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label >Stock</label>
            <input type="number"  wire:model.lazy="stock" class="form-control" placeholder="ej: 0" >
            @error('stock') <span class="text-danger er">{{ $message}}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label >Alertas</label>
            <input type="number"  wire:model.lazy="alerts" class="form-control" placeholder="ej: 10" >
            @error('alerts') <span class="text-danger er">{{ $message}}</span>@enderror
        </div>
    </div>


    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Categoría</label>
            <select wire:model='categoryid' class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                @foreach($categories as $category)
                <option value="{{$category->id}}" >{{$category->name}}</option>
                @endforeach
            </select>
            @error('categoryid') <span class="text-danger er">{{ $message}}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-12">
        <div class="form-group">
            <label>Impuestos</label>
            @foreach($impuestos as $impuesto)
            <div class="mt-1">
                   <label class="inline-flex items-center">
                   <input type="checkbox" value="{{ $impuesto->id }}" wire:model="selectedImpuestos"  class="form-checkbox h-6 w-6 text-green-500">
                        <span class="ml-3 text-sm">{{$impuesto->nombre}} {{$impuesto->porcentaje}}%</span>
                    </label>
               </div>
            @endforeach
            @error('categoryid') <span class="text-danger er">{{ $message}}</span>@enderror
        </div>
    </div>
</div>

{{-- <div class="row mt-3">
    <div class="col-sm-12">
        <div class="table-responsive">
            <table class="table table-bordered table striped mt-1">
                <thead class="text-white" style="background: #3B3F5C">
                    <tr>
                        <th class="table-th text-white text-center">ID</th>
                        <th class="table-th text-white text-center">NOMBRE</th>
                        <th class="table-th text-white text-center">PORCENTAJE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($impuestos as $impuesto)
                    <tr>
                        <td><h6 class="text-center">{{$impuesto->id}}</h6></td>
                        <td class="text-center">
                            <div class="n-check">
                                <label class="new-control new-checkbox checkbox-primary">
                                    <input type="checkbox"
                                    wire:change="syncPermiso($('#p' + {{ $impuesto->id }}).is(':checked'), '{{ $impuesto->nombre}}' )"
                                    id="p{{ $impuesto->id }}"
                                    value="{{ $impuesto->id }}"
                                    class="new-control-input"
                                    {{ $impuesto->checked == 1 ? 'checked' : '' }}
                                    >
                                    <span class="new-control-indicator"></span>
                                    <h6>{{ $impuesto->nombre}}</h6>
                                </label>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div> --}}



@include('common.modalFooter')
