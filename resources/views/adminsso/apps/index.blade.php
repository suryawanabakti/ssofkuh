@extends('layouts.app')
@section('content')
    <div class="page-body">
        <div class="container-xl">
            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                    <strong>{{ session()->get('success') }}</strong>
                </div>
            @endif
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">Apps</h4>
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/apps/create">Tambah</a></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">Import</a></li>
                            <li><a class="dropdown-item" href="#">Export</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <td>Nama</td>
                                    <th>Kategori</th>
                                    <td>Redirect URL</td>
                                    <td>Icon</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($apps as $app)
                                    <tr>
                                        <td>{{ $app->name }}</td>
                                        <td>{{ $app->category?->name }}</td>
                                        <td>{{ $app->url }}</td>
                                        <td>
                                            @if ($app->type_icon === 'svg')
                                                {!! $app->icon !!}
                                            @endif
                                            @if ($app->type_icon === 'url_img')
                                                <img src="{{ $app->icon }}" alt="{{ $app->name }}"
                                                    class="img img-fluid">
                                            @endif
                                            @if ($app->type_icon === 'upload_img')
                                                <img src="/storage/{{ $app->icon }}" alt="{{ $app->name }}"
                                                    class="img img-fluid">
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item"
                                                            href="/apps/{{ $app->id }}/edit">Edit</a></li>
                                                    <li>
                                                        <form action="/apps/{{ $app->id }}" method="POST"
                                                            onsubmit="return confirm('Apakah anda yakin ?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="dropdown-item" type="submit">Hapus</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
