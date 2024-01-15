<div id="laravel-notify">
    @if (session()->has('notify.message'))
        <div class="bs-toast toast fade show position-absolute top-0 end-0" role="alert" aria-live="assertive"
            aria-atomic="true">
            @include('notify::notifications.toast')

            @include('notify::notifications.smiley')

            @include('notify::notifications.drakify')

            @include('notify::notifications.connectify')

            @include('notify::notifications.emotify')
        </div>
    @endif

    {{ session()->forget('notify.message') }}

    <script>
        var notify = {
            timeout: "{{ config('notify.timeout') }}",
        }
    </script>
</div>
