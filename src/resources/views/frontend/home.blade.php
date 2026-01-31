@extends('layouts.frontend')
@section('title', 'Trang chủ')
@section('content')
<!-- Page content -->
<main class="content-wrapper">
    <!-- ============================================
         HERO SECTION - Featured Products & Articles Split
         ============================================ -->
    <section class="hero-showcase mb-5">
        <div class="container-fluid px-0">
            <div class="row g-0">
                <!-- Left: Featured Products Carousel -->
                <div class="col-lg-6 hero-products-section">
                    <div class="hero-content-wrapper">
                        <div class="swiper hero-products-swiper" data-swiper='{"spaceBetween": 0, "loop": true, "speed": 600, "autoplay": {"delay": 5000, "disableOnInteraction": false}, "effect": "fade", "fadeEffect": {"crossFade": true}}'>
                            <div class="swiper-wrapper">
                                @foreach($featuredProducts->take(6) as $product)
                                <div class="swiper-slide">
                                    <div class="hero-product-item">
                                        <div class="hero-product-image">
                                            <img src="{{ asset('storage/app/private/'. optional($product->avatar)->url) }}" alt="{{ $product->name }}" />
                                        </div>
                                        <div class="hero-product-info">
                                            <p class="hero-label">{{ $product->category->name ?? 'IoT Product' }}</p>
                                            <h2 class="hero-title">{{ Str::limit($product->name, 40) }}</h2>
                                            <p class="hero-price">{{ number_format($product->price, 0, ',', '.') }}₫</p>
                                            <a href="{{ route('frontend.products.product_category_details', ['categoryname_slug' => $product->category->slug, 'productname_slug' => $product->slug]) }}" class="btn btn-lg btn-primary">
                                                Shop Now <i class="ci-arrow-up-right ms-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination hero-pagination"></div>
                        </div>
                    </div>
                </div>

                <!-- Right: Featured Articles Carousel -->
                <div class="col-lg-6 hero-articles-section">
                    <div class="hero-content-wrapper">
                        <div class="swiper hero-articles-swiper" data-swiper='{"spaceBetween": 0, "loop": true, "speed": 600, "autoplay": {"delay": 5000, "disableOnInteraction": false}, "effect": "fade", "fadeEffect": {"crossFade": true}}'>
                            <div class="swiper-wrapper">
                                @foreach($featuredArticles->take(6) as $article)
                                <div class="swiper-slide">
                                    <div class="hero-article-item" style="background-image: url('{{ asset('storage/app/private/'. ($article->image ?? 'default.png')) }}')">
                                        <div class="hero-article-overlay"></div>
                                        <div class="hero-article-info">
                                            <p class="hero-label">{{ $article->Topic->name ?? 'IoT Insight' }}</p>
                                            <h2 class="hero-title">{{ Str::limit($article->title, 50) }}</h2>
                                            <div class="hero-article-meta">
                                                <span class="views-badge"><i class="ci-eye me-1"></i>{{ number_format($article->views) }}</span>
                                            </div>
                                            <a href="{{ route('frontend.articles.article_topic_details', ['topicname_slug' => $article->Topic->slug, 'title_slug' => $article->slug]) }}" class="btn btn-sm btn-outline-light">
                                                Read More <i class="ci-arrow-up-right ms-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination hero-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================
         NAVIGATION SECTIONS - Different Styles
         ============================================ -->
    <section class="container pt-4 mb-5">
        <!-- Row 1: Article Types & Topics (Horizontal Tabs) -->
        <div class="row mb-5">
            <div class="col-12">
                <h3 class="section-title mb-4">
                    <i class="ci-newspaper text-success me-2"></i>Browse by Content Type
                </h3>
                <div class="nav-tabs-wrapper">
                    <ul class="nav nav-tabs nav-tabs-custom flex-nowrap" role="tablist" style="overflow-x: auto; scrollbar-width: thin;">
                        @foreach($article_types as $type)
                        <li class="nav-item" role="presentation">
                            <a class="nav-link @if($loop->first)active @endif" href="{{ route('frontend.articles.types', ['article_type_slug' => $type->slug]) }}">
                                <i class="ci-tag me-2"></i>{{ $type->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Row 2: Topics (Icon Grid) -->
        <div class="row mb-5">
            <div class="col-12">
                <h3 class="section-title mb-4">
                    <i class="ci-folder text-info me-2"></i>Article Topics
                </h3>
                <div class="topics-grid">
                    @foreach($topics as $topic)
                    <a href="{{ route('frontend.articles.topics', ['topicname_slug' => $topic->slug]) }}" class="topic-card">
                        <div class="topic-icon">
                            <img src="{{ asset('storage/app/private/'.$topic->image)}}" alt="{{ $topic->name }}" />
                        </div>
                        <span class="topic-name">{{ $topic->name }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Row 3: Product Categories (Card Style) -->
        <div class="row mb-5">
            <div class="col-12">
                <h3 class="section-title mb-4">
                    <i class="ci-bag text-warning me-2"></i>Shop by Category
                </h3>
                <div class="categories-carousel">
                    <div class="swiper categories-swiper" data-swiper='{"slidesPerView": "auto", "spaceBetween": 20, "loop": true, "autoplay": {"delay": 6000, "disableOnInteraction": false}}'>
                        <div class="swiper-wrapper">
                            @foreach($categories as $category)
                            <div class="swiper-slide category-slide">
                                <a href="{{ route('frontend.products.categories', ['categoryname_slug' => $category->slug]) }}" class="category-card">
                                    <div class="category-image">
                                        <img src="{{ asset('storage/app/private/'.$category->image)}}" alt="{{ $category->name }}" />
                                    </div>
                                    <h4 class="category-name">{{ $category->name }}</h4>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 4: Manufacturers (Logo Showcase) -->
        <div class="row mb-5">
            <div class="col-12">
                <h3 class="section-title mb-4">
                    <i class="ci-building text-primary me-2"></i>Top Manufacturers
                </h3>
                <div class="manufacturers-grid">
                    @foreach($manufactures as $manufacturer)
                    <a href="{{ route('frontend.products.manufacturers', ['manufacturer_slug' => $manufacturer->slug]) }}" class="manufacturer-item">
                        <div class="manufacturer-logo">
                            <img src="{{ asset('storage/app/private/'.$manufacturer->logo)}}" alt="{{ $manufacturer->name }}" />
                        </div>
                        <p class="manufacturer-name">{{ $manufacturer->name }}</p>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================
         FEATURED PRODUCTS BY CATEGORY
         ============================================ -->
    <section class="container pt-2 mt-2 mb-5">
        @foreach($categories as $cate)
        @if($cate->products->count() > 0)
        <section class="category-section mb-5">
            <!-- Section Header -->
            <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-4">
                <div>
                    <h2 class="h3 mb-0">{{ $cate->name }}</h2>
                    <p class="text-muted small mb-0">{{ $cate->products->count() }} products available</p>
                </div>
                <a class="btn btn-outline-primary animate-underline" href="{{ route('frontend.products.categories', ['categoryname_slug' => $cate->slug])}}">
                    View All <i class="ci-chevron-right ms-1"></i>
                </a>
            </div>

            <!-- Product Grid -->
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
                @foreach($cate->products->take(8) as $prod)
                <div class="col">
                    <div class="product-card animate-underline hover-effect-opacity bg-body rounded">
                        <div class="position-relative">
                            <!-- Quick Actions -->
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

                            <!-- Mobile Menu -->
                            <div class="dropdown d-lg-none position-absolute top-0 end-0 z-2 mt-2 me-2">
                                <button type="button" class="btn btn-icon btn-sm btn-secondary bg-body" data-bs-toggle="dropdown">
                                    <i class="ci-more-vertical fs-lg"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end fs-xs p-2" style="min-width:auto">
                                    <li><a class="dropdown-item" href="#"><i class="ci-heart fs-sm ms-n1 me-2"></i>Add to Favorites</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="ci-refresh-cw fs-sm ms-n1 me-2"></i>Compare</a></li>
                                </ul>
                            </div>

                            <!-- Product Image -->
                            <a class="d-block rounded-top overflow-hidden p-3 p-sm-4" href="{{ route('frontend.products.product_category_details', ['categoryname_slug' => $cate->slug, 'productname_slug' => $prod->slug]) }}">
                                <div class="ratio" style="--cz-aspect-ratio:calc(240 / 258 * 100%)">
                                    <img src="{{ asset('storage/app/private/' . optional($prod->avatar)->url) }}" alt="{{ $prod->name }}" />
                                </div>
                                <span class="badge bg-info position-absolute top-0 start-0 mt-2 ms-2 mt-lg-3 ms-lg-3">New</span>
                            </a>
                        </div>

                        <!-- Product Info -->
                        <div class="w-100 min-w-0 px-1 pb-2 px-sm-3 pb-sm-3">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="d-flex gap-1 fs-xs">
                                    @for($i = 0; $i < 4; $i++)
                                    <i class="ci-star-filled text-warning"></i>
                                    @endfor
                                    <i class="ci-star text-body-tertiary opacity-75"></i>
                                </div>
                                <span class="text-body-tertiary fs-xs">(42)</span>
                            </div>
                            <h3 class="pb-1 mb-2">
                                <a class="d-block fs-sm fw-medium text-truncate" href="{{ route('frontend.products.product_category_details', ['categoryname_slug' => $cate->slug, 'productname_slug' => $prod->slug]) }}">
                                    <span class="animate-target">{{ $prod->name }}</span>
                                </a>
                            </h3>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="h5 lh-1 mb-0">{{ number_format($prod->price, 0, ',', '.') }}<small>₫</small></div>
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
        @endif
        @endforeach
    </section>

    <!-- ============================================
         SERVICES & FEATURES SECTION
         ============================================ -->
    <section class="container mb-5">
        <h2 class="section-title text-center mb-5">
            <i class="ci-star text-success me-2"></i>Why Choose Synwaveco
        </h2>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="ci-rocket"></i>
                    </div>
                    <h4>Fast Shipping</h4>
                    <p>Free shipping on orders over 500k. Quick delivery to your doorstep.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="ci-shield"></i>
                    </div>
                    <h4>Secure Payment</h4>
                    <p>100% secure transactions with multiple payment methods available.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="ci-undo"></i>
                    </div>
                    <h4>Easy Returns</h4>
                    <p>30-day money-back guarantee on all products. No questions asked.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="ci-headphones"></i>
                    </div>
                    <h4>24/7 Support</h4>
                    <p>Expert customer support available anytime, anywhere. Chat with us now.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================
         PARTNERSHIP OPPORTUNITIES
         ============================================ -->
    <section class="container mb-5">
        <div class="row g-4">
            <!-- Become a Seller -->
            <div class="col-lg-6">
                <div class="partnership-card seller-card">
                    <div class="partnership-header">
                        <i class="ci-bag-check"></i>
                        <h3>Become a Seller</h3>
                    </div>
                    <p class="partnership-description">
                        Join our growing network of sellers. Expand your business and reach thousands of customers.
                    </p>
                    <ul class="partnership-benefits">
                        <li><i class="ci-check"></i> Low commission rates</li>
                        <li><i class="ci-check"></i> Free marketing support</li>
                        <li><i class="ci-check"></i> Dedicated account manager</li>
                        <li><i class="ci-check"></i> Flexible payment terms</li>
                    </ul>
                    <a href="{{ route('frontend.recruitment') }}" class="btn btn-primary btn-lg w-100">
                        Apply Now <i class="ci-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>

            <!-- Become a Shipper -->
            <div class="col-lg-6">
                <div class="partnership-card shipper-card">
                    <div class="partnership-header">
                        <i class="ci-truck"></i>
                        <h3>Become a Shipper</h3>
                    </div>
                    <p class="partnership-description">
                        Partner with us for logistics. Earn competitive rates with flexible schedules.
                    </p>
                    <ul class="partnership-benefits">
                        <li><i class="ci-check"></i> Competitive compensation</li>
                        <li><i class="ci-check"></i> Flexible work schedule</li>
                        <li><i class="ci-check"></i> Real-time tracking system</li>
                        <li><i class="ci-check"></i> Insurance coverage included</li>
                    </ul>
                    <a href="{{ route('frontend.recruitment') }}" class="btn btn-outline-primary btn-lg w-100">
                        Join Our Team <i class="ci-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================
         NEWSLETTER SECTION
         ============================================ -->
    <section class="container mb-5">
        <div class="newsletter-section">
            <div class="newsletter-content">
                <h3 class="text-white mb-2">Subscribe to Our Newsletter</h3>
                <p class="text-white-50 mb-4">Get the latest IoT news, product launches, and exclusive offers.</p>
                <form class="newsletter-form">
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Enter your email..." required>
                        <button class="btn btn-primary" type="submit">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

<!-- ============================================
     CUSTOM CSS & JS
     ============================================ -->
<style>
/* Hero Showcase Section */
.hero-showcase {
    background: linear-gradient(135deg, #f8f9fa 0%, #e8f5e9 100%);
    border-radius: 0;
    overflow: hidden;
}

.hero-products-section,
.hero-articles-section {
    min-height: 500px;
    display: flex;
    align-items: center;
}

.hero-products-section {
    background: linear-gradient(135deg, #ffffff 0%, #f5f5f5 100%);
}

.hero-articles-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e8f5e9 100%);
}

.hero-content-wrapper {
    width: 100%;
    height: 100%;
}

.hero-product-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 3rem 2rem;
    height: 100%;
    gap: 2rem;
}

.hero-product-image {
    flex: 1;
    text-align: center;
}

.hero-product-image img {
    max-width: 100%;
    max-height: 400px;
    object-fit: contain;
}

.hero-product-info {
    flex: 1;
}

.hero-label {
    color: #00CD66;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 0.5rem;
}

.hero-title {
    font-size: 2rem;
    font-weight: 700;
    color: #008B45;
    margin-bottom: 1rem;
    line-height: 1.3;
}

.hero-price {
    font-size: 1.5rem;
    font-weight: 600;
    color: #3CB371;
    margin-bottom: 1.5rem;
}

.hero-article-item {
    position: relative;
    height: 100%;
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: flex-end;
    min-height: 500px;
    padding: 3rem 2rem;
    border-radius: 0;
}

.hero-article-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to top, rgba(0, 139, 69, 0.9) 0%, rgba(0, 139, 69, 0.5) 50%, transparent 100%);
    z-index: 1;
}

.hero-article-info {
    position: relative;
    z-index: 2;
    color: white;
    width: 100%;
}

.hero-article-meta {
    display: flex;
    gap: 1rem;
    margin: 1rem 0;
}

.views-badge {
    background: rgba(0, 255, 127, 0.2);
    color: #00FF7F;
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
}

.hero-pagination {
    position: absolute;
    bottom: 1rem;
    left: 50%;
    transform: translateX(-50%);
    z-index: 10;
}

/* Navigation Sections */
.section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #008B45;
    border-bottom: 3px solid #00CD66;
    padding-bottom: 0.5rem;
    display: inline-block;
}

.nav-tabs-custom {
    border-bottom: 2px solid #e0e0e0;
}

.nav-tabs-custom .nav-link {
    color: #696969;
    border: none;
    border-bottom: 3px solid transparent;
    padding: 1rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.nav-tabs-custom .nav-link:hover,
.nav-tabs-custom .nav-link.active {
    color: #008B45;
    border-bottom-color: #00CD66;
    background: rgba(0, 205, 102, 0.05);
}

/* Topics Grid */
.topics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 2rem;
}

.topic-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-decoration: none;
    padding: 1.5rem;
    border-radius: 12px;
    border: 2px solid #f0f0f0;
    transition: all 0.3s ease;
    background: white;
}

.topic-card:hover {
    border-color: #00CD66;
    box-shadow: 0 8px 20px rgba(0, 139, 69, 0.15);
    transform: translateY(-5px);
}

.topic-icon {
    width: 60px;
    height: 60px;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.topic-icon img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.topic-name {
    text-align: center;
    font-weight: 600;
    color: #008B45;
    font-size: 0.9rem;
}

/* Categories Carousel */
.categories-carousel {
    position: relative;
}

.category-slide {
    width: 180px !important;
}

.category-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-decoration: none;
    padding: 1.5rem;
    background: white;
    border: 2px solid #f0f0f0;
    border-radius: 12px;
    transition: all 0.3s ease;
    height: 100%;
}

.category-card:hover {
    border-color: #00CD66;
    box-shadow: 0 12px 30px rgba(0, 139, 69, 0.2);
    transform: translateY(-8px);
}

.category-image {
    width: 80px;
    height: 80px;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.category-image img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.category-name {
    text-align: center;
    font-weight: 600;
    color: #008B45;
    font-size: 0.95rem;
}

/* Manufacturers Grid */
.manufacturers-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 2rem;
}

.manufacturer-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    background: white;
    border: 2px solid #f0f0f0;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.3s ease;
    min-height: 140px;
}

.manufacturer-item:hover {
    border-color: #3CB371;
    box-shadow: 0 10px 25px rgba(60, 179, 113, 0.15);
    transform: scale(1.05);
}

.manufacturer-logo {
    width: 80px;
    height: 60px;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.manufacturer-logo img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.manufacturer-name {
    text-align: center;
    font-weight: 600;
    color: #008B45;
    font-size: 0.85rem;
    margin: 0;
}

/* Feature Cards */
.feature-card {
    background: linear-gradient(135deg, rgba(0, 139, 69, 0.05) 0%, rgba(0, 205, 102, 0.05) 100%);
    border: 2px solid #e8f5e9;
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
}

.feature-card:hover {
    border-color: #00CD66;
    box-shadow: 0 10px 30px rgba(0, 139, 69, 0.15);
    transform: translateY(-5px);
}

.feature-icon {
    font-size: 2.5rem;
    color: #00CD66;
    margin-bottom: 1rem;
}

.feature-card h4 {
    color: #008B45;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.feature-card p {
    color: #696969;
    font-size: 0.9rem;
    margin: 0;
}

/* Partnership Cards */
.partnership-card {
    background: white;
    border: 2px solid #f0f0f0;
    border-radius: 12px;
    padding: 3rem 2rem;
    transition: all 0.3s ease;
}

.partnership-card:hover {
    border-color: #00CD66;
    box-shadow: 0 15px 40px rgba(0, 139, 69, 0.2);
    transform: translateY(-5px);
}

.seller-card {
    background: linear-gradient(135deg, rgba(0, 139, 69, 0.05) 0%, rgba(0, 205, 102, 0.02) 100%);
}

.shipper-card {
    background: linear-gradient(135deg, rgba(30, 144, 255, 0.05) 0%, rgba(70, 130, 180, 0.02) 100%);
}

.partnership-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.partnership-header i {
    font-size: 2rem;
    color: #008B45;
}

.shipper-card .partnership-header i {
    color: #1E90FF;
}

.partnership-header h3 {
    margin: 0;
    color: #008B45;
    font-weight: 700;
}

.shipper-card .partnership-header h3 {
    color: #1E90FF;
}

.partnership-description {
    color: #696969;
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.partnership-benefits {
    list-style: none;
    padding: 0;
    margin-bottom: 2rem;
}

.partnership-benefits li {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    margin-bottom: 0.8rem;
    color: #696969;
}

.partnership-benefits i {
    color: #00CD66;
    font-weight: bold;
}

/* Newsletter Section */
.newsletter-section {
    background: linear-gradient(135deg, #008B45 0%, #3CB371 50%, #00CD66 100%);
    border-radius: 12px;
    padding: 3rem 2rem;
    text-align: center;
    box-shadow: 0 10px 40px rgba(0, 139, 69, 0.3);
}

.newsletter-form {
    max-width: 500px;
    margin: 0 auto;
}

.newsletter-form .input-group {
    display: flex;
    gap: 0;
}

.newsletter-form .form-control {
    border-radius: 25px 0 0 25px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    background: rgba(255, 255, 255, 0.9);
    padding: 0.75rem 1.5rem;
    font-size: 0.9rem;
}

.newsletter-form .form-control:focus {
    border-color: white;
    box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.2);
}

.newsletter-form .btn {
    border-radius: 0 25px 25px 0;
    border: 2px solid rgba(255, 255, 255, 0.3);
    background: rgba(255, 255, 255, 0.2);
    color: white;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
}

.newsletter-form .btn:hover {
    background: white;
    color: #008B45;
    border-color: white;
}

/* Category Section */
.category-section {
    animation: fadeInUp 0.5s ease-in-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 992px) {
    .hero-showcase .row {
        flex-direction: column;
    }

    .hero-products-section,
    .hero-articles-section {
        min-height: 400px;
    }

    .hero-product-item {
        padding: 2rem;
        flex-direction: column;
        text-align: center;
    }

    .hero-title {
        font-size: 1.5rem;
    }

    .topics-grid {
        grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
        gap: 1rem;
    }

    .manufacturers-grid {
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 1rem;
    }
}

@media (max-width: 768px) {
    .hero-products-section,
    .hero-articles-section {
        min-height: 350px;
    }

    .hero-product-info {
        flex: 0 0 100%;
    }

    .hero-title {
        font-size: 1.25rem;
    }

    .category-slide {
        width: 140px !important;
    }

    .partnership-card {
        padding: 2rem 1.5rem;
    }
}
</style>

@endsection
