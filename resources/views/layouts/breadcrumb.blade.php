<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $breadcrumb->title ?? 'Default Title' }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @if(isset($breadcrumb->list))
                        @foreach($breadcrumb->list as $key => $value)
                            @if($key === array_key_last($breadcrumb->list))
                                <li class="breadcrumb-item active">{{ $value }}</li>
                            @else
                                <li class="breadcrumb-item"><a href="{{ $value }}">{{ $key }}</a></li>
                            @endif
                        @endforeach
                    @endif
                </ol>
            </div>
        </div>
    </div>
</section>
