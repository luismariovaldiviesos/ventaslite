<div class="connect-sorting">
    <div class="connect-sorting-content">
        <div class="card simple-title-task ui-sortable-handle">
            <div class="card-body">
                <h5 class="text-center text-muted">Agrega cliente a la venta</h5>
                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-gp">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                    <input type="text" wire:model.debounce.500ms="searchCliente" placeholder="Buscar" class="form-control"
                    >
                </div>
                <div>
                  <ul>
                      @foreach ($clienteResult as $c )
                      <li class="border-b border-gray-700">
                        <a href="javascript:void(0)"
                         wire:click='seleccionaCliente({{$c->id}})'
                         class="block hover:bg-gray-700 px-3 py-3">{{$c['nombre']}}</a>
                    </li>
                      @endforeach


                  </ul>
                </div>


            </div>
        </div>
    </div>


<div class="connect-sorting-content">
	<div class="card simple-title-task ui-sortable-handle">
		<div class="card-body">

		@if($total > 0)
		<div class="table-responsive tblscroll" style="max-height: 650px; overflow: hidden">
			<table class="table table-bordered table-striped mt-1">
				<thead class="text-white" style="background: #3B3F5C">
					<tr>
						<th width="10%"></th>
						<th class="table-th text-left text-white">DESCRIPCIÓN</th>
						<th class="table-th text-center text-white">PRECIO</th>
						<th width="13%" class="table-th text-center text-white">CANT</th>
						<th class="table-th text-center text-white">IMPORTE</th>
						<th class="table-th text-center text-white">ACTIONS</th>
					</tr>
				</thead>
				<tbody>
					@foreach($cart as $item)
					<tr>
						<td class="text-center table-th">
							@if(count($item->attributes) > 0)
							{{-- <span>
								<img src="{{ asset('storage/products/' . $item->attributes[0]) }}" alt="imágen de producto" height="90" width="90" class="rounded">
							</span> --}}
							@endif
						</td>
						<td><h6>{{$item->name}}</h6></td>
						<td class="text-center">${{number_format($item->price,2)}}</td>
						<td>
							<input type="number" id="r{{$item->id}}"
							wire:change="updateQty({{$item->id}}, $('#r' + {{$item->id}}).val() )"
							style="font-size: 1rem!important"
							class="form-control text-center"
							value="{{$item->quantity}}"
							>
						</td>
						<td class="text-center">
							<h6>
								${{number_format($item->price * $item->quantity,2)}}
							</h6>
						</td>
						<td class="text-center">
							<button onclick="Confirm('{{$item->id}}', 'removeItem', '¿CONFIRMAS ELIMINAR EL REGISTRO?')" class="btn btn-dark mbmobile">
								<i class="fas fa-trash-alt"></i>
							</button>
							<button wire:click.prevent="decreaseQty({{$item->id}})" class="btn btn-dark mbmobile">
								<i class="fas fa-minus"></i>
							</button>
							<button wire:click.prevent="increaseQty({{$item->id}})" class="btn btn-dark mbmobile">
								<i class="fas fa-plus"></i>
							</button>

						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		@else
		<h5 class="text-center text-muted">Agrega productos a la venta</h5>
		@endif

<!--
		<div wire:loading.inline wire:target="saveSale">
			<h4 class="text-danger text-center">Guardando Venta...</h4>
		</div>
	-->



		</div>
	</div>
</div>


</div>
