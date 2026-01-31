@extends('layouts.frontend')
@section('title', $title ?? 'IoT Knowledge Center')

@section('content')
<main class="content-wrapper">
    
    <section class="container pt-3 mb-4">
        <div class="row">
            <div class="col-12">
                <div class="position-relative">
                    <span class="position-absolute top-0 start-0 w-100 h-100 rounded-5 d-none-dark rtl-flip" style="background:linear-gradient(90deg, #accbee 0%, #e7f0fd 100%)"></span>
                    <span class="position-absolute top-0 start-0 w-100 h-100 rounded-5 d-none d-block-dark rtl-flip" style="background:linear-gradient(90deg, #1b273a 0%, #1f2632 100%)"></span>

                    <div class="row justify-content-center position-relative z-2">
                        {{-- Cột nội dung chữ --}}
                        <div class="col-xl-5 col-xxl-4 offset-xxl-1 d-flex align-items-center mt-xl-n3">
                            <div class="swiper px-5 pe-xl-0 ps-xxl-0 me-xl-n5"
                                data-swiper='{"spaceBetween": 64, "loop": true, "speed": 400, "controlSlider": "#sliderImages", "autoplay": {"delay": 4000, "disableOnInteraction": false}, "scrollbar": {"el": ".swiper-scrollbar"}}'>

                                <div class="swiper-wrapper">
                                    {{-- Đổi Featured Products thành Featured Articles --}}
                                    @foreach($articles->take(5) as $art) 
                                    <div class="swiper-slide text-center text-xl-start pt-5 py-xl-5">
                                        <p class="text-body">{{ $art->Topic->name ?? 'IoT Insight' }}</p>

                                        <h2 class="display-4 pb-2 pb-xl-4">{{ Str::limit($art->title, 50) }}</h2>

                                        <a class="btn btn-lg btn-primary" href="{{ route('frontend.articles.article_topic_details', ['topicname_slug' => $art->Topic->slug, 'title_slug' => $art->slug]) }}">
                                            Read More ({{ number_format($art->views) }} views)
                                            <i class="ci-arrow-up-right fs-lg ms-2 me-n1"></i>
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Cột hình ảnh --}}
                        <div class="col-9 col-sm-7 col-md-6 col-lg-5 col-xl-7">
                            <div class="swiper user-select-none" id="sliderImages" data-swiper='{"allowTouchMove": false, "loop": true, "effect": "fade", "fadeEffect": {"crossFade": true}}'>
                                <div class="swiper-wrapper">
                                    @foreach($articles->take(5) as $art)
                                    <div class="swiper-slide d-flex justify-content-end">
                                        <div class="ratio rtl-flip" style="max-width:495px; --cz-aspect-ratio:calc(537 / 495 * 100%)">
                                            <img src="{{ asset('storage/app/private/'. ($art->image ?? 'default.png')) }}" alt="{{ $art->title }}" class="rounded-5 shadow" style="object-fit: cover;"/>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

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

    <section class="container mb-5">
        <h5 class="mb-3 text-muted small text-uppercase fw-bold">Explore Content Types</h5>
        <div class="overflow-auto" data-simplebar data-simplebar-auto-hide="false">
            <div class="d-flex flex-nowrap align-items-center gap-3" style="min-width: max-content;">
                @foreach($article_types as $type)
                <div style="flex-shrink: 0;">
                    <a class="btn btn-outline-secondary rounded-pill px-4 py-2" 
                       href="{{ route('frontend.articles.types', ['article_type_slug' => $type->slug]) }}">
                        <i class="fas fa-layer-group me-2"></i>{{ $type->name }}
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    @foreach($topics as $topic)
    @php 
        // Lấy bài viết thuộc topic hiện tại
        $topicArticles = $articles->where('topicid', $topic->id)->take(4); 
    @endphp
    
    @if($topicArticles->count() > 0)
    <section class="container pt-2 mt-2 mb-5">
        {{-- Heading của Topic --}}
        <div class="d-flex align-items-center justify-content-between border-bottom pb-3 pb-md-4">
            <h2 class="h3 mb-0"><i class="fas fa-hashtag text-primary me-2"></i>{{ $topic->name }}</h2>
            <div class="nav ms-3">
                <a class="nav-link animate-underline px-0 py-2" href="{{ route('frontend.articles.topics', ['topicname_slug' => $topic->slug]) }}">
                    <span class="animate-target">View All in Topic</span> <i class="ci-chevron-right fs-base ms-1"></i>
                </a>
            </div>
        </div>

        {{-- Grid bài viết --}}
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 pt-4">
            @foreach($topicArticles as $art)
            <div class="col">
                <div class="product-card animate-underline hover-effect-opacity bg-body rounded shadow-sm border-0">
                    <div class="position-relative">
                        {{-- Nút lưu nhanh bài viết (Giữ nguyên class Cartzilla) --}}
                        <div class="position-absolute top-0 end-0 z-2 hover-effect-target opacity-0 mt-3 me-3">
                            <div class="d-flex flex-column gap-2">
                                <button type="button" class="btn btn-icon btn-secondary animate-pulse d-none d-lg-inline-flex shadow">
                                    <i class="fas fa-bookmark fs-base animate-target"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Hình ảnh bài viết --}}
                        <a class="d-block rounded-top overflow-hidden p-0" href="{{ route('frontend.articles.article_topic_details', ['topicname_slug' => $topic->slug, 'title_slug' => $art->slug]) }}">
                            <div class="ratio" style="--cz-aspect-ratio:calc(240 / 300 * 100%)">
                                <img src="{{ asset('storage/app/private/' . $art->image) }}" class="img-fluid" alt="{{ $art->title }}" style="object-fit: cover;"/>
                            </div>
                            {{-- Badge loại bài viết --}}
                            <span class="badge bg-info position-absolute top-0 start-0 mt-2 ms-2">{{ $art->ArticleType->name ?? 'IoT' }}</span>
                        </a>
                    </div>

                    <div class="w-100 min-w-0 px-3 pb-3 pt-3">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="d-flex gap-1 fs-xs text-warning">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="text-body-tertiary fs-xs">Featured</span>
                        </div>

                        <h3 class="pb-1 mb-2">
                            <a class="d-block fs-sm fw-bold text-truncate" href="{{ route('frontend.articles.article_topic_details', ['topicname_slug' => $topic->slug, 'title_slug' => $art->slug]) }}">
                                <span class="animate-target">{{ $art->title }}</span>
                            </a>
                        </h3>

                        <div class="d-flex align-items-center justify-content-between mt-3">
                            {{-- Thay giá bằng Views --}}
                            <div class="h6 mb-0 text-primary">
                                <i class="fas fa-eye me-1 small"></i>{{ number_format($art->views) }} 
                                <small class="text-muted" style="font-size: 0.6rem">VIEWS</small>
                            </div>
                            {{-- Nút đọc ngay (Dùng lại class product-card-button) --}}
                            <a href="{{ route('frontend.articles.article_topic_details', ['topicname_slug' => $topic->slug, 'title_slug' => $art->slug]) }}" 
                               class="product-card-button btn btn-icon btn-secondary animate-slide-end ms-2">
                                <i class="fas fa-arrow-right fs-base animate-target"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif
    @endforeach
</main>
@endsection