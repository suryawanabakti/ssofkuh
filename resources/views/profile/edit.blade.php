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

@push('js')
    <script>
        $("#visible").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
@endpush
