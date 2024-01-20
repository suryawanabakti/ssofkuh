@extends('layouts.app')
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">

                <div class="card-body">

                    @include('profile.partials.update-password-form')

                </div>
            </div>
        </div>
    </div>
@endsection
