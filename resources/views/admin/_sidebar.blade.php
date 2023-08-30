@foreach ( dataForm()->getAdminMenu() as $k=>$row)
<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
    <span class="menu-link @if(Request::url()) {{"active"}} @endif">
        <span class="menu-icon" icon="{{ $row['icon'] }}">
            <span class="svg-icon svg-icon-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M21 9V11C21 11.6 20.6 12 20 12H14V8H20C20.6 8 21 8.4 21 9ZM10 8H4C3.4 8 3 8.4 3 9V11C3 11.6 3.4 12 4 12H10V8Z" fill="black"></path>
                    <path d="M15 2C13.3 2 12 3.3 12 5V8H15C16.7 8 18 6.7 18 5C18 3.3 16.7 2 15 2Z" fill="black"></path>
                    <path opacity="0.3" d="M9 2C10.7 2 12 3.3 12 5V8H9C7.3 8 6 6.7 6 5C6 3.3 7.3 2 9 2ZM4 12V21C4 21.6 4.4 22 5 22H10V12H4ZM20 12V21C20 21.6 19.6 22 19 22H14V12H20Z" fill="black"></path>
                </svg>
            </span>
        </span>
        {{-- <a  class="menu-toggle "> --}}
            {{-- <i class="material-icons"></i>
            <span></span>
        </a> --}}
        <span class="menu-title" @if ($row['has_sub'] == 1) href="javascript:void(0);" @else onclick="window.open({{ $row['url'] }})" @endif>
            {{ ucfirst($row['title']) }}
        </span>
        <span class="menu-arrow"></span>
    </span>
    @if ($row['has_sub'] == 1)
        @foreach($row['submenus'] as $sub_row)
         @can ( $sub_row->route_name )
          <div class="menu-sub menu-sub-accordion menu-active-bg" kt-hidden-height="308" style="">
           <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
            {{-- <a />
                <i class="material-icons">fiber_manual_record</i>
                <span></span>
            </a> --}}
            <span class="menu-link" @if($sub_row->route_name)>
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title" onclick="window.open('{{ route($sub_row->route_name) }}', '_self')" @else href="javascript:void(0);" @endif>
                    {{ ucfirst($sub_row->title) }}
                </span>
                {{-- <span class="menu-arrow"></span> --}}
            </span>
            {{-- <div class="menu-sub menu-sub-accordion menu-active-bg show" kt-hidden-height="231" style="">
                <div class="menu-item">
                    <a class="menu-link" href="../../demo1/dist/pages/profile/overview.html">
                    <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Overview</span>
                    </a>
                </div>
            </div> --}}
           </div>
          </div>
         @endcan
        @endforeach
    @endif
</div>
@endforeach