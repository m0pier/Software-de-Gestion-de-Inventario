@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Lista de Roles</h1>
@stop

@section('content')
    <p>Aquí puedes modificar roles</p>

    <div class="card">
        <div class="card-header">
            <x-adminlte-button label="Nuevo" theme="primary" icon="fas fa-key" class="float-right" data-toggle="modal" data-target="#modalPurple" />
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            {{-- Setup data for datatables --}}
            @php
                $heads = ['ID', 'Nombre', ['label' => 'Actions', 'no-export' => true, 'width' => 5]];
                $config = [];
            @endphp

            {{-- Minimal example / fill data using the component slot --}}
            <x-adminlte-datatable id="table6" :heads="$heads" head-theme="light" theme="dark" :config="$config" striped
                hoverable with-footer footer-theme="light" beautify>
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            <a href="{{ route('roles.edit', $role->id) }}"
                                class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>

    {{-- Themed --}}
    <x-adminlte-modal id="modalPurple" title="Nuevo Rol" theme="purple" icon="fas fa-bolt" size='lg'
        disable-animations>
        <form action="{{ route('roles.store') }}" method="post">
            @csrf
            <div class="row">
                <x-adminlte-input name="nombre" label="Nombre" placeholder="Ingresar rol"
                    fgroup-class="col-md-6" disable-feedback/>
            </div>
            <x-adminlte-button type="submit" label="Guardar" theme="primary" icon="fas fa-key"/>
        </form>
    </x-adminlte-modal>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.formEliminar').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "Se va a eliminar un registro.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sí, eliminar registro."
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    </script>
@stop
