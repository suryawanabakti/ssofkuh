@extends('layouts.app')
@section('content')
    <div class="page-body">

        <div class="container-xl">
            <div class="card">
                <div class="card-body">

                </div>
                <table class="table table-hover card-table">
                    <thead>
                        <tr>
                            <th>Nama Applikasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($needTrustedHost as $data)
                            <tr>

                                <td>{{ $data->app->name }}</td>
                                <td>
                                    <a onclick="return confirm('Apakah anda yakin?')"
                                        href="/connected/{{ $data->id }}/delete" class="btn btn-danger btn-sm">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


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
