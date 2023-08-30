@extends('frontend.master')

@section('content')

    <section class="inner_container stand_alone_page_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="stand_alone_page_container">
                        <div class="alert alert-success" role="alert">
                            {{ trans('general.thanks_you_reservation_success') }}
                        </div>
                        <div class="booking_done table-responsive">
                            <i class="fas fa-calendar-check"></i>
                            <h1>{{ trans('general.reservation_details') }}</h1>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>{{ trans('general.doctor_name') }}</th>
                                        <td>{{ $shortcut['doctor_name'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ trans('general.clinic_address') }}</th>
                                        <td>{{ $branch->translations[0]->address }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ trans('general.clinic_phone') }}</th>
                                        <td>{{ $branch['phone'] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
