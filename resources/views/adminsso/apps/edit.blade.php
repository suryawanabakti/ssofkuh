@extends('layouts.app')
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">Edit Application</h4>
                </div>
                <div class="card-body">
                    <form action="/apps/{{ $app->id }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Kategori</label>
                            <select name="category_id" id="category_id" class="form-select" required>
                                <option value="">Pilih </option>
                                @foreach ($categories as $category)
                                    <option @selected($category->id === $app->category_id) value="{{ $category->id }}">{{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <small class="text-danger"> {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" placeholder="...." class="form-control" name="name" required
                                value="{{ $app->name }}">
                            @error('name')
                                <small class="text-danger"> {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">URL <span class="text-danger">*</span></label>
                            <input type="text" placeholder="...." class="form-control" required name="url"
                                value="{{ $app->url }}">
                            @error('url')
                                <small class="text-danger"> {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Butuh Trusted Host? <span
                                    class="text-danger">*</span></label>
                            <select name="need_trusted_host" id="" class="form-select">
                                <option value="0" @selected($app->need_trusted_host === 0)>Tidak</option>
                                <option value="1" @selected($app->need_trusted_host === 1)>Iya</option>
                            </select>
                            @error('need_trusted_host')
                                <small class="text-danger"> {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Add URL</label>
                            <input type="text" placeholder="...." class="form-control" name="add_url"
                                value="{{ $app->add_url }}">
                            @error('add_url')
                                <small class="text-danger"> {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Type Icon</label>
                            <select name="type_icon" id="type_icon" class="form-select">
                                <option value="">Pilih</option>
                                <option value="svg">SVG / Text</option>
                                <option value="url_img">URL Image</option>
                                <option value="upload_img">Upload Image</option>
                            </select>
                            @error('type_icon')
                                <small class="text-danger"> {{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3" id="icon">

                        </div>
                        @error('icon')
                            <small class="text-danger"> {{ $message }}</small>
                        @enderror
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#type_icon').val("{{ $app->type_icon }}").change()
        })
        $('#type_icon').on('change', function() {
            let val = $('#type_icon').val()
            if (val === '') {
                $('#icon').html(``)
            }
            var iconValue = "{{ $app->icon }}"
            if (val === 'svg') {
                $('#icon').html(` <label for="" class="form-label">Icon SVG / Text </label>
                            <textarea name="icon" id="icon" rows="10" class="form-control h-100">${iconValue}</textarea>
                            `)
            }

            if (val === 'url_img') {
                $('#icon').html(
                    `   <label for="" class="form-label">URL Image</label>
                            <input type="text" value="${iconValue}" class="form-control" name="icon" placeholder="https://....">`
                )
            }

            if (val === 'upload_img') {
                $('#icon').html(
                    `   <label for="" class="form-label">File Image</label>
                            <input type="file" class="form-control" accept="image/*" name="icon" placeholder="https://....">`
                )
            }
        });
    </script>
@endpush
