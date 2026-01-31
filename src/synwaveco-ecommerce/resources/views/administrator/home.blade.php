@extends('layouts.app')

@section('title', 'Control Center - SynWavEco')

@section('styles')
    <link rel="stylesheet" href="{{ asset('public/css/dashboard.css') }}">
@endsection

@section('content')
<div class="dashboard-container">
    
    <div class="welcome-section mb-4 banner-gradient-primary text-white">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="welcome-content">
                    <h1 class="welcome-title"><i class="fas fa-microchip me-2"></i>SynWavEco Control Center</h1>
                    <p class="welcome-subtitle">Comprehensive management of GreenTech IoT Ecosystem</p>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="admin-info">
                    <div class="admin-avatar"><i class="fas fa-user-circle fa-3x"></i></div>
                    <div class="admin-details">
                        <h6 class="admin-name mb-0">{{ Auth::user()->name }}</h6>
                        <small class="text-green-spring">System Administrator</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-5">
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-gt-primary" style="background: var(--primary-super-dark)"><i class="fas fa-user-tag"></i></div>
                <h3 class="stat-number">{{ \App\Models\Role::count() }}</h3>
                <p class="small text-muted mb-0">Total Roles</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-gt-primary" style="background: var(--primary-super-dark)"><i class="fas fa-users"></i></div>
                <h3 class="stat-number">{{ \App\Models\User::count() }}</h3>
                <p class="small text-muted mb-0">Total Users</p>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: var(--accent-dark)"><i class="fas fa-shipping-fast"></i></div>
                <h3 class="stat-number">{{ \App\Models\OrderStatus::count() }}</h3>
                <p class="small text-muted mb-0">Order Statuses</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: var(--accent-dark)"><i class="fas fa-shopping-cart"></i></div>
                <h3 class="stat-number">{{ \App\Models\Order::count() }}</h3>
                <p class="small text-muted mb-0">Total Orders</p>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: var(--accent-medium)"><i class="fas fa-list"></i></div>
                <h3 class="stat-number">{{ \App\Models\Category::count() }}</h3>
                <p class="small text-muted mb-0">Categories</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: var(--accent-medium)"><i class="fas fa-industry"></i></div>
                <h3 class="stat-number">{{ \App\Models\Manufacturer::count() }}</h3>
                <p class="small text-muted mb-0">Manufacturers</p>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: var(--accent-medium)"><i class="fas fa-box"></i></div>
                <h3 class="stat-number">{{ \App\Models\Product::count() }}</h3>
                <p class="small text-muted mb-0">Products</p>
            </div>
        </div>
        
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: var(--bg-orangeyellow)"><i class="fas fa-tags"></i></div>
                <h3 class="stat-number">{{ \App\Models\Topic::count() }}</h3>
                <p class="small text-muted mb-0">Topics</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: var(--bg-orangered)"><i class="fas fa-file-alt"></i></div>
                <h3 class="stat-number">{{ \App\Models\ArticleStatus::count() }}</h3>
                <p class="small text-muted mb-0">Article Statuses</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: var(--bg-orangered)"><i class="fas fa-list"></i></div>
                <h3 class="stat-number">{{ \App\Models\ArticleType::count() }}</h3>
                <p class="small text-muted mb-0">Article Types</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: var(--bg-orangered)"><i class="fas fa-file-alt"></i></div>
                <h3 class="stat-number">{{ \App\Models\Article::count() }}</h3>
                <p class="small text-muted mb-0">Articles</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: var(--bg-darker)"><i class="fas fa-microchip"></i></div>
                <h3 class="stat-number">{{ \App\Models\IoTDevice::count() }}</h3>
                <p class="small text-muted mb-0">IoT Devices</p>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        
        <div class="col-lg-6">
            <h4 class="section-title"><i class="fas fa-shopping-basket"></i> Commerce & Logistics</h4>
            <div class="module-card">
                <div class="row g-3">
                    <div class="col-6">
                        <a href="{{ route('administrator.orders') }}" class="btn btn-gt-primary w-100 py-3 shadow-sm">
                            <i class="fas fa-receipt mb-2 d-block fs-4"></i> Orders
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('administrator.order_statuses') }}" class="btn btn-gt-secondary w-100 py-3">
                            <i class="fas fa-truck-loading mb-2 d-block fs-4"></i> Order Status
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('administrator.products') }}" class="btn btn-gt-outline w-100"><i class="fas fa-cube me-2"></i>Products</a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('administrator.categories') }}" class="btn btn-gt-outline w-100"><i class="fas fa-list me-2"></i>Categories</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <h4 class="section-title"><i class="fas fa-edit"></i> Knowledge Hub (CMS)</h4>
            <div class="module-card">
                <div class="row g-3">
                    <div class="col-6">
                        <a href="{{ route('administrator.articles') }}" class="btn btn-gt-primary w-100 py-3 shadow-sm">
                            <i class="fas fa-newspaper mb-2 d-block fs-4"></i> Articles
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('administrator.topics') }}" class="btn btn-gt-secondary w-100 py-3">
                            <i class="fas fa-tags mb-2 d-block fs-4"></i> Topics
                        </a>
                    </div>
                    <div class="col-4"><a href="{{ route('administrator.article_types') }}" class="btn btn-gt-offline w-100 btn-sm">Types</a></div>
                    <div class="col-4"><a href="{{ route('administrator.article_statuses') }}" class="btn btn-gt-offline w-100 btn-sm">Statuses</a></div>
                    <div class="col-4"><a href="{{ route('administrator.comments') }}" class="btn btn-gt-offline w-100 btn-sm">Comments</a></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <h4 class="section-title"><i class="fas fa-network-wired"></i> IoT Infrastructure</h4>
            <div class="module-card">
                <div class="row g-3">
                    <div class="col-12">
                        <a href="{{ route('administrator.iot_devices') }}" class="btn btn-gt-import w-100 py-3 text-start px-4">
                            <i class="fas fa-microchip me-3"></i> IoT Device Monitor & Config
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <h4 class="section-title"><i class="fas fa-user-lock"></i> System & Security</h4>
            <div class="module-card">
                <div class="row g-3">
                    <div class="col-6">
                        <a href="{{ route('administrator.users') }}" class="btn btn-gt-outline w-100"><i class="fas fa-users me-2"></i>User Accounts</a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('administrator.roles') }}" class="btn btn-gt-outline w-100"><i class="fas fa-user-shield me-2"></i>Permissions</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="activity-card">
                <div class="p-3 border-bottom bg-light fw-bold small"><i class="fas fa-shopping-bag me-2"></i>LATEST ORDERS</div>
                <div class="activity-list">
                    @foreach(\App\Models\Order::with('user')->latest()->limit(4)->get() as $order)
                    <div class="activity-item d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold">#{{ $order->id }} - {{ $order->user->name }}</div>
                            <small class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        <span class="badge bg-gt-primary">New Order</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="activity-card">
                <div class="p-3 border-bottom bg-light fw-bold small"><i class="fas fa-newspaper me-2"></i>LATEST ARTICLES</div>
                <div class="activity-list">
                    @foreach(\App\Models\Article::with('user')->latest()->limit(4)->get() as $article)
                    <div class="activity-item d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold">{{ Str::limit($article->title, 30) }}</div>
                            <small class="text-muted">by {{ $article->user->name ?? 'Unknown Author' }} on {{ $article->created_at->format('d/m/Y') }}</small>
                        </div>
                        <span class="badge bg-gt-secondary">New Article</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="activity-card">
                <div class="p-3 border-bottom bg-light fw-bold small"><i class="fas fa-history me-2"></i>SYSTEM STATUS</div>
                <div class="p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="spinner-grow spinner-grow-sm text-success me-3"></div>
                        <span>Database Connection: <strong class="text-success">Stable</strong></span>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-success" style="width: 85%">Storage 85%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection