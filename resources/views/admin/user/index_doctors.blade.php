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
                <form class="col-md-5 col-sm-12" action="">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" placeholder="Search Name / Telephone / Email">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <div class="col-md-6">
                    <a href="index_users">Users</a> | 
                    <a href="index_doctors">Doctors</a> |
                    <a href="index_admin">Admin</a> |
                    <a href="index_moderator">Moderator</a>
                </div>
                <b>Total:</b>{{$users_count}}
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th name="id" orderable="1">ID#</th>

                        <th name="name" >Name</th>
                        <th name="name" >email</th>
                        <th name="name" >Type</th>

                        <th name="title" >Last Update</th>
                        <th name="Actions" width="20%">Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                        @foreach ($dr_users as $user)
                        <tr>
                            <td>
                                {{ $user->id }}
                            </td>
                            <td>
                                {{ $user->name }}
                                {{-- {!! img_tag($user->image,'users/') !!} --}}
                            </td>
                            <td>
                                {{ $user->email }}
                            </td>
                            <td>
                                {{ array_flip(dataForm()->userTypes())[($user->type == 0)?1:$user->type] }}
                            </td>
                            <td>
                                {{ date('d-m-Y', strtotime($user->updated_at)) }}
                            </td>
                            <td>
                                {!! table_actions([
                                    'edit' => ['admin.user.edit', ['id' => $user->id]],
                                    'delete' => ['admin.user.delete', ['id' => $user->id]]
                                ]) !!}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $dr_users->withQueryString()->links() }}
        </div>
    @endslot
    @endadmin_block

@stop

@include('admin.partial._dataTableJs')
