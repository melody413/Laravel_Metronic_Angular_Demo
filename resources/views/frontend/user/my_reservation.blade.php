@extends('frontend.master')

@section('content')
    <section class="inner_container stand_alone_page_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="stand_alone_page_container table-responsive">
                        <h1>{{ trans('general.my_reservations') }}</h1>
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th scope="col">{{ trans('general.doctor_name') }}</td>
                                <th scope="col">{{ trans('general.clinic_address') }}</td>
                                <th scope="col">{{ trans('general.clinic_phone') }}</td>
                                <th scope="col">{{ trans('general.reservation_date_time') }}</td>
                                <th scope="col">{{ trans('general.reserve_at') }}</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reserve as $row)
                                <tr>
                                    <td>{{ $row->doctor->name }}</td>
                                    <td>{{ $row->branch->translations[0]->address }}</td>
                                    <td>{{ $row->branch->phone }}</td>
                                    <td>{{ $row->reserve_date }} <strong> {{ $row->reserve_time }}</strong></td>
                                    <td>{{ $row->created_at }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="pagination_holder">
                {{ $reserve->links() }}
            </div>
        </div>
    </section>
@endsection

