@extends('layouts.app')
@section('content')
    <div class="page-body">

        <div class="container-xl">
            @if (auth()->user()->temporary_password)
                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">Perhatian !</h4>
                    <p>
                        Harap segera mengganti password sementara anda <a href="/profile" class="fw-bold">Klik Disini</a>
                    </p>
                    <hr>
                    <p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>
                </div>
            @endif
            @if (!auth()->user()->temporary_password)
                @foreach ($categories as $category)
                    @if ($category->apps->count() > 0)
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ $category->name }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="row row-cards">
                                    @foreach ($category->apps as $app)
                                        <div class="col-sm-6 col-lg-3">
                                            <a href="{{ $app->url }}?token={{ $token }}"
                                                class="text-decoration-none" target="_blank">
                                                <div class="card card-sm card-app">
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
                                                                    <img src="/storage/{{ $app->icon }}"
                                                                        alt="{{ $app->name }}" class="img img-fluid">
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
                    @endif
                @endforeach
            @endif

        </div>
    </div>
@endsection

@push('js')
    <script>
        $('.card-app').hover(function() {
            $(this).css("border-color", "red");
        }, function() {
            $(this).css("border-color", "#E5E8EB");
        })
    </script>
@endpush
