<div>

    <style>
        .main-content {
            background-color: #000;
        }

        button#contact-tab:hover {
            color: white;
        }

        button#home-tab:hover {
            color: white;
        }

        button#profile-tab:hover {
            color: white;
        }

        .nav-link {
            display: block;
            padding: var(--bs-nav-link-padding-y) var(--bs-nav-link-padding-x);
            font-size: var(--bs-nav-link-font-size);
            font-weight: var(--bs-nav-link-font-weight);
            color: #ffffff;
            text-decoration: none;
            background: 0 0;
            border: 0;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out;
        }

        .modal-title {
            color: black;
        }

        h5 {
            color: black;
        }

        .mb-0 {
            color: white;
        }

        .form-control {
            font-size: 11px;
        }

        .btn.btn-primary {
            font-size: 10px;
            background: black;
            border: none;
        }

        img {
            height: 121px;
            width: 125px;
        }
    </style>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
                role="tab" aria-controls="home" aria-selected="true">Pending Orders</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                role="tab" aria-controls="profile" aria-selected="false">Completed Orders</button>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            @livewire('admin.delivery-order.order-assign')
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            @livewire('admin.delivery-order.completed-orders')
        </div>
    </div>
</div>
