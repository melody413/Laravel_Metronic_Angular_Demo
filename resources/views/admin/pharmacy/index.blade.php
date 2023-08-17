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
                <table class="table table-bordered table-striped table-hover dataTable dataTableAjax" searching="true" data-url="{{ route('admin.pharmacy.index') }}">
                    <thead>
                    <tr>
                        <th name="id" orderable="1">ID#</th>

                        <th name="name" >Logo</th>
                        <th name="name" >Name</th>

                        <th name="title" >Last Update</th>
                        <th name="Actions" width="20%">Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                        @foreach ($pharmacies as $pharmacy)
                        <tr>
                            <td>
                                {{ $pharmacy->id }}
                            </td>
                            <td>
                                {!! img_tag($pharmacy->image,'pharmacys/') !!}
                            </td>
                            <td>
                                {{ $pharmacy->name }}
                            </td>
                            <td>
                                {{ date('d-m-Y', strtotime($pharmacy->updated_at)) }}
                            </td>
                            <td>
                                {!! table_actions([
                                    'edit' => ['admin.pharmacy.edit', ['id' => $pharmacy->id]],
                                    'delete' => ['admin.pharmacy.delete', ['id' => $pharmacy->id]]
                                ]) !!}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $pharmacies->withQueryString()->links() }}
               </div>
    @endslot
    @endadmin_block

@stop