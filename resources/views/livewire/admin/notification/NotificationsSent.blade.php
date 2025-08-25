@extends('layouts.app')
@section('content')
    <div class="col-lg-12">

        <div class="card">
            <div class="d-flex justify-content-between align-items-center mt-3 m-3">
                <h4 class="mb-0">Notifications</h4>
                <!-- Add New button -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                    Add New
                </button>
            </div>
        </div>

        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif


        <div class="card">
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Users</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notifications as $notification)
                                @php
                                    $messageUsers = DB::table('notifications_users')
                                        ->join('users', 'notifications_users.to_user', '=', 'users.id')
                                        ->where('notification_id', $notification->id)
                                        ->select('users.name')
                                        ->get();
                                @endphp

                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $notification->message }}</td>
                                    <td>
                                        @foreach ($messageUsers as $item)
                                            {{ $item->name }}{{ !$loop->last ? ' | ' : '' }}
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.notification', ['id' => $notification->id]) }}"
                                            class="btn btn-primary">View</a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-12">
            </div>
        </div>
        <!-- Modal with form -->
        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('notifications.store') }}" method="POST" class="modal-content">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Add New Notification</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="customers">Select Users</label>
                            <select class="js-example-basic-multiple" name="customers[]" multiple="multiple"
                                style="width: 100%;">

                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                                <!-- Populate dynamically in Blade -->
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="message">Message</label>
                            <textarea name="message" id="message" cols="30" rows="6" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send Notification</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
