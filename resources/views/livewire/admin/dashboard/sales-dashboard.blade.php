<div class="col-md-12 mt-5">
    <style>
        .card-body {
            flex: 1 1 auto;
            padding: var(--bs-card-spacer-y) var(--bs-card-spacer-x);
            color: black;
            background: white;
        }
    </style>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="col-md-12 mt-5">
        <div class="dashboard-summary row g-4">

            <!-- Total Orders -->
            <div class="col-md-4">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <div class="text-primary mb-2 fs-1">
                            <i class="bi bi-bag-check-fill"></i>
                        </div>
                        <h6 class="text-muted">Total Orders</h6>
                        <h3 class="fw-bold">{{ $totalOrders }}</h3>
                    </div>
                </div>
            </div>

            <!-- Weekly Orders -->
            <div class="col-md-4">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <div class="text-warning mb-2 fs-1">
                            <i class="bi bi-calendar-week-fill"></i>
                        </div>
                        <h6 class="text-muted">Weekly Orders</h6>
                        <h3 class="fw-bold">{{ $weeklyOrders }}</h3>
                    </div>
                </div>
            </div>

            <!-- Monthly Orders -->
            <div class="col-md-4">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <div class="text-success mb-2 fs-1">
                            <i class="bi bi-calendar-month-fill"></i>
                        </div>
                        <h6 class="text-muted">Monthly Orders</h6>
                        <h3 class="fw-bold">{{ $monthlyOrders }}</h3>
                    </div>
                </div>
            </div>

            <!-- Confirmed Orders -->
            <div class="col-md-4">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <div class="text-info mb-2 fs-1">
                            <i class="bi bi-check2-circle"></i>
                        </div>
                        <h6 class="text-muted">Confirmed Orders</h6>
                        <h3 class="fw-bold">{{ $confirmedOrders }}</h3>
                    </div>
                </div>
            </div>

            <!-- Delivered Orders -->
            <div class="col-md-4">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <div class="text-dark mb-2 fs-1">
                            <i class="bi bi-truck"></i>
                        </div>
                        <h6 class="text-muted">Delivered Orders</h6>
                        <h3 class="fw-bold">{{ $deliveredOrders }}</h3>
                    </div>
                </div>
            </div>

        </div>

        <!-- Chart.js Graph -->
        <div class="col-md-12 mt-5">
            <canvas id="ordersChart"></canvas>
        </div>

    </div>

    <script>
        // Get data from Livewire
        var ordersData = @json($ordersData);

        // Create Chart
        var ctx = document.getElementById('ordersChart').getContext('2d');
        var ordersChart = new Chart(ctx, {
            type: 'bar', // You can change this to 'line', 'pie', etc.
            data: {
                labels: ordersData.labels,
                datasets: [{
                    label: 'Order Statistics',
                    data: ordersData.data,
                    backgroundColor: ['#007bff', '#fd7e14', '#28a745', '#17a2b8', '#6c757d'],
                    borderColor: ['#007bff', '#fd7e14', '#28a745', '#17a2b8', '#6c757d'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.raw; // Show exact number on hover
                            }
                        }
                    }
                }
            }
        });
    </script>

</div>
