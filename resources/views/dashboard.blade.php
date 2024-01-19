@extends('layouts.app')
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">APLIKASI</h4>
                </div>
                <div class="card-body">
                    <div class="row row-cards">
                        @foreach ($apps as $app)
                            <div class="col-sm-6 col-lg-3">
                                <a href="{{ $app->url }}?token={{ $token }}" class="text-decoration-none"
                                    target="_blank">
                                    <div class="card card-sm">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    @if ($app->type_icon === 'svg')
                                                        <span
                                                            class="bg-danger text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                                                            {!! $app->icon !!}
                                                        </span>
                                                    @endif
                                                    @if ($app->type_icon === 'url_img')
                                                        <img src="{{ $app->icon }}" alt="{{ $app->name }}"
                                                            class="img img-fluid">
                                                    @endif
                                                    @if ($app->type_icon === 'upload_img')
                                                        <img src="/storage/{{ $app->icon }}" alt="{{ $app->name }}"
                                                            class="img img-fluid">
                                                    @endif
                                                </div>
                                                <div class="col">
                                                    <div class="font-weight-medium">
                                                        {{ $app->name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script></script>
@endpush
