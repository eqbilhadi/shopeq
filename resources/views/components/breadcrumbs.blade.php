@unless ($breadcrumbs->isEmpty())
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                @foreach ($breadcrumbs as $breadcrumb)
                    @if($loop->last)
                        <h4 class="mb-sm-0">{{ $breadcrumb->title }}</h4>
                    @endif
                @endforeach

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        @foreach ($breadcrumbs as $breadcrumb)
                            @if ($breadcrumb->url && !$loop->last)
                                <li class="breadcrumb-item"><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                            @elseif(!$loop->last)
                                <li class="breadcrumb-item active">{{ $breadcrumb->title }}</li>
                            @else
                                <li class="breadcrumb-item active">{{ $breadcrumb->title }}</li>
                            @endif
                        @endforeach
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->
@endunless
