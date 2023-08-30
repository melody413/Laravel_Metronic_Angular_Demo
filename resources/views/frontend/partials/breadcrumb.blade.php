@if(isset($breadcrumb) && is_array($breadcrumb) && !empty($breadcrumb))
<section class="breadcrumb-top mb-40">
    <div class="row">
    <div class="col-md">
        <div class="breadcrumb_holder">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
                    <?php $i = 1; ?>
                    @foreach($breadcrumb as $key=>$row)
                            <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a  itemprop="item" href="{{ $row }}"><span itemprop="name">{{ $key }}</span> <span itemprop="position" hidden>{{$i++}}</span></a></li>
                    @endforeach
                    {{-- {{ dd($controllerName) }}
                    @if( isset($sub_cat) )
                        <li class="breadcrumb-item"><a href="{{ route('frontend.doctor.index'). '?speciality=' . $Speciality->id. '&sub_cat=' . $sub_cat}}"></a>{{\App\Models\SubCategory::where('id', $sub_cat)->first()->name}}</li>
                    @endif --}}
                </ol>
            </nav>
        </div>
    </div>
    </div>
</section>
@endif
<style>
li.breadcrumb-item {
    background: #eee;
    padding: 5px 2px;
    box-shadow: -2px 1px 1px #aaa;
    font-family: Cairo,Tahoma,sans-serif;
}
</style>