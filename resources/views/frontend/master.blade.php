<?php
  header("Cache-Control: max-age=2592000"); //30days (60sec * 60min * 24hours * 30days)
?><!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <?php
            preg_match('/([a-z]*)@/i', request()->route()->getActionName(), $matches);
            $controllerName = $matches[1];
            $methodName  = explode("@", request()->route()->getActionName())[1];
            header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + (60 * 60))); // 1 hour
        ?>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="@if(basename($_SERVER['REQUEST_URI']) == 'address' ) {{ trans('general.address').',' }} @endif @if(basename($_SERVER['REQUEST_URI']) == 'phone' ) {{ trans('general.phones').',' }} @endif @if(isset($page_title)){{ implode(",",explode(' ', $page_title)) }}@if(isset($tag)),{{ $tag->name }} @endif,@endif Doctorak">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="index, follow" />
        @if(\App::getLocale()=='ar')
                @if(stristr($_SERVER['HTTP_USER_AGENT'],'mobi')!==TRUE)
                    <link rel="preconnect" href="https://fonts.googleapis.com">
                    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                    <link rel="preload" href="https://fonts.gstatic.com/s/cairo/v10/SLXLc1nY6Hkvalqaa46O59ZMaA.woff2" as="font" type="font/woff2" crossorigin>
                    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@700&display=swap" rel="stylesheet">
                @endif
                {{-- <link rel="preload" href="/assets/frontend/css/doctorak_rtl.min.css?v=1.2"  as="style"> --}}
                {{-- <link rel="preload" href="/assets/frontend/fonts/icomoon-new/icomoon.ttf" as="font" type="font/ttf" crossorigin>
                <link rel="preload" href="/assets/frontend/fonts/icomoon-new/icomoon.woff" as="font" type="font/woff" crossorigin> --}}
                <link rel="stylesheet" as="style" nonce="{{ csp_nonce() }}" as="style" href="/assets/frontend/css/doctorak_rtl.min.css?v=1.2">
        @else
                <link rel="preload" href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900&display=swap" as="style" type="text/css">
                <link rel="stylesheet" as="style" href="/assets/frontend/css/doctorak.min.css">
        @endif
        @if(isset($controllerName) && $controllerName == 'HomeController')
            @if(\App::getLocale()=='ar')
                <meta name="description" content="دكتورك هو اكبر دليل شامل للخدمات الطبية في الوطن العربي ويقدم البيانات للكثير من الخدمات الطبية">                            
            @else
                <meta name="description" content="Doctorak is the largest comprehensive medical services directory in the Arab world which provides data for many medical services">
            @endif
            <title>@if(isset($page_title)){{ $page_title }} @if(isset($tag)) - {{ $tag->name }} @endif - @endif  @if(\App::getLocale()=='ar') دكتورك @else  Doctorak  @endif - Help in accessing Health Care Services   @if(isset($_GET['page']) && $_GET['page']) - {{$_GET['page']}} @endif</title>
        @elseif(isset($controllerName) && $controllerName == 'DoctorController' && $methodName == "index")
            @if(\App::getLocale()=='ar')
                <meta name="description" content="ابحث عن افضل دكتور  @if(isset($page_title)){{ $page_title }} @endif  @if(isset($tag)) - {{ $tag->name }} @endif  واعرف رقم التليفون والعنوان على خريطة جوجل  ويمكنك البحث في التأمينات المتعاقد معها، ومعرفة افضل خدمات التخصص">
            @else
                <meta name="description" content="Know information about the @if(isset($page_title)){{ $page_title }} @endif @if(isset($tag)) - {{ $tag->name }} @endif and know the phone number, location on the map, patient valuation and the insurance entities that his is working with">
            @endif
            <title>
                @if (request()->input('gender', null) == "female")
                    {{ getMainModuleTitle('doctors_female_best',$city, $area, \App\Models\SubCategory::find($sub_cat) ?: $Speciality) }} @if(isset($tag)) - {{ $tag->name }} @endif
                @else
                    {{ getMainModuleTitle('doctors_best',$city, $area, \App\Models\SubCategory::find($sub_cat) ?: $Speciality) }} @if(isset($tag)) - {{ $tag->name }} @endif
                @endif
                @if(\App::getLocale()=='ar')-  دكتورك  @else  - Doctorak  @endif   @if(isset($_GET['page']) && $_GET['page']) - {{$_GET['page']}} @endif</title>

            @if(isset($controllerName) && $controllerName == 'DoctorController'  && $methodName != "index" && $methodName != "reserveSuccess")
                <meta property="og:image" content="/uploads/doctors/{{ \App\Models\Doctor::findOrFail( request()->route()->id)->image }}" />
            @else
                <meta property="og:image" content="/assets/frontend//images/general/logo_200.png" />
            @endif
            @if ($qanswers_ar->count()> 0)
            <script type="application/ld+json">{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[{"@type":"Question","name":"{{$qanswers_ar->first()->name}}","acceptedAnswer":{"@type":"Answer","text":"{!! strip_tags($qanswers_ar->first()->description) !!}" }}
            @if($qanswers_ar->skip(1)->first()),{"@type":"Question","name":"{{$qanswers_ar->skip(1)->first()->name}}","acceptedAnswer":{"@type":"Answer","text":"{!! strip_tags($qanswers_ar->skip(1)->first()->description) !!}" }}@endif
            @if($qanswers_ar->skip(2)->first()),{"@type":"Question","name":"{{$qanswers_ar->skip(2)->first()->name}}","acceptedAnswer":{"@type":"Answer","text":"{!! strip_tags($qanswers_ar->skip(2)->first()->description) !!}" }}@endif
            @if($qanswers_ar->skip(3)->first()),{"@type":"Question","name":"{{$qanswers_ar->skip(3)->first()->name}}","acceptedAnswer":{"@type":"Answer","text":"{!! strip_tags($qanswers_ar->skip(3)->first()->description) !!}" }}@endif
            @if($qanswers_ar->skip(4)->first()),{"@type":"Question","name":"{{$qanswers_ar->skip(4)->first()->name}}","acceptedAnswer":{"@type":"Answer","text":"{!! strip_tags($qanswers_ar->skip(4)->first()->description) !!}" }}@endif
            @if($qanswers_ar->skip(5)->first()),{"@type":"Question","name":"{{$qanswers_ar->skip(5)->first()->name}}","acceptedAnswer":{"@type":"Answer","text":"{!! strip_tags($qanswers_ar->skip(5)->first()->description) !!}" }}@endif
            @if($qanswers_ar->skip(6)->first()),{"@type":"Question","name":"{{$qanswers_ar->skip(6)->first()->name}}","acceptedAnswer":{"@type":"Answer","text":"{!! strip_tags($qanswers_ar->skip(6)->first()->description) !!}" }}@endif
            @if($qanswers_ar->skip(7)->first()),{"@type":"Question","name":"{{$qanswers_ar->skip(7)->first()->name}}","acceptedAnswer":{"@type":"Answer","text":"{!! strip_tags($qanswers_ar->skip(7)->first()->description) !!}" }}@endif
            @if($qanswers_ar->skip(8)->first()),{"@type":"Question","name":"{{$qanswers_ar->skip(8)->first()->name}}","acceptedAnswer":{"@type":"Answer","text":"{!! strip_tags($qanswers_ar->skip(8)->first()->description) !!}" }}@endif
            @if($qanswers_ar->skip(9)->first()),{"@type":"Question","name":"{{$qanswers_ar->skip(9)->first()->name}}","acceptedAnswer":{"@type":"Answer","text":"{!! strip_tags($qanswers_ar->skip(9)->first()->description) !!}" }}@endif
            ]}</script><!--FAQPage Code -->
        @endif
        @elseif(isset($controllerName) && $controllerName == 'DoctorController')
            @if(\App::getLocale()=='ar')
                <meta name="description" content=" تعرف علي @if(basename($_SERVER['REQUEST_URI']) == 'address' ) {{ trans('general.address') }} @endif @if(basename($_SERVER['REQUEST_URI']) == 'phone' ) {{ trans('general.phones') }} @endif @if(isset($page_title)){{ $page_title }} @endif  @if(isset($tag)) - {{ $tag->name }} @endif واعرف رقم التليفون والعنوان على خرائط جوجل وتقييمات المرضى والتأمينات المتعاقد معها">
            @else
                <meta name="description" content="Know information about the @if(isset($page_title)){{ $page_title }} @endif and know the phone number, location on the map, patient valuation and the insurance entities that his is working with.">
            @endif
            <title>@if(basename($_SERVER['REQUEST_URI']) == 'address' ) {{ trans('general.address') }} @endif
            @if(basename($_SERVER['REQUEST_URI']) == 'phone' ) {{ trans('general.phones') }} @endif 
            @if(isset($page_title)){{ $page_title }} @endif  @if(isset($tag)) - {{ $tag->name }} @endif @if(\App::getLocale()=='ar')-  دكتورك  @else  - Doctorak  @endif   @if(isset($_GET['page']) && $_GET['page']) - {{$_GET['page']}} @endif</title>
        {{-- @elseif(isset($controllerName) && $controllerName == 'HospitalController' && $methodName == "index"  )
            @if(\App::getLocale()=='ar')
                <meta name="description" content="اعرف معلومات عن مستشفي  @if(isset($page_title)){{ $page_title }} @endif  @if(isset($tag)) - {{ $tag->name }} @endif  واعرف رقم التليفون وحدد العنوان على الخريطة ومعرفة الخدمات وتقييمات المرضى والتأمينات المتعاقد معها">
            @else
                <meta name="description" content="Know information about  @if(isset($page_title)){{ $page_title }} @endif  @if(isset($tag)) - {{ $tag->name }} @endif and know the phone number, location on the map, patient valuation and the insurance entities that his is working with">
            @endif
            <title>{{ getMainModuleTitle('hospitals_best',$city,$area,\App\Models\SubCategory::find($sub_cat) ?: $Speciality) }}  @if(isset($tag)) - {{ $tag->name }} @endif @if(\App::getLocale()=='ar')-  دكتورك  @else  - Doctorak  @endif   @if(isset($_GET['page']) && $_GET['page']) - {{$_GET['page']}} @endif</title> --}}
        @elseif(isset($controllerName) && ($controllerName == 'HospitalController' || $controllerName == 'CenterController') && $methodName == "index")
            @if(\App::getLocale()=='ar')
                <meta name="description" content=" تعرف على أفضل @if(basename($_SERVER['REQUEST_URI']) == 'address' ) {{ trans('general.address') }} @endif
@if(basename($_SERVER['REQUEST_URI']) == 'phone' ) {{ trans('general.phones') }} @endif  @if(isset($page_title)){{ $page_title }} @endif  @if(isset($tag)) - {{ $tag->name }} @endif  واعرف رقم التليفون والعنوان على الخريطة، ويمكنك البحث عن التأمينات المتعاقد معها، وتقييمات المرضى">
                <title>اعرف كل المعلومات عن أفضل @if(isset($page_title)){{ $page_title }} @endif  @if(isset($tag)) - {{ $tag->name }} @endif @if(\App::getLocale()=='ar')-  دكتورك  @else  - Doctorak  @endif   @if(isset($_GET['page']) && $_GET['page']) - {{$_GET['page']}} @endif</title>
            @else
                <meta name="description" content="Know information about the Hospital in  @if(isset($page_title)){{ $page_title }} @endif  @if(isset($tag)) - {{ $tag->name }} @endif and know the phone number, location on the map, patient valuation and the insurance entities that his is working with">
                <title>Know all the information about the Best @if(isset($page_title)){{ $page_title }} @endif  @if(isset($tag)) - {{ $tag->name }} @endif @if(\App::getLocale()=='ar')-  دكتورك  @else  - Doctorak  @endif   @if(isset($_GET['page']) && $_GET['page']) - {{$_GET['page']}} @endif</title>
            @endif

            @if(isset($controllerName) && ($controllerName == 'HospitalController' || $controllerName == 'CenterController')  && $methodName != "index" && $methodName != "reserveSuccess")
                <meta property="og:image" content="/uploads/doctors/{{ \App\Models\Hospital::findOrFail( request()->route()->id)->image }}" />
            @else
                <meta property="og:image" content="/assets/frontend//images/general/logo_200.png" />
            @endif
            @if (!$qanswers_ar->isEmpty())
                <script type="application/ld+json">{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[{"@type":"Question","name":"{{$qanswers_ar->first()->name}}","acceptedAnswer":{"@type":"Answer","text":"{!! strip_tags($qanswers_ar->first()->description) !!}" }},
                {"@type":"Question","name":"{{$qanswers_ar->skip(1)->first()->name}}","acceptedAnswer":{"@type":"Answer","text":"{!! strip_tags($qanswers_ar->skip(1)->first()->description) !!}" }},
                {"@type":"Question","name":"{{$qanswers_ar->skip(2)->first()->name}}","acceptedAnswer":{"@type":"Answer","text":"{!! strip_tags($qanswers_ar->skip(2)->first()->description) !!}" }} ]}</script><!--FAQPage Code -->
            @endif
        @elseif(isset($controllerName) && ($controllerName == 'HospitalController' || $controllerName == 'CenterController'))
            @if(\App::getLocale()=='ar')
                <meta name="description" content=" تعرف علي @if(basename($_SERVER['REQUEST_URI']) == 'address' ) {{ trans('general.address') }} @endif
@if(basename($_SERVER['REQUEST_URI']) == 'phone' ) {{ trans('general.phones') }} @endif @if(isset($page_title)){{ $page_title }} @endif  @if(isset($tag)) - {{ $tag->name }} @endif  واعرف رقم التليفون والعنوان على الخريطة، ويمكنك البحث عن التأمينات المتعاقد معها، وتقييمات المرضى">
                <title>أعرف كل المعلومات عن @if(basename($_SERVER['REQUEST_URI']) == 'address' ) {{ trans('general.address') }} @endif
                    @if(basename($_SERVER['REQUEST_URI']) == 'phone' ) {{ trans('general.phones') }} @endif 
                    @if(isset($page_title)){{ $page_title }} @endif  @if(isset($tag)) - {{ $tag->name }} @endif 
                    @if(\App::getLocale()=='ar')-  دكتورك  @else  - Doctorak  @endif   @if(isset($_GET['page']) && $_GET['page']) - {{$_GET['page']}} @endif</title>
            @else
                <meta name="description" content="Know information about the @if(isset($page_title)){{ $page_title }} @endif  @if(isset($tag)) - {{ $tag->name }} @endif and know the phone number, location on the map, patient valuation and the insurance entities that his is working with">
                <title>Know alءذl the information about @if(basename($_SERVER['REQUEST_URI']) == 'address' ) {{ trans('general.address') }} @endif
                    @if(basename($_SERVER['REQUEST_URI']) == 'phone' ) {{ trans('general.phones') }} @endif 
                    @if(isset($page_title)){{ $page_title }} @if($controllerName == 'HospitalController') Hospital @else Center @endif @endif  @if(isset($tag)) - {{ $tag->name }} @endif 
                    @if(\App::getLocale()=='ar')-  دكتورك  @else  - Doctorak  @endif   @if(isset($_GET['page']) && $_GET['page']) - {{$_GET['page']}} @endif</title>        
            @endif
        @elseif(isset($controllerName) && $controllerName == 'PharmacyController' && $methodName == "index")
            @if(\App::getLocale()=='ar')
                <meta name="description" content="اعرف معلومات عن افضل @if(isset($page_title)){{ $page_title }} @endif  @if(isset($tag)) - {{ $tag->name }} @endif واعرف رقم التليفون وحدد العنوان على الخريطة ومعرفة الخدمات المقدمة والتأمينات المتعاقد معها">
                <title>اعرف كل المعلومات عن افضل @if(isset($page_title)){{ $page_title }} @endif  @if(\App::getLocale()=='ar')-  دكتورك  @else  - Doctorak  @endif  @if(isset($_GET['page']) && $_GET['page']) - {{$_GET['page']}} @endif</title>
            @else
                <meta name="description" content="Know information about the best @if(isset($page_title)){{ $page_title }} @endif  @if(isset($tag)) - {{ $tag->name }} @endif and know the phone number, location on the map, the provided services and contracted insurance.">
                <title>Know information about the best @if(isset($page_title)){{ $page_title }} @endif @if(\App::getLocale()=='ar')-  دكتورك  @else  - Doctorak  @endif  @if(isset($_GET['page']) && $_GET['page']) - {{$_GET['page']}} @endif</title>
            @endif
            @if (!$qanswers_ar->isEmpty())
                <script type="application/ld+json">{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[{"@type":"Question","name":"{{$qanswers_ar->first()->name}}","acceptedAnswer":{"@type":"Answer","text":"{!! strip_tags($qanswers_ar->first()->description) !!}" }},
                {"@type":"Question","name":"{{$qanswers_ar->skip(1)->first()->name}}","acceptedAnswer":{"@type":"Answer","text":"{!! strip_tags($qanswers_ar->skip(1)->first()->description) !!}" }},
                {"@type":"Question","name":"{{$qanswers_ar->skip(2)->first()->name}}","acceptedAnswer":{"@type":"Answer","text":"{!! strip_tags($qanswers_ar->skip(2)->first()->description) !!}" }} ]}</script><!--FAQPage Code -->
            @endif
            {{-- <title>{{ getMainModuleTitle('pharmacies_best',$city, $area) }}  @if(isset($tag)) - {{ $tag->name }} @endif  @if(isset($tag)) - {{ $tag->name }} @endif - @if(\App::getLocale()=='ar')-  دكتورك  @else  - Doctorak  @endif   @if(isset($_GET['page']) && $_GET['page']) - {{$_GET['page']}} @endif</title> --}}
        @elseif(isset($controllerName) && $controllerName == 'PharmacyController')
            @if(\App::getLocale()=='ar')
                <meta name="description" content="تعرف علي جميع المعلومات الخاصة صيدلية  @if(isset($page_title)){{ $page_title }} @endif  @if(isset($tag)) - {{ $tag->name }} @endif عنوانه وارقام التليفون وتقييمات المرضى وقائمة بشركات التأمين المتعاقد معها عن طريق دكتورك">
                <title>اعرف كل المعلومات عن صيدلية @if(isset($page_title)){{ $page_title }} - @endif  دكتورك @if(isset($_GET['page']) && $_GET['page']) - {{$_GET['page']}} @endif</title>
            @else
                <meta name="description" content="Know information about the  @if(isset($page_title)){{ $page_title }} @endif  @if(isset($tag)) - {{ $tag->name }} @endif d know the phone number, location on the map,  the provided services and contracted insurance by Doctorak">
                <title>Know all the information about @if(isset($page_title)){{ $page_title }} @endif pharmacy @if(\App::getLocale()=='ar')-  دكتورك  @else  - Doctorak  @endif @if(isset($_GET['page']) && $_GET['page']) - {{$_GET['page']}} @endif</title>
            @endif
        @elseif(isset($controllerName) && $controllerName == 'LabController' && $methodName == "index")
            @if(\App::getLocale()=='ar')
                <meta name="description" content="اعرف معلومات عن افضل @if(isset($page_title)){{ $page_title }} @endif @if(isset($tag)) - {{ $tag->name }} @endif واعرف رقم التليفون وحدد العنوان على الخريطة ومعرفة الخدمات المقدمة والتأمينات المتعاقد معها">
                <title>اعرف كل المعلومات عن افضل @if(isset($page_title)){{ $page_title }} @endif  @if(\App::getLocale()=='ar')-  دكتورك  @else  - Doctorak  @endif  @if(isset($_GET['page']) && $_GET['page']) - {{$_GET['page']}} @endif</title>
            @else
                <meta name="description" content="Know information about the best  @if(isset($page_title)){{ $page_title }} @endif  @if(isset($tag)) - {{ $tag->name }} @endif and know the phone number, location on the map, the provided services and contracted insurance">
                <title>Know information about the best @if(isset($page_title)){{ $page_title }} @endif @if(\App::getLocale()=='ar')-  دكتورك  @else  - Doctorak  @endif  @if(isset($_GET['page']) && $_GET['page']) - {{$_GET['page']}} @endif</title>
            @endif
            @if (!$qanswers_ar->isEmpty())
                <script type="application/ld+json">{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[{"@type":"Question","name":"{{$qanswers_ar->first()->name}}","acceptedAnswer":{"@type":"Answer","text":"{!! strip_tags($qanswers_ar->first()->description) !!}" }},
                {"@type":"Question","name":"{{$qanswers_ar->skip(1)->first()->name}}","acceptedAnswer":{"@type":"Answer","text":"{!! strip_tags($qanswers_ar->skip(1)->first()->description) !!}" }},
                {"@type":"Question","name":"{{$qanswers_ar->skip(2)->first()->name}}","acceptedAnswer":{"@type":"Answer","text":"{!! strip_tags($qanswers_ar->skip(2)->first()->description) !!}" }} ]}</script><!--FAQPage Code -->
            @endif
            @elseif(isset($controllerName) && $controllerName == 'LabController')
            <link rel="stylesheet" as="style" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/less/mixins/panels.less">
            @if(\App::getLocale()=='ar')
                <meta name="description" content="تعرف علي جميع المعلومات عن @if(isset($page_title)){{ $page_title }} @endif @if(isset($tag)) - {{ $tag->name }} @endif عنوانه وارقام التليفون وتقييمات المرضى وقائمة بشركات التأمين المتعاقد معها عن طريق دكتورك">
                <title>اعرف كل المعلومات عن @if(isset($page_title)){{ $page_title }} - @endif  دكتورك @if(isset($_GET['page']) && $_GET['page']) - {{$_GET['page']}} @endif</title>
            @else
                <meta name="description" content="Know information about the @if(isset($page_title)){{ $page_title }} @endif @if(isset($tag)) - {{ $tag->name }} @endif and know the phone number, location on the map,  the provided services and contracted insurance by Doctorak">
                <title>Know all the information about @if(isset($page_title)){{ $page_title }} @endif lab @if(\App::getLocale()=='ar')-  دكتورك  @else  - Doctorak  @endif @if(isset($_GET['page']) && $_GET['page']) - {{$_GET['page']}} @endif</title>
            @endif
        {{-- @elseif(isset($controllerName) && $controllerName == 'CenterController' && $methodName == "index")
            @if(\App::getLocale()=='ar')
                <meta name="description" content="اعرف معلومات عن مركز  @if(isset($page_title)){{ $page_title }} @endif  @if(isset($tag)) - {{ $tag->name }} @endif واعرف رقم التليفون وحدد العنوان على الخريطة ومعرفة الخدمات وتقييمات المرضى والتأمينات المتعاقد معها">
            @else
                <meta name="description" content="Know information about the  @if(isset($page_title)){{ $page_title }} @endif  @if(isset($tag)) - {{ $tag->name }} @endif and know the phone number, location on the map, and the insurance entities that his is working with.">
            @endif
            <title>{{ getMainModuleTitle('centers_best',$city,$area,\App\Models\SubCategory::find($sub_cat) ?: $Speciality) }} @if(isset($tag)) - {{ $tag->name }} @endif - @if(\App::getLocale()=='ar')-  دكتورك  @else  - Doctorak  @endif  @if(isset($_GET['page']) && $_GET['page']) - {{$_GET['page']}} @endif</title> --}}
        @elseif(isset($controllerName) && $controllerName == 'MedicineController' && $methodName == "index")
            @if(\App::getLocale()=='ar')
                <meta name="description" content="تعرف علي جميع المعلومات عن @if(isset($page_title)){{ $page_title }} @endif @if(isset($tag)) - {{ $tag->name }} @endif واعرف معلومات كاملة عن كل دواء مثل تعليمات استخدام الدواء والجرعات والأعراض الجانبية">
                <title>@if(isset($page_title)){{ $page_title }} - @endif  دكتورك @if(isset($_GET['page']) && $_GET['page']) - {{$_GET['page']}} @endif</title>
            @else
                <meta name="description" content="Know information about the @if(isset($page_title)){{ $page_title }} @endif @if(isset($tag)) - {{ $tag->name }} @endif and know the phone number, location on the map,  the provided services and contracted insurance by Doctorak">
                <title>@if(isset($page_title)){{ $page_title }} @endif lab @if(\App::getLocale()=='ar')-  دكتورك  @else  - Doctorak  @endif @if(isset($_GET['page']) && $_GET['page']) - {{$_GET['page']}} @endif</title>
            @endif
            <title>@if(isset($page_title)){{ $page_title }}  @if(isset($tag)) - {{ $tag->name }} @endif @endif  @if(\App::getLocale()=='ar')-  دكتورك  @else  - Doctorak  @endif  @if(isset($_GET['page']) && $_GET['page']) - {{$_GET['page']}} @endif</title>
            @if ($qanswers_ar->count()> 0)
                <script type="application/ld+json">{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[{"@type":"Question","name":"{{$qanswers_ar->first()->name}}","acceptedAnswer":{"@type":"Answer","text":"{!! strip_tags($qanswers_ar->first()->description) !!}" }}
                @if($qanswers_ar->skip(1)->first()),{"@type":"Question","name":"{{$qanswers_ar->skip(1)->first()->name}}","acceptedAnswer":{"@type":"Answer","text":"{!! strip_tags($qanswers_ar->skip(1)->first()->description) !!}" }}@endif
                @if($qanswers_ar->skip(2)->first()),{"@type":"Question","name":"{{$qanswers_ar->skip(2)->first()->name}}","acceptedAnswer":{"@type":"Answer","text":"{!! strip_tags($qanswers_ar->skip(2)->first()->description) !!}" }}@endif
                @if($qanswers_ar->skip(3)->first()),{"@type":"Question","name":"{{$qanswers_ar->skip(3)->first()->name}}","acceptedAnswer":{"@type":"Answer","text":"{!! strip_tags($qanswers_ar->skip(3)->first()->description) !!}" }}@endif
                @if($qanswers_ar->skip(4)->first()),{"@type":"Question","name":"{{$qanswers_ar->skip(4)->first()->name}}","acceptedAnswer":{"@type":"Answer","text":"{!! strip_tags($qanswers_ar->skip(4)->first()->description) !!}" }}@endif
                @if($qanswers_ar->skip(5)->first()),{"@type":"Question","name":"{{$qanswers_ar->skip(5)->first()->name}}","acceptedAnswer":{"@type":"Answer","text":"{!! strip_tags($qanswers_ar->skip(5)->first()->description) !!}" }}@endif
                @if($qanswers_ar->skip(6)->first()),{"@type":"Question","name":"{{$qanswers_ar->skip(6)->first()->name}}","acceptedAnswer":{"@type":"Answer","text":"{!! strip_tags($qanswers_ar->skip(6)->first()->description) !!}" }}@endif
                @if($qanswers_ar->skip(7)->first()),{"@type":"Question","name":"{{$qanswers_ar->skip(7)->first()->name}}","acceptedAnswer":{"@type":"Answer","text":"{!! strip_tags($qanswers_ar->skip(7)->first()->description) !!}" }}@endif
                @if($qanswers_ar->skip(8)->first()),{"@type":"Question","name":"{{$qanswers_ar->skip(8)->first()->name}}","acceptedAnswer":{"@type":"Answer","text":"{!! strip_tags($qanswers_ar->skip(8)->first()->description) !!}" }}@endif
                @if($qanswers_ar->skip(9)->first()),{"@type":"Question","name":"{{$qanswers_ar->skip(9)->first()->name}}","acceptedAnswer":{"@type":"Answer","text":"{!! strip_tags($qanswers_ar->skip(9)->first()->description) !!}" }}@endif
                ]}</script><!--FAQPage Code -->
            @endif
        @elseif(isset($controllerName) && $controllerName == 'MedicineController')
            @if(\App::getLocale()=='ar')
                <meta name="description" content="اعرف كل المعلومات عن @if(isset($tag)) - {{ $tag->name }} @endif 
                @if(app()->getLocale() == 'ar')
                    @if($row->form == 'Tablets') اقراص @elseif ($row->form == 'Capsule') كبسولات 
                    @elseif ($row->form == 'Ampoules') أمبول @elseif ($row->form == 'Syrup') شراب 
                    @elseif ($row->form == 'Cream') كريم @elseif ($row->form == 'Sachets') اكياس 
                    @elseif ($row->form == 'Lotion') لوشن @elseif ($row->form == 'Drops') قطرة 
                    @elseif ($row->form == 'Antiseptic_Solution') محلول مطهر @elseif ($row->form == 'Infant_Milk') لبن اطفال 
                    @elseif ($row->form == 'Mouth_Wash') غسول فم @elseif ($row->form == 'Tea_bag') أكياس شاي 
                    @elseif ($row->form == 'Powder') بودرة @elseif ($row->form == 'Infusion') محلول معلق 
                    @elseif ($row->form == 'Inhalation') بخاخة للصدر @elseif ($row->form == 'Hair_Oil') زيت شعر 
                    @elseif ($row->form == 'Lozenges') استحلاب @elseif ($row->form == 'Oral_Drops') قطرة فم 
                    @elseif ($row->form == 'Vial') امبول @elseif ($row->form == 'Suppository') لبوس 
                    @elseif ($row->form == 'Vag.Douch') دش مهبلي @elseif ($row->form == 'Syringe') حقنه  @endif
                @else
                    {{ $row->form }}
                @endif {{$row->name}}  وطريقة استخدام  دواء {{$row->name}} والجرعات المناسبة والأعراض الجانبية لدواء {{$row->name}} وتعرف على سعر دواء {{$row->name}}">
                <title>@if(isset($page_title)){{ $page_title }} - @endif  دكتورك @if(isset($_GET['page']) && $_GET['page']) - {{$_GET['page']}} @endif</title>
            @else
                <meta name="description" content="Know information about the @if(isset($page_title)){{ $page_title }} @endif @if(isset($tag)) - {{ $tag->name }} @endif and know the phone number, location on the map,  the provided services and contracted insurance by Doctorak">
                <title>@if(isset($page_title)){{ $page_title }} @endif lab @if(\App::getLocale()=='ar')-  دكتورك  @else  - Doctorak  @endif @if(isset($_GET['page']) && $_GET['page']) - {{$_GET['page']}} @endif</title>
            @endif
            <title>@if(isset($page_title)){{ $page_title }}  @if(isset($tag)) - {{ $tag->name }} @endif @endif  @if(\App::getLocale()=='ar')-  دكتورك  @else  - Doctorak  @endif  @if(isset($_GET['page']) && $_GET['page']) - {{$_GET['page']}} @endif</title>
        @else
            @if(\App::getLocale()=='ar')
                <meta name="description" content="اعرف معلومات عن @if(isset($page_title)){{ $page_title }} @endif  @if(isset($tag)) - {{ $tag->name }} @endif واعرف رقم التليفون وحدد العنوان على الخريطة ومعرفة الخدمات وتقييمات المرضى والتأمينات المتعاقد معها">
            @else
                <meta name="description" content="Know information about the @if(isset($page_title)){{ $page_title }} @endif  @if(isset($tag)) - {{ $tag->name }} @endif and know the phone number, location on the map, and the insurance entities that his is working with.">
            @endif
            <title>@if(isset($page_title)){{ $page_title }}  @if(isset($tag)) - {{ $tag->name }} @endif @endif  @if(\App::getLocale()=='ar')-  دكتورك  @else  - Doctorak  @endif  @if(isset($_GET['page']) && $_GET['page']) - {{$_GET['page']}} @endif</title>
            <!-- CSS Files -->
            @if(isset($controllerName) && $controllerName == 'StaticPages')

                <!-- Bootstrap CSS -->
                <link rel="stylesheet" href="/calc/css/bootstrap.min.css">

                <!-- Animate CSS -->
                <link rel="stylesheet" href="/calc/css/animate.min.css">
                <link href="/calc/css/aos.css" rel="stylesheet">

                <link rel="stylesheet" href="/calc/css/cal-style.css">
                <!-- JS -->
                <script src="/calc/js/jquery-3.4.1.min.js"></script>
                <script src="/calc/js/jquery-dateformat.min.js"></script>
                <script src="/calc/js/popper.min.js"></script>
                <script src="/calc/js/bootstrap.min.js"></script>
                <script src="/calc/js/aos.js"></script>	
                <script src="/calc/js/plugin.js"></script>
            @endif
        @endif
        <meta name="robots content="index, follow>
        <link rel="canonical" href="https://doctorak.com{{$_SERVER['REQUEST_URI']}}" />

        <meta property="og:title" content="@if(isset($page_title)){{ $page_title }} @if(isset($tag)) - {{ $tag->name }} @endif - @endif  @if(\App::getLocale()=='ar')-  دكتورك  @else  - Doctorak  @endif " />
        <meta property="og:description" content="@if(isset($page_title)){{ $page_title }} @if(isset($tag)) - {{ $tag->name }} @endif - @endif  Help in accessing Health Care Services" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://doctorak.com{{$_SERVER['REQUEST_URI']}}" />
        <meta property="og:image" content="https://doctorak.fra1.cdn.digitaloceanspaces.com/logo_header.png" />
        <meta property="og:image:secure_url" content="https://doctorak.fra1.cdn.digitaloceanspaces.com/logo_header.png" />
        <meta property="og:image:type" content="image/png" />
        <meta property="og:image:width" content="100px" />
        <meta property="og:image:height" content="61px" />
        <meta property="og:image:alt" content="@if(isset($page_title)){{ $page_title }} @endif" />
        <meta property="og:site_name" content="Doctorak" />
        <link rel="apple-touch-icon" sizes="57x57" href="/assets/frontend/images/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/assets/frontend/images/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/assets/frontend/images/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/assets/frontend/images/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/assets/frontend/images/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/assets/frontend/images/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/assets/frontend/images/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/assets/frontend/images/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/assets/frontend/images/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="/assets/frontend/images/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="https://doctorak.fra1.cdn.digitaloceanspaces.com/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/assets/frontend/images/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/assets/frontend/images/favicon/favicon-16x16.png">
        {{-- <link rel="manifest" href="/manifest.json"> --}}
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
{{--
        @if(\App::getLocale()=='ar')
	    	{{
            mix.styles([
                "https://fonts.googleapis.com/css?family=Cairo:100,200,300,400,500,600,700,800,900",
                "/calc/css/bootstrap.min.css",
                "/calc/css/animate.min.css",
                "/calc/css/aos.css",
                "https://use.fontawesome.com/releases/v5.3.1/css/all.css",
                "/assets/frontend/css/doctorak_rtl.min.css",
                "/assets/frontend/css/custom.css"
                ], 'public/css/essentials.css');
            }}
        @else
            {{
            mix.styles([
                "https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900" rel="stylesheet" type="text/css",
                "/calc/css/bootstrap.min.css",
                "/calc/css/animate.min.css",
                "/calc/css/aos.css",
                "https://use.fontawesome.com/releases/v5.3.1/css/all.css",
                "/assets/frontend/css/doctorak.min.css",
                "/assets/frontend/css/custom.css"
               ], 'public/css/essentials.css');
            }}
        @endif --}}
        @if(isset($controllerName) && $controllerName != 'HomeController')
            <!-- Styles -->
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        @endif

        {{-- <link rel="stylesheet" href="/assets/frontend/css/custom.css?v=1.2"> --}}
    </head>
    <body class="{{ \App::getLocale()=='ar' ? 'is_rtl' : '' }} " itemscope @if(isset($controllerName) && $controllerName == 'MedicineController') itemtype="https://schema.org/Drug" @else itemtype="http://schema.org/WebPage" @endif>

        @include('frontend.partials.responsive_header')

        @if(isset($controllerName) && $controllerName == 'HomeController')
            @include('frontend.partials.home_header')
        @else
            @include('frontend.partials.header')
        @endif
        @if($errors->any())
            <h4>{{$errors->first()}}</h4>
        @endif

        @yield('content')
        @include('frontend.partials.footer')
        @include('frontend.partials.signin_signup_modal')
        @include('frontend.partials.responsive_nav_block')
        @include('frontend.partials.responsive_nav_search_block')
        @include('frontend.partials.full_nav')

    <script>
      window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
      ga('create', 'UA-152937650-1', 'auto');
      ga('send', 'pageview');
    </script>
    {{-- <script async src='https://www.google-analytics.com/analytics.js' rel="preload" ></script> --}}

    <script>
        appVars = {
            'site_url': '{{ env('FULL_DEFAULT_DOMAIN') }}',
            'lang': '{{ \App::getLocale() }}',
        }
    </script>

    <!-- Scribts -->
    @yield('js')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

    @if(isset($controllerName) && $controllerName == 'HomeController')
        <script>
            (function() {
                $('input[name="name"]').on('input', function() {
                    $('.speciality').attr("required", false);
                    $('.bsCityies').attr("required", false);
                });
            })();
        </script>
    @endif

    <script>

        document.addEventListener("DOMContentLoaded", function(event) {
            // (function() {
            // "use strict";
            // Toggle responsive navigation
            $( "#responsive_nav_toggler" ).on( "click", function() {
                $("#responsive_nav_block").toggleClass('opened');
                $("#overlay").toggleClass('opened');
                $("body").toggleClass('responsive_nav_opened');
            });
            $("#responsive_nav_block_close").on( "click", function () {
                $("#responsive_nav_block").removeClass('opened');
                $("#overlay").removeClass('opened');
                $("body").removeClass('responsive_nav_opened');
            } );
            $("#overlay").on( "click", function () {
                $("#responsive_nav_block").removeClass('opened');
                $("#overlay").removeClass('opened');
                $("body").removeClass('responsive_nav_opened');
            } );

            // Clone Search From Into Search Modal
            var Cloner = $( "#the_search_form" ).clone();

            $( "#responsive_nav_search_block_inner" ).html(Cloner);

            @if(basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)) == 'medicines' )
                $('[name="category"]').selectpicker('refresh');
            // @else
            //     $('[name="speciality"]').selectpicker('refresh');
            //     $('[name="city"]').selectpicker('refresh');
            //     $('[name="area"]').selectpicker('refresh');
            //     $('[name="insurance_company"]').selectpicker('refresh');
            @endif

        });

    </script>
    <script nonce="{{ csp_nonce() }}" src="/assets/frontend/css/app.min.js" async rel="preload" ></script>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org/",
      "@type": "WebSite",
      "name": "Doctorak",
      "url": "https://doctorak.com/",
      "potentialAction": {
        "@type": "SearchAction",
        "target": "https://doctorak.com/eg/doctor?speciality=&city=&area=&insurance_company=&name={search_term_string}",
        "query-input": "required name=search_term_string"
      }
    }
    </script>
    {{-- <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3676347686140649"
     crossorigin="anonymous"></script> --}}
<style>
@media (max-width:767.98px){
    html, body {
        overflow-x: hidden;
    }
}
p {
    font-family: Cairo,Tahoma,sans-serif;
}
</style>
</body>
</html>
