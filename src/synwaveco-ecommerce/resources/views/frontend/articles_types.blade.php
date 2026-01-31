@extends('layouts.frontend')
{{-- Sử dụng biến $title được truyền từ HomeController --}}
@section('title', $title ?? 'Article Types') 

@section('content')
<div class="container py-4">
    <div class="row">
        
        {{-- Sidebar: Lọc theo Article Types (Loại bài viết) --}}
        <div class="col-lg-3">
            <h5 class="mb-3"><i class="fas fa-layer-group me-2"></i>Article Types</h5>
            
            {{-- Button Group/Pills cho Article Types --}}
            <div class="d-flex flex-wrap gap-2 mb-4">
                
                {{-- Button hiển thị tất cả (All Articles) --}}
                <a href="{{ route('frontend.articles_types') }}" 
                   class="btn btn-sm {{ !isset($article_type) ? 'btn-primary shadow-sm' : 'btn-outline-secondary' }}">
                    All Types
                </a>

                {{-- Duyệt danh sách các Type từ biến $article_types truyền qua Composer hoặc Controller --}}
                @foreach($article_types as $type)
                    @php
                        // Kiểm tra xem Type hiện tại có đang được chọn để active button không
                        $isActive = (isset($article_type) && $article_type->id == $type->id);
                    @endphp
                    
                    <a href="{{ route('frontend.articles.types', ['article_type_slug' => $type->slug]) }}" 
                       class="btn btn-sm {{ $isActive ? 'btn-primary shadow-sm' : 'btn-outline-secondary' }}">
                        {{ $type->name }}
                    </a>
                @endforeach
            </div>
        </div>
        
        {{-- Article Grid: Danh sách bài viết thuộc Type đã chọn --}}
        <div class="col-lg-9">
            <h2 class="h4 mb-4 fw-bold text-dark">{{ $title }}</h2>
            
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @forelse($articles as $article)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 transition-hover">
                        {{-- Link tới trang chi tiết dựa trên Article Type --}}
                        <a href="{{ route('frontend.articles.article_type_details', ['article_type_slug' => $article->ArticleType->slug, 'title_slug' => $article->slug]) }}">
                            @if($article->image)
                                <img src="{{ asset('storage/app/private/'. $article->image) }}" 
                                     class="card-img-top" alt="{{ $article->title }}"
                                     style="height: 180px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                                    <i class="fas fa-file-alt text-muted fa-3x"></i>
                                </div>
                            @endif
                        </a>

                        <div class="card-body p-3">
                            {{-- Hiển thị Topic nhỏ bên dưới ảnh --}}
                            <div class="mb-2">
                                <span class="text-primary small fw-bold">
                                    <i class="fas fa-tag me-1"></i>{{ $article->Topic->name ?? 'General' }}
                                </span>
                            </div>

                            <h5 class="card-title h6 fw-bold mb-2">
                                <a href="{{ route('frontend.articles.article_type_details', ['article_type_slug' => $article->ArticleType->slug, 'title_slug' => $article->slug]) }}" 
                                   class="text-decoration-none text-dark">
                                    {{ Str::limit($article->title, 55) }}
                                </a>
                            </h5>

                            <p class="card-text text-muted small mb-3">
                                {{ Str::limit($article->summary, 85) }}
                            </p>
                        </div>

                        <div class="card-footer bg-transparent border-top-0 pb-3">
                            <div class="d-flex justify-content-between align-items-center text-muted small">
                                <span><i class="fas fa-eye me-1"></i> {{ number_format($article->views) }}</span>
                                <span>{{ $article->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <div class="text-muted">
                        <i class="fas fa-layer-group fa-3x mb-3"></i>
                        <p>No articles found for this type.</p>
                        <a href="{{ route('frontend.articles_types') }}" class="btn btn-sm btn-outline-primary">Back to All Articles</a>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
        
    </div>
</div>

<style>
    .transition-hover { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .transition-hover:hover { transform: translateY(-5px); box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.1)!important; }
</style>
@endsection