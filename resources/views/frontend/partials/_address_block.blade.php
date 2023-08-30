<div class="item address">
    <div class="showcase_head">
        <h4>
            @if( isset($controllerName) && $controllerName == 'HospitalController')
                <i class="fas fa-map-marker-alt"></i>
                    <span><a style="color:#fff" href="{{ route('frontend.hospital.index') . '?city=' . $row->city->id }}">
                        {{ $row->city->translations[0]->name }}
                    </a>  @if($row->area)- <a style="color:#fff" href="{{ route('frontend.hospital.index') . '?area=' . $row->area->id. '&city=' . $row->city->id }}">
                        {{ $row->area->translations[0]->name }}
                </a>@endif</span>
            @elseif( isset($controllerName) && $controllerName == 'CenterController')
                <i class="fas fa-map-marker-alt"></i>
                <span><a style="color:#fff" href="{{ route('frontend.center.index') . '?city=' . $row->city->id }}">
                    {{ $row->city->translations[0]->name }}
                </a>  @if($row->area)- <a style="color:#fff" href="{{ route('frontend.center.index') . '?area=' . $row->area->id. '&city=' . $row->city->id }}">
                    {{ $row->area->translations[0]->name }}
                </a>@endif</span>
            @elseif( isset($controllerName) && $controllerName == 'PharmacyController')
                <i class="fas fa-map-marker-alt"></i>
                <span><a style="color:#fff" href="{{ route('frontend.pharmacy.index') . '?city=' . $row->city->id }}">
                    {{ $row->city->translations[0]->name }}
                </a>  @if($row->area)- <a style="color:#fff" href="{{ route('frontend.pharmacy.index') . '?area=' . $row->area->id. '&city=' . $row->city->id }}">
                    {{ $row->area->translations[0]->name }}
                </a>@endif</span>
            @elseif( isset($controllerName) && $controllerName == 'LabController')
                <i class="fas fa-map-marker-alt"></i>
                <span><a style="color:#fff" href="{{ route('frontend.lab.index') . '?city=' . $row->city->id }}">
                    {{ $row->city->translations[0]->name }}
                </a>  @if($row->area)- <a style="color:#fff" href="{{ route('frontend.lab.index') . '?area=' . $row->area->id. '&city=' . $row->city->id }}">
                    {{ $row->area->translations[0]->name }}
                </a>@endif</span>
            @elseif( isset($controllerName) && $controllerName == 'InsuranceCompanyController')
                <i class="fas fa-map-marker-alt"></i>
                <span><a style="color:#fff" href="{{ route('frontend.insurance_company.index') . '?city=' . $row->city->id }}">
                    {{ $row->city->translations[0]->name }}
                </a>  @if($row->area)- <a style="color:#fff" href="{{ route('frontend.insurance_company.index') . '?area=' . $row->area->id. '&city=' . $row->city->id }}">
                    {{ $row->area->translations[0]->name }}
                </a>@endif</span>
            @else
                <i class="fas fa-map-marker-alt"></i>
                {{ $row->city->translations[0]->name }} -
                {{ $row->area->translations[0]->name }}
            @endif


        </h4>
    </div>
    <div class="showcase_content">
        <div class="accordion" id="showCase">
            <div class="card">
                <div class="card-header" id="addressOne" @if(basename($_SERVER['REQUEST_URI']) == 'phone') hidden @endif>
                    <h5 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <i class="fas fa-map-marked"></i>
                            <span>{{ $row->address }}</span>
                        </button>
                    </h5>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="addressOne" data-parent="#showCase">
                    <div class="card-body">
                        <div class="goto_map" @if(basename($_SERVER['REQUEST_URI']) == 'phone') hidden @endif>
                            <a href="https://www.google.com/maps/dir/?api=1&destination={{ str_replace(' ', '', $row->lat_lng) }}" target="_blank" class="goto_map_btn flexer flexer_jc_center flexer_ai_center"><i class="fas fa-location-arrow"></i> <span>{{ trans('general.map_directions') }}</span></a>
                        </div>
                        <div class="contact_info" @if(basename($_SERVER['REQUEST_URI']) == 'address') hidden @endif>
                            <div class="inner">
                                <div class="specs">
                                    <ul>
                                        @if(isset($row->phones) && !empty($row->phones) && is_array($row->phones))
                                            @foreach($row->phones as $phone)
                                                <li>
                                                    <i class="fas fa-phone"></i>
                                                    <a href="tel://{{ $phone }}">{{ $phone }}</a>
                                                </li>
                                            @endforeach
                                        @elseif(!is_array($row->phones))
                                            @if(isset($row->phone) && !empty($row->phone))
                                                <li>
                                                    <i class="fas fa-phone"></i>
                                                    <a href="tel://{{ $row->phone }}">{{ $row->phone }}</a>
                                                </li>
                                            @endif
                                        @endif
                                        @if(isset($row->open_hours) && !empty($row->open_hours))
                                            <li>
                                                <i class="fas fa-clock"></i>
                                                <span class="opened">{{ trans('general.open') }}: {{ $row->open_hours }}{{ trans('general.h') }}</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="item socials" id="socials">
    <div class="showcase_head text-center">
        @if(basename($_SERVER['REQUEST_URI']) == 'phone')
            <a style="color: #fff" href="address" title="{{ $row->name }}">
                {{trans('general.address')}} @if(isset($controllerName) && $controllerName == 'HospitalController'){{ trans('general.hospital') }}@endif {{ $row->name }}
            </a>
        @elseif(basename($_SERVER['REQUEST_URI']) == 'address')
            <a style="color: #fff" href="phone" title="{{ $row->name }}">
                {{trans('general.phones')}} @if(isset($controllerName) && $controllerName == 'HospitalController') {{ trans('general.hospital') }} @endif {{ $row->name }}
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
    <div class="showcase_content">
        <div class="accordion" id="showCase">
            <div class="card">
            </div>
        </div>
    </div>
</div>


<div class="item">
    <div class="showcase_head text-center">
        @if(basename($_SERVER['REQUEST_URI']) == 'phone')
            <a style="color: #fff" href="./" title="{{ $row->name }}">
                {{trans('general.read_more')}} @if(isset($controllerName) && $controllerName == 'HospitalController'){{ trans('general.hospital') }}@endif {{ $row->name }}
            </a>
        @elseif(basename($_SERVER['REQUEST_URI']) == 'address')
            <a style="color: #fff" href="./" title="{{ $row->name }}">
                {{trans('general.read_more')}} @if(isset($controllerName) && $controllerName == 'HospitalController') {{ trans('general.hospital') }} @endif {{ $row->name }}
            </a>
        @endif
    </div>
</div>
