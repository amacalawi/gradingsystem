@if (count($flashMessage))
    @foreach ($flashMessage as $message)
        <div class="alert alert-{{ $message['type'] }} alert-dismissible fade show m-alert m-alert--square m-alert--air" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
            <i class="la {{ $message['icon'] }}"></i>
            <strong>
                {{ $message['info'] }}
            </strong>
            {{ $message['message'] }}
        </div>
    @endforeach
@endif