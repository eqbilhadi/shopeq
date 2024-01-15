<x-layouts-auth.app>
    <x-layouts-auth.header pageTitle="{{ $pageTitle }}"/>

    <body>
        <div class="auth-page-wrapper auth-bg-cover py-1 d-flex justify-content-center align-items-center min-vh-100">
            <div class="bg-overlay"></div>
            <div class="auth-page-content overflow-hidden pt-lg-5">
                {{ $slot }}
            </div>
            <x-layouts-auth.footer />
        </div>
        @include('includes.scripts')
    </body>
</x-layouts-auth.app>
