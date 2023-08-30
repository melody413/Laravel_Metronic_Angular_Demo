@can($route.'.delete')
    <a href="{{ route($route. '.delete' , ['id', $item->id]) }}" class="btn btn-danger waves-effect"
       onclick="return confirm('Are you sure?')">
        <i class="material-icons">delete</i>
        Delete
    </a>
@endcan