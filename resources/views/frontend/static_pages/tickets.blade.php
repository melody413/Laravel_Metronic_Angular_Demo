@extends('frontend.master')

@section('title', trans('general.faq'))

@section('content')
    <section class="inner_container stand_alone_page_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @php
                        $web = file_get_contents('/ticket/tickets?category=Billing+issues');
                        // $text = nl2br($text);
                        echo $web; 
                    @endphp
                </div>
            </div>
        </div>
    </section>
@endsection