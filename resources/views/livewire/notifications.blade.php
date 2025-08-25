<li class="dropdown">
    <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown">
        <i class="icon-bell"></i>
        @if ($notifications->count() > 0)
            <span class="notification-dot"></span>
        @endif
    </a>
    <ul class="dropdown-menu notifications">
        <li class="header">
            <strong>You have {{ $notifications->count() }} new Notifications</strong>
        </li>
        @forelse($notifications as $notification)
            <li>
                <a href="javascript:void(0);" wire:click="markAsRead({{ $notification->id }})">
                    <div class="media">
                        <div class="media-left">
                            @if ($notification->type == 'info')
                                <i class="icon-info text-warning"></i>
                            @elseif($notification->type == 'like')
                                <i class="icon-like text-success"></i>
                            @elseif($notification->type == 'pie')
                                <i class="icon-pie-chart text-info"></i>
                            @else
                                <i class="icon-info text-danger"></i>
                            @endif
                        </div>
                        <div class="media-body">
                            <p class="text">{{ $notification->message }}</p>
                            <span class="timestamp">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </a>
            </li>
        @empty
            <li>
                <p>No new notifications</p>
            </li>
        @endforelse
        <li class="footer">
            {{-- <a href="{{ route('notifications.index') }}" class="more">See all notifications</a> --}}
        </li>
    </ul>
</li>
