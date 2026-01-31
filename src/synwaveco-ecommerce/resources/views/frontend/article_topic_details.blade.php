@extends('layouts.frontend')
@section('title', $title ?? 'Article Topic Details')

@section('content')
<div class="container py-4 py-lg-5">
    {{-- Breadcrumb --}}
    <nav class="mb-4" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
            <li class="breadcrumb-item">
                <a href="{{ route('frontend.articles.topics', ['topicname_slug' => $topic->slug]) }}">
                    {{ $topic->name }}
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $article->title }}</li>
        </ol>
    </nav>

    <div class="row">
        {{-- Ảnh bìa bài viết --}}
        <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="card p-3 shadow-sm border-0">
                @if($article->image)
                    <img src="{{ asset('storage/app/private/'.$article->image) }}" 
                         alt="{{ $article->title }}" 
                         class="img-fluid rounded shadow-sm" 
                         style="max-height: 500px; width: 100%; object-fit: cover;">
                @else
                    <div class="text-center py-5 bg-light rounded text-muted">
                        <i class="fas fa-image fa-3x mb-2"></i><br>No Image Available
                    </div>
                @endif
            </div>
        </div>

        {{-- Thông tin tóm tắt --}}
        <div class="col-lg-6">
            <span class="badge bg-soft-primary text-primary mb-2">{{ $article->ArticleType->name ?? 'News' }}</span>
            <h1 class="h3 mb-3 fw-bold text-dark">{{ $article->title }}</h1>
            
            <div class="d-flex align-items-center mb-3">
                {{-- Migration dùng 'views' (số nhiều) --}}
                <div class="me-3">
                    <i class="fas fa-eye text-muted me-1"></i>
                    <span class="fw-bold">{{ number_format($article->views) }}</span> Views
                </div>
                <div class="text-muted small">
                    <i class="fas fa-calendar-alt me-1"></i> {{ $article->created_at->format('d/m/Y') }}
                </div>
            </div>

            <h6 class="fw-bold"><i class="fas fa-quote-left text-primary me-2"></i>Summary:</h6>
            <p class="text-muted mb-4 lead" style="font-size: 0.95rem;">{{ $article->summary }}</p>

            <div class="p-3 bg-light rounded border-start border-4 border-primary">
                <i class="fas fa-user-edit me-2"></i> Posted by: <strong>{{ $article->User->name ?? 'N/A' }}</strong>
            </div>
        </div>
    </div>
    
    <hr class="my-5">

    {{-- Nội dung chi tiết - Render HTML từ CKEditor --}}
    <div class="row">
        <div class="col-12 article-body">
            <h4 class="mb-4 fw-bold">Full Content</h4>
            <div class="text-dark line-height-lg">
                {!! $article->content !!}
            </div>
        </div>
    </div>

    {{-- Phần bình luận --}}
    <section class="mt-5">
        <h4 class="mb-4"><i class="fas fa-comments me-2"></i>Comments ({{ $article->Comments->count() }})</h4>
        @forelse($article->Comments as $comment)
            <div class="d-flex mb-3 p-3 bg-white shadow-sm rounded border">
                <div class="flex-shrink-0">
                    <i class="fas fa-user-circle fa-2x text-secondary"></i>
                </div>
                <div class="ms-3">
                    <div class="fw-bold small">{{ $comment->User->name ?? 'Guest' }}</div>
                    <div class="text-muted">{{ $comment->content }}</div>
                </div>
            </div>
        @empty
            <p class="text-muted italic small">No comments yet. Be the first to comment!</p>
        @endforelse
    </section>

    {{-- Bài viết liên quan --}}
    @if($relatedArticles->count() > 0)
    <div class="related-articles-section mt-5 pt-4 border-top">
        <h4 class="mb-4 fw-bold">Related Articles</h4>
        <div class="row g-4">
            @foreach($relatedArticles as $related)
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm hover-top">
                    <a href="{{ route('frontend.articles.article_topic_details', ['topicname_slug' => $related->Topic->slug, 'title_slug' => $related->slug]) }}">
                        <img src="{{ asset('storage/app/private/'. ($related->image ?? 'default.png')) }}" 
                             class="card-img-top" alt="{{ $related->title }}" style="height: 160px; object-fit: cover;">
                    </a>
                    <div class="card-body">
                        <h6 class="card-title mb-2">
                            <a href="{{ route('frontend.articles.article_topic_details', ['topicname_slug' => $related->Topic->slug, 'title_slug' => $related->slug]) }}" 
                               class="text-decoration-none text-dark">
                                {{ Str::limit($related->title, 50) }}
                            </a>
                        </h6>
                        <div class="small text-muted"><i class="fas fa-eye me-1"></i> {{ $related->views }} views</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection