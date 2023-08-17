<div class="col-sm-12" {{classTag('table-list-container', config('tablelist.template.table.container.class')) }}>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover" {{ classTag('table', config('tablelist.template.table.item.class')) }}>
            @include('tablelist::thead')
            @include('tablelist::tbody')
            @include('tablelist::tfoot')
        </table>
    </div>
</div>
