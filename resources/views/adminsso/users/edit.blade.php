@extends('layouts.app')
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">Edit User</h4>
                </div>
                <div class="card-body">
                    <form action="/users/{{ $user->id }}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama <span class="text-danger">*</span> </label>
                            <input type="text" placeholder="...." class="form-control" required name="name"
                                value="{{ $user->name }}">
                            @error('name')
                                <small class="text-danger"> {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Username <span class="text-danger">*</span> </label>
                            <input type="text" placeholder="...." class="form-control" required name="sso_token"
                                value="{{ $user->sso_token }}">
                            @error('sso_token')
                                <small class="text-danger"> {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">SSO Token <span class="text-danger">*</span> </label>
                            <input type="text" placeholder="...." class="form-control" required name="username"
                                value="{{ $user->username }}">
                            @error('username')
                                <small class="text-danger"> {{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Password </label>
                            <input type="password" placeholder="...." class="form-control" name="password">
                            @error('password')
                                <small class="text-danger"> {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Password Confirmation </label>
                            <input type="password" placeholder="...." class="form-control" name="password_confirmation">
                        </div>

                        <button class="btn btn-primary" type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
