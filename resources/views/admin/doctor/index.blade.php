@extends('admin.layout')

@section('content')
    @admin_block
    @slot('desc')
        List Doctors
    @endslot
    @slot('menu')
        @include('admin.partial._create_new_button')
    @endslot
    @slot('content')
        <div class="card" style="display: grid;font-size: 100%;">
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg
                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black"></rect>
                                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black"></path>
                            </svg>
                        </span>-->
                        <!--end::Svg Icon-->
                        <form class="col-sm-12" action="">
                            <input type="text" data-kt-customer-table-filter="search" class="form-control form-control-solid w-250px ps-15" name="q" placeholder="Search">
                        </form>
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->

            </div>
            <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover dataTable dataTableAjax" searching="true" data-url="{{ route('admin.doctor.index') }}">
                    <thead>
                    <tr>
                        <th name="id" orderable="1">ID#</th>

                        <th name="image" >Image</th>
                        <th name="name" >Name</th>

                        <th name="title" >Last Update</th>
                        <th name="by" >By</th>
                        <th name="Actions" width="20%">Actions</th>
                    </tr>
                    </thead>
       <tbody>
                        @foreach ($doctors as $doctor)
                        <tr>
                            <td>
                                {{ $doctor->id }}
                            </td>
                            <td>
                                {!! img_tag($doctor->image,'doctors/') !!}
                            </td>
                            <td>
                                {{ $doctor->name }}
                            </td>
                            <td>
                                {{ date('d-m-Y', strtotime($doctor->updated_at)) }}
                            </td>
                            <td>
                                {{ $doctor->user_entry != null ? $doctor->user_entry->name  : "" }}
                            </td>
                            <td>
                                {!! table_actions([
                                    'edit' => ['admin.doctor.edit', ['id' => $doctor->id]],
                                    'doctor_reservation' => ['admin.reservation.index', ['id' => $doctor->id]],
                                    'doctor_branch' => ['admin.doctor_branch.index', ['id' => $doctor->id]],
                                    'doctor_rate' => ['admin.doctor_rate.index', ['id' => $doctor->id]],
                                    'delete' => ['admin.doctor.delete', ['id' => $doctor->id]]
                                ]) !!}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $doctors->withQueryString()->links() }}
            </div>
        </div>

        @endslot
    @endadmin_block

@stop

