<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    @if ( ! isset( $title) )
                        @isset( $action_title )
                            {{ $action_title }}
                        @endisset
                        @isset( $module_title )
                            {{ preg_replace('/s$/','', $module_title) }}
                        @endisset
                    @else
                        {{ $title }}
                    @endif
                    <small>
                        @isset($desc)
                            {{ $desc }}
                        @endisset
                    </small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    @isset($menu)
                        {{ $menu }}
                    @endisset
                </ul>
            </div>
            <div class="body">
                <div class="row clearfix">
                    {{ $content }}
                </div>
            </div>
        </div>
    </div>
</div>