@extends('layouts.app')

@section('title', 'Dashboard - Administrator')

@section('content')
<div class="dashboard-container">
    <!-- Welcome Section -->
    <div class="welcome-section mb-4 banner-gradient-primary text-white">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="welcome-content">
                    <h1 class="welcome-title">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        Welcome to GreenTech Admin Dashboard
                    </h1>
                    <p class="welcome-subtitle">
                        Manage your IoT devices, products, orders, and customers efficiently
                    </p>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="admin-info">
                    <div class="admin-avatar">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="admin-details">
                        <h6 class="admin-name">{{ Auth::user()->name }}</h6>
                        <p class="admin-role">Administrator</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions mb-4">
        <h4 class="section-title">
            <i class="fas fa-bolt me-2"></i>Quick Actions
        </h4>
        <div class="row g-3">
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('administrator.products') }}" class="quick-action-card product-card">
                    <div class="action-icon bg-primary-light">
                        <i class="fas fa-box"></i>
                    </div>
                    <h6>Manage Products</h6>
                    <p>Add, edit, and manage IoT devices and components</p>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('administrator.orders') }}" class="quick-action-card order-card">
                    <div class="action-icon bg-success-light">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h6>View Orders</h6>
                    <p>Track and manage customer orders</p>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('administrator.users') }}" class="quick-action-card user-card">
                    <div class="action-icon bg-info-light">
                        <i class="fas fa-users"></i>
                    </div>
                    <h6>User Management</h6>
                    <p>Manage customer accounts and permissions</p>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('administrator.iot_devices') }}" class="quick-action-card iot-card">
                    <div class="action-icon bg-secondary-light">
                        <i class="fas fa-microchip"></i>
                    </div>
                    <h6>IoT Devices</h6>
                    <p>Monitor and configure IoT devices</p>
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="statistics-section mb-4">
        <h4 class="section-title">
            <i class="fas fa-chart-line me-2"></i>System Statistics
        </h4>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon bg-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-trend positive">
                            <i class="fas fa-arrow-up"></i> +12%
                        </div>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ \App\Models\User::count() }}</h3>
                        <p class="stat-label">Total Users</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon bg-success">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="stat-trend positive">
                            <i class="fas fa-arrow-up"></i> +8%
                        </div>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ \App\Models\Product::count() }}</h3>
                        <p class="stat-label">Total Products</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon bg-warning">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="stat-trend positive">
                            <i class="fas fa-arrow-up"></i> +25%
                        </div>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ \App\Models\Order::count() }}</h3>
                        <p class="stat-label">Total Orders</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon bg-info">
                            <i class="fas fa-microchip"></i>
                        </div>
                        <div class="stat-trend neutral">
                            <i class="fas fa-minus"></i> 0%
                        </div>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ \App\Models\IotDevice::count() }}</h3>
                        <p class="stat-label">IoT Devices</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Management Modules -->
    <div class="management-modules mb-4">
        <h4 class="section-title">
            <i class="fas fa-cogs me-2"></i>Management Modules
        </h4>
        <div class="row g-4">
            <!-- User & Permissions -->
            <div class="col-lg-6">
                <div class="module-card">
                    <div class="module-header">
                        <div class="module-icon bg-primary">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <div class="module-title">
                            <h5>User & Permissions</h5>
                            <p>Manage users, roles, and access control</p>
                        </div>
                    </div>
                    <div class="module-actions">
                        <a href="{{ route('administrator.users') }}" class="btn btn-primary btn-sm me-2">
                            <i class="fas fa-users"></i> Users
                        </a>
                        <a href="{{ route('administrator.roles') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-user-shield"></i> Roles
                        </a>
                    </div>
                </div>
            </div>

            <!-- Categories & Manufacturers -->
            <div class="col-lg-6">
                <div class="module-card">
                    <div class="module-header">
                        <div class="module-icon bg-success">
                            <i class="fas fa-sitemap"></i>
                        </div>
                        <div class="module-title">
                            <h5>Categories & Manufacturers</h5>
                            <p>Organize products by categories and brands</p>
                        </div>
                    </div>
                    <div class="module-actions">
                        <a href="{{ route('administrator.categories') }}" class="btn btn-success btn-sm me-2">
                            <i class="fas fa-list"></i> Categories
                        </a>
                        <a href="{{ route('administrator.manufacturers') }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-copyright"></i> Manufacturers
                        </a>
                    </div>
                </div>
            </div>

            <!-- Product Management -->
            <div class="col-lg-6">
                <div class="module-card">
                    <div class="module-header">
                        <div class="module-icon bg-warning">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="module-title">
                            <h5>Product Management</h5>
                            <p>Add, edit, and manage IoT devices inventory</p>
                        </div>
                    </div>
                    <div class="module-actions">
                        <a href="{{ route('administrator.products') }}" class="btn btn-warning btn-sm me-2">
                            <i class="fas fa-cube"></i> All Products
                        </a>
                        <a href="{{ route('administrator.products.add') }}" class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-plus"></i> Add Product
                        </a>
                    </div>
                </div>
            </div>

            <!-- Order Management -->
            <div class="col-lg-6">
                <div class="module-card">
                    <div class="module-header">
                        <div class="module-icon bg-info">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                        <div class="module-title">
                            <h5>Order Management</h5>
                            <p>Track orders, status, and fulfillment</p>
                        </div>
                    </div>
                    <div class="module-actions">
                        <a href="{{ route('administrator.orders') }}" class="btn btn-info btn-sm me-2">
                            <i class="fas fa-shopping-cart"></i> All Orders
                        </a>
                        <a href="{{ route('administrator.order_statuses') }}" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-list-check"></i> Status
                        </a>
                    </div>
                </div>
            </div>

            <!-- IoT Management -->
            <div class="col-lg-6">
                <div class="module-card">
                    <div class="module-header">
                        <div class="module-icon bg-secondary">
                            <i class="fas fa-microchip"></i>
                        </div>
                        <div class="module-title">
                            <h5>IoT Device Management</h5>
                            <p>Monitor and configure deployed IoT devices</p>
                        </div>
                    </div>
                    <div class="module-actions">
                        <a href="{{ route('administrator.iot_devices') }}" class="btn btn-secondary btn-sm me-2">
                            <i class="fas fa-network-wired"></i> Devices
                        </a>
                        <a href="{{ route('administrator.iot_devices.add') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-plus"></i> Add Device
                        </a>
                    </div>
                </div>
            </div>

            <!-- System Settings -->
            <div class="col-lg-6">
                <div class="module-card">
                    <div class="module-header">
                        <div class="module-icon bg-dark">
                            <i class="fas fa-sliders-h"></i>
                        </div>
                        <div class="module-title">
                            <h5>System Settings</h5>
                            <p>Configure system preferences and settings</p>
                        </div>
                    </div>
                    <div class="module-actions">
                        <a href="#" class="btn btn-dark btn-sm me-2">
                            <i class="fas fa-cog"></i> Settings
                        </a>
                        <a href="#" class="btn btn-outline-dark btn-sm">
                            <i class="fas fa-database"></i> Backup
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="recent-activities">
        <h4 class="section-title">
            <i class="fas fa-history me-2"></i>Recent Activities
        </h4>
        <div class="row">
            <div class="col-lg-8">
                <div class="activity-card">
                    <div class="activity-header">
                        <h6>Latest Orders</h6>
                        <a href="{{ route('administrator.orders') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="activity-list">
                        @forelse(\App\Models\Order::with('user')->latest()->limit(5)->get() as $order)
                        <div class="activity-item">
                            <div class="activity-icon bg-primary">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="activity-content">
                                <p class="activity-text">
                                    Order #{{ $order->id }} from <strong>{{ $order->user->name }}</strong>
                                </p>
                                <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="activity-badge">
                                <span class="badge bg-{{ $order->status->name == 'pending' ? 'warning' : 'success' }}">
                                    {{ $order->orderStatus->display_name ?? 'Pending' }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                            <p class="text-muted">No recent orders</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="activity-card">
                    <div class="activity-header">
                        <h6>System Status</h6>
                    </div>
                    <div class="system-status">
                        <div class="status-item">
                            <div class="status-indicator online"></div>
                            <span>Database Connection</span>
                            <small class="text-success">Online</small>
                        </div>
                        <div class="status-item">
                            <div class="status-indicator online"></div>
                            <span>Email Service</span>
                            <small class="text-success">Active</small>
                        </div>
                        <div class="status-item">
                            <div class="status-indicator warning"></div>
                            <span>Storage Usage</span>
                            <small class="text-warning">75% Used</small>
                        </div>
                        <div class="status-item">
                            <div class="status-indicator online"></div>
                            <span>API Status</span>
                            <small class="text-success">Operational</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Dashboard Specific Styles using GreenTech CSS Variables */
.dashboard-container {
    max-width: 1400px;
    margin: 0 auto;
}

/* Welcome Section - Using GreenTech Variables */
.welcome-section {
    padding: 2rem;
    border-radius: 15px;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(0, 100, 0, 0.4);
    border: 2px solid var(--green-spring);
}

.welcome-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.welcome-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 0;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
}

.admin-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.admin-avatar i {
    font-size: 3rem;
    color: rgba(255, 255, 255, 0.8);
    filter: drop-shadow(0 0 5px rgba(0, 255, 127, 0.3));
}

.admin-name {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
}

.admin-role {
    font-size: 0.9rem;
    opacity: 0.8;
    margin-bottom: 0;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
}

.section-title {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    color: var(--primary-super-dark);
    text-shadow: 0 1px 2px rgba(0, 100, 0, 0.1);
}

/* Quick Actions - Using GreenTech Color System */
.quick-action-card {
    display: block;
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    text-decoration: none;
    color: inherit;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
    height: 100%;
    box-shadow: 0 4px 15px rgba(0, 100, 0, 0.1);
}

.quick-action-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 100, 0, 0.2);
    text-decoration: none;
    color: inherit;
    border-color: var(--primary-light);
}

.product-card:hover { border-color: var(--primary-medium); }
.order-card:hover { border-color: var(--green-lime); }
.user-card:hover { border-color: var(--green-sea-light); }
.iot-card:hover { border-color: var(--accent-medium); }

.action-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
    font-size: 1.5rem;
    border: 2px solid;
}

.bg-primary-light { 
    background: rgba(0, 123, 255, 0.1); 
    color: var(--primary-medium); 
    border-color: var(--primary-light);
}
.bg-success-light { 
    background: rgba(40, 167, 69, 0.1); 
    color: var(--green-lime); 
    border-color: var(--green-lime);
}
.bg-info-light { 
    background: rgba(23, 162, 184, 0.1); 
    color: var(--green-sea-light); 
    border-color: var(--green-sea-light);
}
.bg-secondary-light { 
    background: rgba(111, 66, 193, 0.1); 
    color: var(--accent-medium); 
    border-color: var(--accent-medium);
}

.quick-action-card h6 {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--primary-super-dark);
}

.quick-action-card p {
    font-size: 0.9rem;
    color: var(--text-medium);
    margin-bottom: 0;
}

/* Statistics Cards */
.stat-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 100, 0, 0.1);
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--primary-light) 0%, var(--green-lime) 100%);
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 100, 0, 0.15);
}

.stat-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.stat-trend {
    font-size: 0.8rem;
    font-weight: 600;
}

.stat-trend.positive { color: var(--green-lime); }
.stat-trend.neutral { color: var(--text-medium); }

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary-super-dark);
    margin-bottom: 0.25rem;
    text-shadow: 0 1px 2px rgba(0, 100, 0, 0.1);
}

.stat-label {
    color: var(--text-medium);
    font-size: 0.9rem;
    margin-bottom: 0;
}

/* Module Cards */
.module-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
    height: 100%;
    box-shadow: 0 4px 15px rgba(0, 100, 0, 0.1);
    position: relative;
    overflow: hidden;
}

.module-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--primary-medium) 0%, var(--green-spring) 100%);
}

.module-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 100, 0, 0.15);
}

.module-header {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.module-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.module-title h5 {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: var(--primary-super-dark);
}

.module-title p {
    color: var(--text-medium);
    font-size: 0.9rem;
    margin-bottom: 0;
}

.module-actions {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

/* Activity Cards */
.activity-card {
    background: white;
    border-radius: 12px;
    border: 1px solid #e9ecef;
    box-shadow: 0 4px 15px rgba(0, 100, 0, 0.1);
    overflow: hidden;
}

.activity-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 1.5rem 0 1.5rem;
    margin-bottom: 1rem;
    background: linear-gradient(90deg, rgba(0, 100, 0, 0.05) 0%, transparent 100%);
}

.activity-header h6 {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0;
    color: var(--primary-super-dark);
}

.activity-list {
    padding: 0 1.5rem 1.5rem 1.5rem;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 0;
    border-bottom: 1px solid #f8f9fa;
    transition: all 0.3s ease;
}

.activity-item:hover {
    background: rgba(0, 100, 0, 0.02);
    padding-left: 0.5rem;
    margin: 0 -0.5rem;
    border-radius: 6px;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.9rem;
    flex-shrink: 0;
}

.activity-content {
    flex-grow: 1;
}

.activity-text {
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
    color: var(--text-dark);
}

.activity-badge {
    flex-shrink: 0;
}

/* System Status */
.system-status {
    padding: 1.5rem;
}

.status-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f8f9fa;
    transition: all 0.3s ease;
}

.status-item:hover {
    background: rgba(0, 100, 0, 0.02);
    padding-left: 0.5rem;
    margin: 0 -0.5rem;
    border-radius: 6px;
}

.status-item:last-child {
    border-bottom: none;
}

.status-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
    box-shadow: 0 0 4px rgba(0, 100, 0, 0.3);
}

.status-indicator.online {
    background-color: var(--green-lime);
    animation: pulse 2s infinite;
}

.status-indicator.warning {
    background-color: var(--accent-medium);
    animation: pulse-warning 2s infinite;
}

.status-indicator.offline {
    background-color: #dc3545;
}

@keyframes pulse {
    0% { box-shadow: 0 0 4px rgba(50, 205, 50, 0.3); }
    50% { box-shadow: 0 0 8px rgba(50, 205, 50, 0.6); }
    100% { box-shadow: 0 0 4px rgba(50, 205, 50, 0.3); }
}

@keyframes pulse-warning {
    0% { box-shadow: 0 0 4px rgba(30, 144, 255, 0.3); }
    50% { box-shadow: 0 0 8px rgba(30, 144, 255, 0.6); }
    100% { box-shadow: 0 0 4px rgba(30, 144, 255, 0.3); }
}

/* Enhanced Button Styling with GreenTech Theme */
.btn {
    transition: all 0.3s ease;
    border-radius: 8px;
    font-weight: 500;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 100, 0, 0.2);
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-medium) 0%, var(--primary-light) 100%);
    border-color: var(--primary-light);
}

.btn-primary:hover {
    background: linear-gradient(135deg, var(--primary-light) 0%, var(--green-lime) 100%);
    border-color: var(--green-lime);
}

.btn-success {
    background: linear-gradient(135deg, var(--green-lime) 0%, var(--green-spring) 100%);
    border-color: var(--green-spring);
}

.btn-success:hover {
    background: linear-gradient(135deg, var(--green-spring) 0%, var(--primary-lighter) 100%);
    border-color: var(--primary-lighter);
}

/* Responsive Design */
@media (max-width: 768px) {
    .welcome-section {
        text-align: center;
    }
    
    .admin-info {
        justify-content: center;
        margin-top: 1rem;
    }
    
    .quick-actions .col-lg-3 {
        margin-bottom: 1rem;
    }
    
    .module-actions {
        justify-content: center;
    }
    
    .welcome-title {
        font-size: 1.5rem;
    }
    
    .stat-number {
        font-size: 1.5rem;
    }
}

/* Dark Mode Support */
.dark-mode .stat-card,
.dark-mode .module-card,
.dark-mode .activity-card,
.dark-mode .quick-action-card {
    background: var(--bg-darker);
    border-color: var(--primary-dark);
    color: var(--text-dm-primary);
}

.dark-mode .section-title {
    color: var(--green-spring);
}

.dark-mode .quick-action-card h6,
.dark-mode .module-title h5 {
    color: var(--green-spring);
}

.dark-mode .quick-action-card p,
.dark-mode .module-title p,
.dark-mode .stat-label {
    color: var(--text-dm-muted);
}

.dark-mode .stat-number {
    color: var(--text-dm-primary);
}

.dark-mode .activity-text {
    color: var(--text-dm-secondary);
}
</style>
@endsection