@extends('frontend.master')

@section('content')

    <section class="inner_container pharmacy_list">
        <div class="container">
            <div class="row">
                <div class="col-md">
                    <h1 class="list_title">
                        {{ getMainModuleTitle('body_parts',"","") }}
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="list_holder">
                        @forelse( $rows as $row)
                            @list_block(['row' => $row, 'imagePath' => 'body_parts/' , 'routeKey' => 'body_part' ]) @endlist_block
                        @empty
                            @include('frontend.partials._no_data')
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="pagination_holder">
                {{ $rows->appends(Request::query())->links() }}
            </div>
        </div>
    </section>
@endsection
