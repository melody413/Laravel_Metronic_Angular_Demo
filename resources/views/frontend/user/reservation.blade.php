@extends('frontend.master')

@section('content')
    <section class="inner_container stand_alone_page_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="stand_alone_page_container table-responsive">
                        <h1>{{ trans('general.patients_reservations') }}</h1>
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th scope="col">{{ trans('general.patient_name') }}</th>
                                <th scope="col">{{ trans('general.patient_phone') }}</th>
                                <th scope="col">{{ trans('general.reservation_date_time') }}</th>
                                <th scope="col">{{ trans('general.patient_address') }}</th>
                                <th scope="col">{{ trans('general.reserve_at') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if($reserve)
                                    @foreach($reserve as $row)
                                    <tr>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->phone }}</td>
                                        <td>{{ $row->reserve_date }}  {{ $row->reserve_time }}</td>
                                        <td>{{ $row->branch->translations[0]->address }}</td>
                                        <td>{{ $row->created_at }}</td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr><td colspan="4">{{ trans('general.no_patients_reservations') }}</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="pagination_holder">
                @if($reserve)
                    {{ $reserve->links() }}
                @endif
            </div>

        </div>
    </section>
@endsection
