<div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">



    <div class="container mt-4">
        <div class="row g-4">

            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Admins</h6>
                            <h4 class="fw-bold">{{ $roleCounts['admin'] ?? 0 }}</h4>
                        </div>
                        <i class="fas fa-user-shield text-primary fs-2"></i>
                    </div>
                </div>
            </div>

            <!-- Customers -->
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Customers</h6>
                            <h4 class="fw-bold">{{ $roleCounts['customer'] ?? 0 }}</h4>
                        </div>
                        <i class="fas fa-user text-success fs-2"></i>
                    </div>
                </div>
            </div>

            <!-- Delivery -->
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Delivery Agents</h6>
                            <h4 class="fw-bold">{{ $roleCounts['delivery'] ?? 0 }}</h4>
                        </div>
                        <i class="fas fa-motorcycle text-warning fs-2"></i>
                    </div>
                </div>
            </div>

            <!-- Sales -->
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Sales Users</h6>
                            <h4 class="fw-bold">{{ $roleCounts['sales'] ?? 0 }}</h4>
                        </div>
                        <i class="fas fa-chart-line text-danger fs-2"></i>
                    </div>
                </div>
            </div>

            <!-- Total Users -->
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Total Users</h6>
                            <h4 class="fw-bold">{{ $roleCounts['total'] }}</h4>
                        </div>
                        <i class="fas fa-users text-dark fs-2"></i>
                    </div>
                </div>
            </div>

            <!-- Total Users -->
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Total Products</h6>
                            <h4 class="fw-bold">{{ $productCounts }}</h4>
                        </div>
                        <i class="fas fa-cube text-dark fs-2"></i>
                    </div>
                </div>
            </div>

            <!-- Pending Orders -->
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Pending Orders</h6>
                            <h4 class="fw-bold">{{ $statusCounts['pending'] }}</h4>
                        </div>
                        <i class="fas fa-clock text-warning fs-2"></i>
                    </div>
                </div>
            </div>

            <!-- Confirmed Orders -->
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Confirmed Orders</h6>
                            <h4 class="fw-bold">{{ $statusCounts['confirmed'] }}</h4>
                        </div>
                        <i class="fas fa-check text-primary fs-2"></i>
                    </div>
                </div>
            </div>

            <!-- Out for Delivery -->
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Out for Delivery</h6>
                            <h4 class="fw-bold">{{ $statusCounts['out_for_delivery'] }}</h4>
                        </div>
                        <i class="fas fa-truck text-warning fs-2"></i>
                    </div>
                </div>
            </div>

            <!-- Delivered Orders -->
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Delivered Orders</h6>
                            <h4 class="fw-bold">{{ $statusCounts['delivered'] }}</h4>
                        </div>
                        <i class="fas fa-box-open text-success fs-2"></i>
                    </div>
                </div>
            </div>

            <!-- Total Orders -->
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Total Orders</h6>
                            <h4 class="fw-bold">{{ $statusCounts['total'] }}</h4>
                        </div>
                        <i class="fas fa-list text-dark fs-2"></i>
                    </div>
                </div>
            </div>
        </div>


    </div>



    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="container mt-4">
        <h2 style="text-align: center">Branch Orders for {{ now()->format('F Y') }}</h2>
        <canvas id="ordersChart" height="120"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('ordersChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($dates),
                datasets: @json($chartData),
            },
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                stacked: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Montly Orders per Branch'
                    }
                },
                scales: {
                    y: {
                        title: {
                            display: true,
                            text: 'Orders'
                        },
                        beginAtZero: true
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    }
                }
            }
        });
    </script>
</div>
