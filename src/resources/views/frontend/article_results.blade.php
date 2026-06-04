@extends('layouts.frontend')
@section('title', $title ?? 'Search Results - Articles')

@section('content')
<div class="container py-4 py-lg-5">
    
    {{-- Breadcrumb: Home > Search > [Keyword] --}}
    <nav class="mb-4" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Article Search: "{{ $keyword }}"</li>
        </ol>
    </nav>

    @if(isset($article))
    {{-- VÙNG 1: HIỂN THỊ CHI TIẾT BÀI VIẾT KHỚP NHẤT (BEST MATCH) --}}
    <div class="alert alert-info border-0 shadow-sm mb-4">
        <i class="fas fa-lightbulb me-2 text-warning"></i> We found a featured match for your technical query.
    </div>

    <div class="row">
        {{-- Article Image --}}
        <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="card p-3 shadow-sm border-0 bg-white">
                @if($article->image)
                    <img src="{{ asset('storage/'.$article->image) }}" 
                         alt="{{ $article->title }}" 
                         class="img-fluid rounded shadow-sm" 
                         style="max-height: 450px; width: 100%; object-fit: cover;">
                @else
                    <div class="text-center py-5 bg-light rounded">
                        <i class="fas fa-newspaper fa-4x text-muted opacity-25"></i>
                    </div>
                @endif
            </div>
        </div>

        {{-- Article Detailed Info --}}
        <div class="col-lg-6">
            <div class="d-flex align-items-center gap-2 mb-3">
                <span class="badge bg-soft-primary text-primary px-3 rounded-pill">{{ $article->ArticleType->name ?? 'News' }}</span>
                <span class="text-muted small border-start ps-2">
                    <i class="fas fa-calendar-alt me-1"></i> {{ $article->created_at->format('M d, Y') }}
                </span>
            </div>

            <h1 class="h3 mb-3 fw-bold text-dark">{{ $article->title }}</h1>
            
            <div class="d-flex align-items-center mb-4">
                <div class="me-4 text-primary">
                    <i class="fas fa-eye me-1"></i>
                    <span class="fw-bold">{{ number_format($article->views) }}</span> Views
                </div>
                <div class="text-muted small">
                    <i class="fas fa-tags me-1"></i> Topic: <strong>{{ $article->Topic->name ?? 'General' }}</strong>
                </div>
            </div>

            <p class="text-muted mb-4 lead" style="font-size: 1rem; line-height: 1.7;">{{ $article->summary }}</p>

            {{-- Metadata - Author & Source --}}
            <h6 class="mb-2 fw-bold text-uppercase small text-muted">Publication Info:</h6>
            <ul class="list-unstyled small text-muted border-start border-4 border-success ps-3 mb-4">
                <li><i class="fas fa-user-edit me-2"></i>Author: <strong>{{ $article->User->name ?? 'SynWavEco Admin' }}</strong></li>
                <li><i class="fas fa-microchip me-2"></i>Technology: {{ $article->Topic->name ?? 'IoT Systems' }}</li>
                <li><i class="fas fa-check-double me-2"></i>Verification: Peer reviewed by GreenTech</li>
            </ul>

            <div class="mt-4">
                <a href="{{ route('frontend.articles.article_topic_details', ['topicname_slug' => $article->Topic->slug, 'title_slug' => $article->slug]) }}" 
                   class="btn btn-lg btn-primary rounded-pill px-5 shadow">
                    <i class="fas fa-book-open me-2"></i> Read Full Article
                </a>
            </div>
        </div>
    </div>
    
    <hr class="my-5 opacity-10">

    {{-- VÙNG 2: CÁC BÀI VIẾT KHÁC CŨNG LIÊN QUAN ĐẾN TỪ KHÓA --}}
    @if($relatedArticles->count() > 0)
    <div class="related-section mt-5">
        <h4 class="mb-4 fw-bold"><i class="fas fa-stream me-2 text-primary"></i>Other Relevant Insights</h4>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($relatedArticles as $related)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm hover-top transition">
                    <a href="{{ route('frontend.articles.article_topic_details', ['topicname_slug' => $related->Topic->slug, 'title_slug' => $related->slug]) }}">
                        <div class="ratio" style="--cz-aspect-ratio: 60%">
                            <img src="{{ asset('storage/'. ($related->image ?? 'default.png')) }}" 
                                 class="card-img-top" alt="{{ $related->title }}" style="object-fit: cover;">
                        </div>
                    </a>
                    <div class="card-body p-3">
                        <div class="mb-2">
                            <span class="badge bg-light text-success xsmall">{{ $related->ArticleType->name ?? 'Tech' }}</span>
                        </div>
                        <h6 class="card-title mb-2">
                            <a href="{{ route('frontend.articles.article_topic_details', ['topicname_slug' => $related->Topic->slug, 'title_slug' => $related->slug]) }}" 
                               class="text-decoration-none text-dark fw-bold">
                                {{ Str::limit($related->title, 55) }}
                            </a>
                        </h6>
                        <p class="text-muted xsmall mb-0">{{ Str::limit($related->summary, 80) }}</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 d-flex justify-content-between align-items-center pb-3">
                        <small class="text-muted"><i class="fas fa-eye me-1"></i>{{ $related->views }}</small>
                        <small class="text-muted">{{ $related->created_at->format('M d') }}</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @else
    {{-- TRƯỜNG HỢP KHÔNG TÌM THẤY BÀI VIẾT NÀO --}}
    <div class="text-center py-5">
        <div class="mb-4">
            <i class="fas fa-search-minus fa-4x text-muted opacity-25"></i>
        </div>
        <h2 class="h4 text-muted">No knowledge base results for "{{ $keyword }}"</h2>
        <p class="text-muted mb-4">Try checking your technical terms or browse our global categories.</p>
        <div class="d-flex justify-content-center gap-2">
            <a href="{{ route('frontend.articles') }}" class="btn btn-outline-primary rounded-pill">View All Articles</a>
            <a href="{{ route('frontend.home') }}" class="btn btn-primary rounded-pill">Return Home</a>
        </div>
    </div>
    @endif
</div>

<style>
    .hover-top:hover { transform: translateY(-5px); transition: 0.3s; }
    .transition { transition: all 0.3s ease; }
    .xsmall { font-size: 0.75rem; }
    .bg-soft-primary { background-color: rgba(0, 139, 69, 0.1); }
</style>
@endsection