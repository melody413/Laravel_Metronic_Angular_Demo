<header class="header responsive_header">
    <div class="lazy yellow_shape_responsive_lazy" data-bg="https://doctorak.fra1.cdn.digitaloceanspaces.com/yellow_shape_responsive.png" ></div>
    <div class="responsive_header_inner flexer flexer_jc_space_between flexer_ai_center">
        <div class="logo_holder">
            <a href="{{ getCountryLangUrl() }}" class="logo">
                <img src="https://doctorak.fra1.cdn.digitaloceanspaces.com/logo_header.png" alt="doctorak logo header" width="50" height="30">
            </a>
        </div>
        <div class="responsive_nav_holder flexer flexer_jc_space_evenly flexer_ai_center">
            @if(isset($controllerName) && $controllerName != 'HomeController')
                <button id="responsive_nav_search_btn" class="responsive_nav_search_btn" data-toggle="modal" data-target="#responsive_nav_search_block"><i class="icon-search"></i></button>
                <button id="responsive_nav_toggler" class="responsive_nav_toggler"><i class="fas fa-bars"></i></button>
            @else
                <button id="responsive_nav_toggler" class="responsive_nav_toggler"><i class="icon-01"></i></button>
            @endif
        </div>
    </div>
</header>