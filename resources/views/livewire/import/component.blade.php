<div class="row sales layout-top-spacing">

    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>Módulo de Importar Catálogos</b>
                </h4>

            </div>


            <div class="widget-content">
                <div class="row">
                    <div class="col-sm-12 col-md-11">
                        <div class="form-group custom-file">
                            <input type="file" class="custom-file-input form-control" wire:model="fileCategories" accept=".xlsx, .xls,">
                            <label class="custom-file-label">Buscar excel CATEGORIAS</label>
                            @error('fileCategories') <span class="text-danger er">{{ $message}}</span>@enderror

                        </div>



                    </div>
                    <div class="col-sm-12 col-md-1 text-right">
                        <button wire:click.prevent="uploadCategories()" class="btn btn-dark" {{$fileCategories =='' ? 'disabled' : ''}}>Importar</button>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-sm-12 col-md-11">
                        <div class="form-group custom-file">
                            <input type="file" class="custom-file-input form-control" wire:model="fileProducts" accept=".xlsx, .xls,">
                            <label class="custom-file-label">Buscar excel PRODUCTOS</label>
                            @error('fileProducts') <span class="text-danger er">{{ $message}}</span>@enderror
                        </div>

                    </div>



                    <div class="col-sm-12 col-md-1 text-right">
                        <button wire:click.prevent="uploadProducts()" {{$fileProducts =='' ? 'disabled' : ''}} class="btn btn-dark">Importar</button>
                    </div>
                </div>

                <!-- display validation errors-->
                @if(count($errors->getMessages()) > 0)
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <strong>Validation Errors:</strong>
                    <ul>
                        @foreach($errors->getMessages() as $errorMessages)
                        @foreach($errorMessages as $errorMessage)
                        <li>
                            {{ $errorMessage }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        </li>
                        @endforeach
                        @endforeach
                    </ul>
                </div>@endif


            </div>


        </div>


    </div>


</div>