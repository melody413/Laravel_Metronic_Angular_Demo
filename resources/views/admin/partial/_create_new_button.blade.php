
@can($route.'.create')
<a href="{{ route($route.'.create', isset($routeParams)?$routeParams:[]) }}" class="btn btn-sm btn-primary waves-effect" style="    display: flex;">
    <i class="material-icons " style="margin-top: 9px;">edit</i> <span>New</span>
</a>
@endcan
