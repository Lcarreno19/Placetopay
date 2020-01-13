@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
            	<div class="card-body">
            		@if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                       	</div>
                    @endif
                    <div class="card-body">
                    	<form method="POST" action="{{ route('ordenes.checkout', ['idorders' => $order->idorders]) }}">
                    	@csrf
                        <div class="card-header">
                        	<b>Resumen de Orden</b>
                        	<div class="text-right">
                        		<a href="{{ url('/home') }}" class="btn btn-primary">Atras</a>
                        	</div>                       
                        </div><br><br>
                        <div class="row">
                        	<div class="col-12">
                        		<div class="form-group row">
              						<label for="customer_name" class="col-md-4 col-form-label text-md-right">{{ __('Producto') }}</label>
              						<div class="col-md-6">
                						<select class="form-group form-control" id="idproducto" name="idproducto" disabled="true">
                  							@foreach($productos as $prod)
                    							<option value="{{ $prod->idproducto }}" {{ ($prod->idproducto == $order->idproducto ? 'selected="selected"' : '') }}> {{ $prod->codigo_producto }} --{{ $prod->nombre_producto }} -- {{ $prod->price_producto }}</option>
                  							@endforeach
                						</select>
              						</div>
            					</div>
            					<div class="form-group row">
              						<label for="customer_name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre del Cliente') }}</label>
              						<div class="col-md-6">
                						<input id="customer_name" type="text" class="form-control @error('customer_name') is-invalid @enderror" name="customer_name" value="{{ old('customer_name', $order->customer_name) }}" required autocomplete="customer_name" autofocus readonly="true">
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
                						<input id="customer_email" type="email" class="form-control @error('customer_email') is-invalid @enderror" name="customer_email" value="{{ old('customer_email', $order->customer_email) }}" required autocomplete="customer_email" autofocus readonly="true">
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
                						<input id="customer_mobile" type="text" class="form-control @error('customer_email') is-invalid @enderror" name="customer_mobile" value="{{ old('customer_mobile', $order->customer_mobile) }}" required autocomplete="customer_mobile" autofocus readonly="true">
                						@error('customer_mobile')
                  							<span class="invalid-feedback" role="alert">
                    							<strong>{{ $message }}</strong>
                  							</span>
                						@enderror
              						</div>
            					</div>
            					<div style="text-align: center;">
            						<button type="submit" class="btn btn-primary">{{ __('Proceder a Pagar') }}</button>
            					</div>
                        	</div>
                        </div>
                    </div>
            	</div>
           	</div>
        </div>
    </div>
</div>
@endsection