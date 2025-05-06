<div class="d-flex justify-content-between align-items-center mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            @foreach($breadcrumb->list as $key => $value)
                @if ($key < count($breadcrumb->list) - 1)
                    <li class="breadcrumb-item text-sm">
                        <a class="opacity-5 text-dark" href="#">{{ $value }}</a>
                    </li>
                @else
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $value }}</li>
                @endif
            @endforeach
        </ol>
    </nav>
    <h6 class="font-weight-bolder mb-0">{{ $breadcrumb->title }}</h6>
</div>
