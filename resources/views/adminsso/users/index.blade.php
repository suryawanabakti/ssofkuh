@extends('layouts.app')
@section('content')
    <div class="page-body">
        <div class="container-xl">
            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                    <strong>{{ session()->get('success') }}</strong>
                </div>
            @endif

            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class="card-title">Users Data</h3>
                        <div class="dropdown">
                            <button class="btn btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/users/create">Tambah</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">Import</a></li>
                                <li><a class="dropdown-item" href="/users/export">Export</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body border-bottom py-3">
                        <div class="d-flex">
                            <div class="text-secondary">
                                @if (request('search'))
                                    <a href="/users" class="btn btn-danger btn-sm">Refresh</a>
                                @endif
                            </div>
                            <div class="ms-auto text-secondary">
                                Search:
                                <div class="ms-2 d-inline-block">
                                    <form action="">
                                        <input type="text" class="form-control form-control-sm" aria-label="Search User"
                                            placeholder="Press Enter To Search" name="search"
                                            value="{{ request('search') }}">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Password Sementara / Pertama</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->temporary_password }}</td>
                                        <td class="text-end">
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item"
                                                            href="/users/{{ $user->id }}/edit">Edit</a></li>
                                                    <li>
                                                        <form action="/users/{{ $user->id }}" method="POST"
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
                    <div class="card-footer d-flex align-items-center justify-content-between mt-2">
                        <p class="m-0 text-secondary">Showing <span>1</span> to <span>10</span> of
                            <span>{{ $users->total() }}</span> entries
                        </p>
                        <div class="float-right">
                            {!! $users->links() !!}
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    @include('adminsso.users.import')
@endsection
