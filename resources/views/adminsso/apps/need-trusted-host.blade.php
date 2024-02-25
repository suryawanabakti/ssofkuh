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
                    <h4 class="card-title">User Tertaut di {{ $app->name }}</h4>
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#action-tambah" data-bs-toggle="modal"
                                    data-bs-target="#createModal">Tambah</a></li>
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
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($needTrustedHost as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->user->name }} <br>
                                            {{ $data->user->username }}
                                        </td>
                                        <td>
                                            <form action="/apps/{{ $data->id }}/need-trusted-host" method="POST"
                                                onsubmit="return confirm('Apakah anda yakin ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn" type="submit">Hapus Tautan</button>
                                            </form>
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
