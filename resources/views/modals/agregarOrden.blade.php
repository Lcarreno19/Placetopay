<div class="modal fade" id="agregarCompra" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <form method="POST" action="{{ route('ordenes.store') }}">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title">Agregar Nueva Compra</h5>
          </div>
          <div class="modal-body">
            <div class="form-group row">
              <label for="customer_name" class="col-md-4 col-form-label text-md-right">{{ __('Producto') }}</label>
              <div class="col-md-6">
                <select class="form-group form-control" id="idproducto" name="idproducto">
                  <option value="0"> -- Seleccione un producto -- </option>
                  @foreach($productos as $prod)
                    <option value="{{ $prod->idproducto }}"> {{ $prod->codigo_producto }} --{{ $prod->nombre_producto }} -- {{ $prod->price_producto }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="customer_name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre del Cliente') }}</label>
              <div class="col-md-6">
                <input id="customer_name" type="text" class="form-control @error('customer_name') is-invalid @enderror" name="customer_name" value="{{ old('customer_name') }}" required autocomplete="customer_name" autofocus>
                @error('customer_name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
            <div class="form-group row">
              <label for="customer_email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail del Cliente') }}</label>
              <div class="col-md-6">
                <input id="customer_email" type="email" class="form-control @error('customer_email') is-invalid @enderror" name="customer_email" value="{{ old('customer_email') }}" required autocomplete="customer_email" autofocus>
                @error('customer_email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
            <div class="form-group row">
              <label for="customer_mobile" class="col-md-4 col-form-label text-md-right">{{ __('Número Telefonico del Cliente') }}</label>
              <div class="col-md-6">
                <input id="customer_mobile" type="text" class="form-control @error('customer_email') is-invalid @enderror" name="customer_mobile" value="{{ old('customer_mobile') }}" required autocomplete="customer_mobile" autofocus>
                @error('customer_mobile')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">{{ __('Guardar Orden') }}</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>