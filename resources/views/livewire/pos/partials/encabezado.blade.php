{{-- <div class="connect-sorting-content">
    <div class="card simple-title-task ui-sortable-handle">
        <div class="card-body">
            <h5 class="text-center text-muted">Datos Empresa</h5>
            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <h4>{{ $razonSocial }}</h4>
                </div>

            </div>
            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <h4>{{ $ruc }}</h4>
                </div>

            </div>
        </div>
    </div>
</div> --}}

<div class="card text-center">
    <div class="card-header">
      {{ $razonSocial }}
    </div>
    <div class="card-body">
      <h5 class="card-title">{{ $ruc }}</h5>
      <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
      <a href="#" class="btn btn-primary">Go somewhere</a>
    </div>
    {{-- <div class="card-footer text-muted">
      2 days ago
    </div> --}}
  </div>
