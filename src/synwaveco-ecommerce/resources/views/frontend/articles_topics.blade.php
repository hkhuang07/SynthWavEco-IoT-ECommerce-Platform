@extends('layouts.frontend')
{{-- Sử dụng biến $title được truyền từ HomeController --}}
@section('title', $title ?? 'Articles') 

@section('content')
<div class="container py-4">
    <div class="row">
        
        {{-- Sidebar: Lọc theo Topics (Chủ đề) --}}
        <div class="col-lg-3">
            <h5 class="mb-3"><i class="fas fa-tags me-2"></i>Topics</h5>
            
            {{-- Button Group/Pills cho Topics --}}
            <div class="d-flex flex-wrap gap-2 mb-4">
                
                {{-- Button hiển thị tất cả bài viết (All Articles) --}}
                <a href="{{ route('frontend.articles_topics') }}" 
                   class="btn btn-sm {{ !isset($topic) ? 'btn-primary shadow-sm' : 'btn-outline-secondary' }}">
                    All Articles
                </a>

                {{-- Duyệt danh sách tất cả các Topic --}}
                @foreach($topics as $t)
                    @php
                        $isActive = (isset($topic) && $topic->id == $t->id);
                    @endphp
                    
                    <a href="{{ route('frontend.articles.topics', ['topicname_slug' => $t->slug]) }}" 
                       class="btn btn-sm {{ $isActive ? 'btn-primary shadow-sm' : 'btn-outline-secondary' }}">
                        {{ $t->name }}
                    </a>
                @endforeach
            </div>
        </div>
        
        {{-- Article Grid: Danh sách bài viết --}}
        <div class="col-lg-9">
            <h2 class="h4 mb-4 fw-bold text-dark">{{ $title }}</h2>
            
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @forelse($articles as $article)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 transition-hover">
                        {{-- Hình ảnh bài viết trỏ đến trang chi tiết --}}
                        <a href="{{ route('frontend.articles.article_topic_details', ['topicname_slug' => $article->Topic->slug, 'title_slug' => $article->slug]) }}">
                            @if($article->image)
                                <img src="{{ asset('storage/app/private/'. $article->image) }}" 
                                     class="card-img-top" alt="{{ $article->title }}"
                                     style="height: 180px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                                    <i class="fas fa-newspaper text-muted fa-3x"></i>
                                </div>
                            @endif
                        </a>

                        <div class="card-body p-3">
                            {{-- Tag loại bài viết nhỏ bên trên tiêu đề --}}
                            <div class="mb-2">
                                <span class="badge bg-soft-primary text-primary" style="font-size: 0.7rem;">
                                    {{ $article->ArticleType->name ?? 'News' }}
                                </span>
                            </div>

                            <h5 class="card-title h6 fw-bold mb-2">
                                <a href="{{ route('frontend.articles.article_topic_details', ['topicname_slug' => $article->Topic->slug, 'title_slug' => $article->slug]) }}" 
                                   class="text-decoration-none text-dark">
                                    {{ Str::limit($article->title, 55) }}
                                </a>
                            </h5>

                            <p class="card-text text-muted small mb-3">
                                {{ Str::limit($article->summary, 80) }}
                            </p>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted">
                                    <i class="fas fa-eye me-1"></i> {{ number_format($article->views) }}
                                </span>
                                <a href="{{ route('frontend.articles.article_topic_details', ['topicname_slug' => $article->Topic->slug, 'title_slug' => $article->slug]) }}" 
                                   class="btn btn-link btn-sm p-0 text-primary text-decoration-none fw-bold">
                                    Read More <i class="fas fa-arrow-right small ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <div class="text-muted">
                        <i class="fas fa-folder-open fa-3x mb-3"></i>
                        <p>No articles found in this topic.</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
        
    </div>
</div>

<style>
    .transition-hover { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .transition-hover:hover { transform: translateY(-5px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; }
    .bg-soft-primary { background-color: rgba(13, 110, 253, 0.1); }
</style>
@endsection