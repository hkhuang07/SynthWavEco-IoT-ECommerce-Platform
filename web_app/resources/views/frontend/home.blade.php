@extends('layouts.frontend')
@section('title', 'Trang chủ')
@section('content')
<!-- Page content -->
<main class="content-wrapper">
    <!-- Hero slider -->
    <section class="container pt-3 mb-4">
        <div class="row">
            <div class="col-12">
                <div class="position-relative">
                    <span class="position-absolute top-0 start-0 w-100 h-100 rounded-5 d-none-dark rtl-flip" style="background:linear-gradient(90deg, #accbee 0%, #e7f0fd 100%)"></span>
                    <span class="position-absolute top-0 start-0 w-100 h-100 rounded-5 d-none d-block-dark rtl-flip" style="background:linear-gradient(90deg, #1b273a 0%, #1f2632 100%)"></span>

                    <div class="row justify-content-center position-relative z-2">

                        <div class="col-xl-5 col-xxl-4 offset-xxl-1 d-flex align-items-center mt-xl-n3">
                            <div class="swiper px-5 pe-xl-0 ps-xxl-0 me-xl-n5"
                                data-swiper='{"spaceBetween": 64, "loop": true, "speed": 400, "controlSlider": "#sliderImages", "autoplay": {"delay": 3000, "disableOnInteraction": false}, "scrollbar": {"el": ".swiper-scrollbar"}}'>

                                <div class="swiper-wrapper">
                                    @foreach($featuredProducts as $product)
                                    <div class="swiper-slide text-center text-xl-start pt-5 py-xl-5">
                                        <p class="text-body">{{ $product->category->name ?? 'IoT Product' }} Deal!</p>

                                        <h2 class="display-4 pb-2 pb-xl-4">{{ $product->name }}</h2>

                                        <a class="btn btn-lg btn-primary" href="{{ route('frontend.products.details', ['categoryname_slug' => $product->category->slug, 'productname_slug' => $product->slug]) }}">
                                            Shop Now ${{ number_format($product->price, 0) }}
                                            <i class="ci-arrow-up-right fs-lg ms-2 me-n1"></i>
                                        </a>
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>

                        <div class="col-9 col-sm-7 col-md-6 col-lg-5 col-xl-7">
                            <div class="swiper user-select-none" id="sliderImages" data-swiper='{"allowTouchMove": false, "loop": true, "effect": "fade", "fadeEffect": {"crossFade": true}}'>
                                <div class="swiper-wrapper">

                                    @foreach($featuredProducts as $product)
                                    <div class="swiper-slide d-flex justify-content-end">
                                        <div class="ratio rtl-flip" style="max-width:495px; --cz-aspect-ratio:calc(537 / 495 * 100%)">
                                            <img src="{{ asset('storage/app/private/'. optional($product->avatar)->url) }}" alt="{{ $product->name }}" />
                                        </div>
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Scrollbar --}}
                    <div class="row justify-content-center" data-bs-theme="dark">
                        <div class="col-xxl-10">
                            <div class="position-relative mx-5 mx-xxl-0">
                                <div class="swiper-scrollbar mb-4"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Brands -->
    <!--section class="container mb-2">
        <div class="overflow-auto" data-simplebar data-simplebar-auto-hide="false">
            <div class="row row-cols-6 g-0" style="min-width:960px">
                @foreach($manufactures as $value )
                <div class="col">
                    <a class="d-flex justify-content-center py-3 px-2 px-xl-3" href="#">
                        <img src="{{ asset('storage/app/private/'.$value->logo)}}" class="d-none-dark" alt="No Logo" />
                        <img src="{{ asset('storage/app/private/'.$value->logo) }}" class="d-none d-block-dark" alt="No Logo" />
                    </a>
                </div>
                @endforeach    
            </div>
        </div>
    </section-->
    <section class="container mb-2">
        <div class="overflow-auto" data-simplebar data-simplebar-auto-hide="false">

            <div class="d-flex flex-nowrap align-items-center" style="min-width: max-content;">
                @foreach($manufactures as $value )
                <div style="width: 160px; flex-shrink: 0;">
                    <a class="d-flex justify-content-center py-3 px-2 px-xl-3" href="{{ route('frontend.products.product_manufacturer_details', ['manufacturer_slug' => $product->manufacturer->slug, 'productname_slug' => $product->slug]) }}">
                        <img src="{{ asset('storage/app/private/'.$value->logo)}}" class="d-block d-none-dark" alt="{{ $value->name }}" style="max-height: 40px;" />
                        <img src="{{ asset('storage/app/private/'.$value->logo) }}" class="d-none d-block-dark" alt="{{ $value->name }}" style="max-height: 40px;" />
                    </a>
                </div>
                @endforeach
            </div>

        </div>
    </section>

    <!-- Products (Grid) -->
    <section class="container pt-2 mt-2 mb-3">

        <!-- Products (Grid) -->
        @foreach($categories as $cate)
        <section class="container pt-2 mt-2 mb-3">
            <!-- Heading -->
            @if($cate->products->count() > 0)
            <div class="d-flex align-items-center justify-content-between border-bottom pb-3 pb-md-4">
                <h2 class="h3 mb-0">{{ $cate->name }}</h2>
                <div class="nav ms-3">
                    <a class="nav-link animate-underline px-0 py-2" href="{{ route('frontend.products.categories', ['categoryname_slug' => $cate->slug])}}">
                        <span class="animate-target">View All</span> <i class="ci-chevron-right fs-base ms-1"></i>
                    </a>
                </div>
            </div>
            @endif

            <!-- Product grid -->
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4 pt-4">
                <!-- Item -->
                @foreach($cate->products as $prod)
                <div class="col">
                    <div class="product-card animate-underline hover-effect-opacity bg-body rounded">
                        <div class="position-relative">
                            <div class="position-absolute top-0 end-0 z-2 hover-effect-target opacity-0 mt-3 me-3">
                                <div class="d-flex flex-column gap-2">
                                    <button type="button" class="btn btn-icon btn-secondary animate-pulse d-none d-lg-inline-flex">
                                        <i class="ci-heart fs-base animate-target"></i>
                                    </button>
                                    <button type="button" class="btn btn-icon btn-secondary animate-rotate d-none d-lg-inline-flex">
                                        <i class="ci-refresh-cw fs-base animate-target"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="dropdown d-lg-none position-absolute top-0 end-0 z-2 mt-2 me-2">
                                <button type="button" class="btn btn-icon btn-sm btn-secondary bg-body" data-bs-toggle="dropdown">
                                    <i class="ci-more-vertical fs-lg"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end fs-xs p-2" style="min-width:auto">
                                    <li>
                                        <a class="dropdown-item" href="#"><i class="ci-heart fs-sm ms-n1 me-2"></i> Thêm vào yêu thích</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#"><i class="ci-refresh-cw fs-sm ms-n1 me-2"></i> So sánh</a>
                                    </li>
                                </ul>
                            </div>
                            <a class="d-block rounded-top overflow-hidden p-3 p-sm-4" href="{{ route('frontend.products.details', ['categoryname_slug' => $cate->slug, 'productname_slug' => $prod->slug]) }}">
                                <div class="ratio" style="--cz-aspect-ratio:calc(240 / 258 * 100%)">
                                    <img src="{{ asset('storage/app/private/' . optional($prod->avatar)->url) }}" />
                                </div>
                                <span class="badge bg-info position-absolute top-0 start-0 mt-2 ms-2 mt-lg-3 ms-lg-3">Mới</span>
                            </a>
                        </div>
                        <div class="w-100 min-w-0 px-1 pb-2 px-sm-3 pb-sm-3">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="d-flex gap-1 fs-xs">
                                    <i class="ci-star-filled text-warning"></i>
                                    <i class="ci-star-filled text-warning"></i>
                                    <i class="ci-star-filled text-warning"></i>
                                    <i class="ci-star-filled text-warning"></i>
                                    <i class="ci-star text-body-tertiary opacity-75"></i>
                                </div>
                                <span class="text-body-tertiary fs-xs">(123)</span>
                            </div>
                            <h3 class="pb-1 mb-2">
                                <a class="d-block fs-sm fw-medium text-truncate" href="{{ route('frontend.products.details', ['categoryname_slug' => $cate->slug, 'productname_slug' => $prod->slug]) }}">
                                    <span class="animate-target">{{ $prod->name }}</span>
                                </a>
                            </h3>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="h5 lh-1 mb-0">{{ number_format($prod->price, 0, ',', '.') }}<small>$</small></div>
                                <a href="{{ route('frontend.shoppingcard.add', ['productname_slug' => $prod->slug]) }}" class="product-card-button btn btn-icon btn-secondary animate-slide-end ms-2">
                                    <i class="ci-shopping-cart fs-base animate-target"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endforeach
</main>
@endsection