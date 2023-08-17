@extends('admin.layout')

@section('content')

    @admin_block
    @slot('desc')

    @endslot
    @slot('menu')
        @include('admin.partial._create_new_button')
    @endslot
    @slot('content')
        <div class="col-sm-12">
            <div class="table-responsive">
                <form class="col-md-4 col-sm-12" action="">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" placeholder="Search">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <table class="table table-bordered table-striped table-hover dataTable dataTableAjax" searching="true" data-url="{{ route('admin.medicines_category.index') }}">
                    <thead>
                    <tr>
                        <th name="id" orderable="1">ID#</th>

                        <th name="name" >Name AR</th>
                        <th name="name" >Parent</th>

                        <th name="title" >Last Update</th>
                        <th name="Actions" width="20%">Actions</th>
                    </tr>
                    </thead>


                    <tbody>
                        @foreach ($medicines as $medicine)
                        <tr>
                            <td>
                                {{ $medicine->id }}
                            </td>
                            <td>
                                {{ $medicine->name }}
                            </td>
                            <td>
                                @if(\App\Models\MedicinesCategory::where('is_active' , 1)->find($medicine->parent))
                                    {{ \App\Models\MedicinesCategory::where('is_active' , 1)->find($medicine->parent)->name }}
                                @endif
                            </td>
                            <td>
                                {{ date('d-m-Y', strtotime($medicine->updated_at)) }}
                            </td>
                            <td>
                                {!! table_actions([
                                    'edit' => ['admin.medicines_category.edit', ['id' => $medicine->id]],
                                    'delete' => ['admin.medicines_category.delete', ['id' => $medicine->id]]
                                ]) !!}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>                </table>
                {{ $medicines->withQueryString()->links() }}

        </div>
    @endslot
    @endadmin_block

@stop

{{-- @include('admin.partial._dataTableJs') --}}
