@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-header">
                        Solicitudes de Pago
                        <div class="dropdown text-right">
                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <b style="color: black;">Acciones</b> &nbsp;
                                <i class="fas fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                <a href="#" data-target="#agregarCompra" data-toggle="modal" class="dropdown-item">{{ ('Crear Nueva Compra') }}</a>
                            </div>
                        </div>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="table tablesorter " id="detalle_ordenes_users">
                        <thead class=" text-primary">
                            <th scope="col">{{ ('# Único') }}</th>
                            <th scope="col">{{ ('Nombre Cliente') }}</th>
                            <th scope="col">{{ ('Número de teléfono') }}</th>
                            <th scope="col">{{ ('Email') }}</th>
                            <th scope="col">{{ ('Token de la App') }}</th>
                            <th scope="col">{{ ('Estatus') }}</th>
                            <th scope="col"></th>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <?php 
                                    switch ($order->status) {
                                        case 'APPROVED':
                                            $estatus ="<button  type='button' class='btn btn-sm btn-success'>".$order->status."</button>";
                                        break;
                                        case 'PENDING':
                                            $estatus ="<button  type='button' class='btn btn-sm btn-warning'>".$order->status."</button>";
                                        break;
                                        case 'CREATED':
                                            $estatus ="<button  type='button' class='btn btn-sm btn-primary'>".$order->status."</button>";
                                        break;
                                        case 'REJECTED':
                                            $estatus ="<button  type='button' class='btn btn-sm btn-danger'>".$order->status."</button>";
                                        break;
                                    }
                                ?>
                                <tr>
                                    <td>{{ $order->idorders }}</td>
                                    <td>{{ $order->customer_name }}</td>
                                    <td>{{ $order->customer_mobile }}</td>
                                    <td>{{ $order->customer_email }}</td>
                                    <td>{{ $order->requestid }}</td>
                                    <td><?php echo $estatus; ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v" style="color: black;"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                @if($order->status != 'APPROVED')
                                                    @if($order->status != 'REJECTED' and $order->status != 'CREATED')
                                                        <a href="{{ $order->urlgenerada }}" class="dropdown-item" target="_blank">{{ __('Continuar con el Proceso') }}</a>
                                                    @else
                                                        <a href="{{ route('ordenes.show', ['ordene' => $order->idorders]) }}" class="dropdown-item">{{ __('Resumen de la Orden') }}</a>
                                                    @endif
                                                @else
                                                    <a href="#" data-target="#verCompra" data-toggle="modal" class="dropdown-item">{{ ('Ver Transaccion') }}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>                
            </div>
        </div>
    </div>
</div>
@include('modals.agregarOrden')
@include('modals.verOrden')

@endsection
@section('myjs')
<script type="text/javascript">
    $(document).ready(function() {
        $('#detalle_ordenes').DataTable();
        $('#detalle_ordenes_users').DataTable();
    });
</script>
@endsection
