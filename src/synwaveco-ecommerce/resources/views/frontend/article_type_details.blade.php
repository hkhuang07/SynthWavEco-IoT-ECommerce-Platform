@extends('layouts.frontend')
@section('title', $title ?? 'Article Type Details')

@section('content')
<div class="container py-4 py-lg-5">
    
    {{-- Breadcrumb: Home > Article Type Name > Article Title --}}
    <nav class="mb-4" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
            <li class="breadcrumb-item">
                {{-- Route này trỏ về danh sách các bài viết thuộc Type này --}}
                <a href="{{ route('frontend.articles.types', ['article_type_slug' => $article_types->slug]) }}">
                    {{ $article_types->name }}
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $article->title }}</li>
        </ol>
    </nav>

    <div class="row">
        {{-- Section: Image --}}
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

        {{-- Section: Quick Info --}}
        <div class="col-lg-6">
            <span class="badge bg-soft-info text-info mb-2">{{ $article_types->name }}</span>
            <h1 class="h3 mb-3 fw-bold text-dark">{{ $article->title }}</h1>
            
            <div class="d-flex align-items-center mb-3">
                <div class="me-3">
                    <i class="fas fa-eye text-muted me-1"></i>
                    <span class="fw-bold">{{ number_format($article->views) }}</span> Views
                </div>
                <div class="text-muted small border-start ps-3">
                    <i class="fas fa-calendar-alt me-1"></i> {{ $article->created_at->format('d/m/Y') }}
                </div>
            </div>

            <h6 class="fw-bold text-uppercase small text-muted mb-2">Summary:</h6>
            <p class="text-muted mb-4 lead" style="font-size: 1rem; line-height: 1.6;">{{ $article->summary }}</p>

            <div class="p-3 bg-light rounded border-start border-4 border-info">
                <div class="d-flex align-items-center">
                    <i class="fas fa-user-edit text-info me-3 fa-lg"></i>
                    <div>
                        <div class="small text-muted">Written by</div>
                        <strong>{{ $article->User->name ?? 'Administrator' }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <hr class="my-5">

    {{-- Section: Full Content (Render HTML) --}}
    <div class="row">
        <div class="col-12 article-content-body">
            <h4 class="mb-4 fw-bold border-bottom pb-2">Full Content</h4>
            <div class="text-dark fs-5" style="line-height: 1.8;">
                {!! $article->content !!}
            </div>
        </div>
    </div>

    {{-- Section: Comments --}}
    <section class="mt-5 pt-4">
        <h4 class="mb-4 fw-bold"><i class="fas fa-comments me-2 text-primary"></i>Comments ({{ $article->Comments->count() }})</h4>
        @forelse($article->Comments as $comment)
            <div class="d-flex mb-4 p-3 bg-white shadow-sm rounded border-light">
                <div class="flex-shrink-0">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        {{ strtoupper(substr($comment->User->name ?? 'G', 0, 1)) }}
                    </div>
                </div>
                <div class="ms-3 w-100">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-bold text-dark">{{ $comment->User->name ?? 'Guest' }}</span>
                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="text-muted small">{{ $comment->content }}</div>
                </div>
            </div>
        @empty
            <div class="alert alert-light border text-center py-4">
                <p class="text-muted mb-0">No comments yet. Be the first to share your thoughts!</p>
            </div>
        @endforelse
    </section>

    {{-- Section: Related Articles (Same Type) --}}
    @if($relatedArticles->count() > 0)
    <div class="related-articles-section mt-5 pt-5 border-top">
        <h4 class="mb-4 fw-bold">More in <span class="text-info">{{ $article_types->name }}</span></h4>
        <div class="row g-4">
            @foreach($relatedArticles as $related)
            <div class="col-6 col-md-3">
                <div class="card h-100 border-0 shadow-sm hover-    top transition">
                    <a href="{{ route('frontend.articles.article_type_details', ['article_type_slug' => $article_types->slug, 'title_slug' => $related->slug]) }}">
                        @if($related->image)
                            <img src="{{ asset('storage/app/private/'. $related->image) }}" 
                                 class="card-img-top" alt="{{ $related->title }}" style="height: 150px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                <i class="fas fa-file-alt text-muted fa-2x"></i>
                            </div>
                        @endif
                    </a>
                    <div class="card-body p-3">
                        <h6 class="card-title mb-2" style="font-size: 0.9rem;">
                            <a href="{{ route('frontend.articles.article_type_details', ['article_type_slug' => $article_types->slug, 'title_slug' => $related->slug]) }}" 
                               class="text-decoration-none text-dark fw-bold">
                                {{ Str::limit($related->title, 45) }}
                            </a>
                        </h6>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="small text-muted"><i class="fas fa-eye me-1"></i> {{ $related->views }}</span>
                            <span class="small text-muted">{{ $related->created_at->format('M d') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<style>
    .hover-top:hover { transform: translateY(-5px); transition: 0.3s; }
    .bg-soft-info { background-color: rgba(13, 202, 240, 0.1); }
    .article-content-body img { max-width: 100%; height: auto; border-radius: 8px; margin: 15px 0; }
</style>
@endsection