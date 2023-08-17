@foreach($row->branches as $k=>$branch)
@if(isset($branch->city->name) && isset($branch->area->name))
<div class="item address booking" id="branchAddress_{{ $branch->id }}">
    <div class="showcase_head">
        <h4>
            <i class="fas fa-building"></i>
            <span><a style="color: #fff" href="{{ route('frontend.doctor.index') . '?city=' . $branch->city->id }}">
                {{ $branch->city->name }}
            </a> - <a style="color: #fff" href="{{ route('frontend.doctor.index') . '?area=' . $branch->area->id. '&city=' . $branch->city->id }}">
                {{ $branch->area->name }}
            </a></span>
        </h4>
    </div>
    <div class="showcase_content">
        <div class="accordion" id="showCase">
            <div class="card">
                <div class="card-header" id="addressOne" @if(basename($_SERVER['REQUEST_URI']) == 'phone') hidden @endif>
                    <h5 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <i class="fas fa-map-marked"></i>
                            <span>{{ $branch->translations[0]->address }}</span>
                        </button>
                    </h5>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="addressOne" data-parent="#showCase" @if(basename($_SERVER['REQUEST_URI']) == 'phone') hidden @endif>
                    <div class="card-body">
                        {{--<div class="map">--}}
                            {{----}}
                        {{--</div>--}}
                        @if ($row->map_link)
                            <div class="goto_map">
                                <a title={{ str_replace(' ', '', $branch->lat_lng) }} onclick="window.open('{{$row->map_link}}', '_blank', 'location=yes,height=570,width=765,scrollbars=yes,status=yes,top=50,left=300');" target="_blank" class="goto_map_btn flexer flexer_jc_center flexer_ai_center"><i class="fas fa-location-arrow"></i> <span>{{ trans('general.map_directions') }}</span></a>
                            </div>
                        @else
                            <div class="goto_map">
                                <a title={{ str_replace(' ', '', $branch->lat_lng) }} onclick="window.open('https://www.google.com/maps/dir/?api=1&destination={{ str_replace(' ', '', $branch->lat_lng) }}', '_blank', 'location=yes,height=570,width=765,scrollbars=yes,status=yes,top=50,left=300');" target="_blank" class="goto_map_btn flexer flexer_jc_center flexer_ai_center"><i class="fas fa-location-arrow"></i> <span>{{ trans('general.map_directions') }}</span></a>
                            </div>
                        @endif
                    </div>
                </div>
                <div id="collapseTwo" class="collapse show" aria-labelledby="phoneOne" data-parent="#showCase" @if(basename($_SERVER['REQUEST_URI']) == 'address') hidden @endif >
                    <div class="card-body">
                        <div class="contact_info">
                            <div class="inner">
                                <div class="specs">
                                    <ul>
                                        @if($branch->phone)
                                            @if(isset($branch->phones) && !empty($branch->phones) && is_array($branch->phones))
                                                @foreach($branch->phones as $phone)
                                                    <li>
                                                        <i class="fas fa-phone"></i>
                                                        <a href="tel://{{ $phone }}">{{ $phone }}</a>
                                                    </li>
                                                @endforeach
                                            @elseif(!is_array($branch->phones))
                                                @if(isset($branch->phone) && !empty($branch->phone))
                                                    <li>
                                                        <i class="fas fa-phone"></i>
                                                        <span>{{ $branch->phone }}</span>
                                                    </li>
                                                @endif
                                            @endif
                                            @if(isset($branch->open_hours) && !empty($row->open_hours))
                                                <li>
                                                    <i class="fas fa-clock"></i>
                                                    <span class="opened">{{ trans('general.open') }}: {{ $row->open_hours }} {{ trans('general.h') }}</span>
                                                </li>
                                            @endif
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @if($row->is_reserve)
                        <div class="booking_holder flexer flex-column flexer_jc_center flexer_ai_stretch">
                            <div class="header">
                                <h3>
                                    <i class="fas fa-calendar-check"></i>
                                    <span>{{ trans('general.booking_an_appointment') }}</span>
                                </h3>
                            </div>
                            {!! doctorReservePerBranch($row,$branch, \Carbon\Carbon::now()->format('d/m/Y'))->parse()->toHtml() !!}
                            {{--@include('frontend.doctor._reserve_unit')--}}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endforeach
<div class="item socials" id="socials">
    <div class="showcase_head text-center">
        @if(basename($_SERVER['REQUEST_URI']) == 'phone')
            <a style="color: #fff" href="{{ route('frontend.doctor.unit', ['id'=>$row->id]) }}/address" title="{{ $row->name }}">
                {{trans('general.address')}} @if( isset($view) && $view == 'DOCTOR' ){{ trans('general.dr') }}@endif {{ $row->name }}
            </a>
        @elseif(basename($_SERVER['REQUEST_URI']) == 'address')
            <a style="color: #fff" href="{{ route('frontend.doctor.unit', ['id'=>$row->id]) }}/phone" title="{{ $row->name }}">
                {{trans('general.phones')}} @if( isset($view) && $view == 'DOCTOR' ) {{ trans('general.dr') }} @endif {{ $row->name }}
            </a>
        @else
            <h4>
                <span>{!! $row->facebook? "<a href=".$row->facebook." target='_blank'><i class='fab fa-facebook-f'></i></a>" : '' !!}</span>
                <span>{!! $row->twitter? "<a href=".$row->twitter." target='_blank'> - <i class='fab fa-twitter'></i></a>" : '' !!}</span>
                <span>{!! $row->instagram? "<a href=".$row->instagram." target='_blank'> - <i class='fab fa-instagram'></i></a>" : '' !!}</span>
                <span>{!! $row->youtube? "<a href=".$row->youtube." target='_blank'> - <i class='fab fa-youtube'></i></a>" : '' !!}</span>
                <span>{!! $row->website? "<a href=".$row->website." target='_blank'> - <i class='fas fa-link'></i></a>" : '' !!}</span>
            </h4>
        @endif
    </div>
</div>
<div class="item">
    <div class="showcase_head text-center">
        @if(basename($_SERVER['REQUEST_URI']) == 'phone')
            <a style="color: #fff" href="{{ route('frontend.doctor.unit', ['id'=>$row->id]) }}" title="{{ $row->name }}">
                {{trans('general.read_more')}} @if( isset($view) && $view == 'DOCTOR' ){{ trans('general.dr') }}@endif {{ $row->name }}
            </a>
        @elseif(basename($_SERVER['REQUEST_URI']) == 'address')
            <a style="color: #fff" href="{{ route('frontend.doctor.unit', ['id'=>$row->id]) }}" title="{{ $row->name }}">
                {{trans('general.read_more')}} @if( isset($view) && $view == 'DOCTOR' ) {{ trans('general.dr') }} @endif {{ $row->name }}
            </a>
        @endif
    </div>
</div>
