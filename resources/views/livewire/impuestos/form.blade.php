@include('common.modalHead')

<div class="row">

<div class="col-sm-12 col-md-12">
	<div class="form-group">
		<label >Nombre</label>
		<input type="text" wire:model.lazy="nombre"
		class="form-control" placeholder="ej: iece" autofocus >
		@error('nombre') <span class="text-danger er">{{ $message}}</span>@enderror
	</div>
</div>

<div class="col-sm-12 col-md-6">
	<div class="form-group">
		<label >Porcentaje</label>
		<input type="text" wire:model.lazy="porcentaje"
		class="form-control" placeholder="ej: 12" autofocus >
		@error('porcentaje') <span class="text-danger er">{{ $message}}</span>@enderror
	</div>
</div>

<div class="col-sm-12 col-md-6">
	<div class="form-group">
		<label >Código</label>
		<input type="text" wire:model.lazy="codigo"
		class="form-control" placeholder="ej: 2" autofocus >
		@error('codigo') <span class="text-danger er">{{ $message}}</span>@enderror
	</div>
</div>

</div>

@include('common.modalFooter')
