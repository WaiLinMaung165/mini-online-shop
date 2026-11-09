@extends('layouts.admin')

@section('title', 'Admin Dashboard - Ruiz Watches')

@section('content')
    <div class="container-fluid py-4" style="font-family: 'PT Serif', serif;">

        <!-- Statistic Cards -->
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card p-4 border-0 shadow-sm bg-white rounded-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted small mb-1">Total Products</h6>
                            <h3 class="fw-bold text-dark mb-0">{{ $totalProducts }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-4 fs-4">
                            <i class="fa-solid fa-box"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card p-4 border-0 shadow-sm bg-white rounded-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted small mb-1">Total Orders</h6>
                            <h3 class="fw-bold text-dark mb-0">{{ $totalOrders }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 text-success p-3 rounded-4 fs-4">
                            <i class="fa-solid fa-bag-shopping"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card p-4 border-0 shadow-sm bg-white rounded-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted small mb-1">Registered Users</h6>
                            <h3 class="fw-bold text-dark mb-0">{{ $totalUsers }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 text-info p-3 rounded-4 fs-4">
                            <i class="fa-solid fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card p-4 border-0 shadow-sm bg-white rounded-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted small mb-1">Total Revenue</h6>
                            <h3 class="fw-bold text-success mb-0">${{ number_format($totalSales, 2) }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-4 fs-4">
                            <i class="fa-solid fa-dollar-sign"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Analytics Bar Chart Section -->
        <div class="card shadow-sm border-0 p-4 bg-white rounded-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                <h4 class="fw-bold mb-0 text-dark">
                    <i class="fa-solid fa-chart-column text-success me-2"></i> Sales Analytics
                </h4>

                <!-- Filter Buttons (Daily, Weekly, Monthly, Yearly) -->
                <div class="btn-group shadow-sm" role="group">
                    <a href="{{ route('admin.dashboard', ['filter' => 'daily']) }}"
                        class="btn btn-outline-success btn-sm {{ $filter == 'daily' ? 'active' : '' }}">Daily</a>
                    <a href="{{ route('admin.dashboard', ['filter' => 'weekly']) }}"
                        class="btn btn-outline-success btn-sm {{ $filter == 'weekly' ? 'active' : '' }}">Weekly</a>
                    <a href="{{ route('admin.dashboard', ['filter' => 'monthly']) }}"
                        class="btn btn-outline-success btn-sm {{ $filter == 'monthly' ? 'active' : '' }}">Monthly</a>
                    <a href="{{ route('admin.dashboard', ['filter' => 'yearly']) }}"
                        class="btn btn-outline-success btn-sm {{ $filter == 'yearly' ? 'active' : '' }}">Yearly</a>
                </div>
            </div>

            <!-- Chart Canvas -->
            <div style="position: relative; height: 350px; width: 100%;">
                <canvas id="salesBarChart"></canvas>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('salesBarChart').getContext('2d');
        const salesBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Revenue ($)',
                    data: {!! json_encode($chartData) !!},
                    backgroundColor: 'rgba(13, 110, 253, 0.75)',
                    borderColor: 'rgba(13, 110, 253, 1)',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    </script>
@endsection
