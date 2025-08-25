<div class="container mt-5">
    <div class="row g-4">
        <style>
            .card-body {
                background: white;
                flex: 1 1 auto;
                padding: var(--bs-card-spacer-y) var(--bs-card-spacer-x);
                color: black;
            }
        </style>

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
</div>
