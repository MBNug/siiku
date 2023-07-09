@extends('layouts.admin')

@section('title', $title)

@section('content')

<div class="container">
    <section class="content-header">
        <div class="row">
            <div class="col-lg-9">
            </div>
        </div>
    </section>
    <div class="card shadow mb-4">
        <div class="container mt-3 mb-2">
            <div class="row">
                <form action="{{ route('user.updatePassword')}}" method="post" enctype="multipart/form-data">
                    <h1 class="h3 mb-4 text-primary">@yield('title')</h1>
                            @csrf
                            @method('PUT')
                            <div class="input-group mb-3">
                                <input type="password" class="form-control
                                @error('passwordlama')
                                    is-invalid
                                @enderror
                                " placeholder="Password Lama" value="{{ old('passwordlama') }}" name="passwordlama">
                                @error('passwordlama')
                                    <div class="invalid-feedback">
                                    {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control
                                @error('passwordbaru')
                                    is-invalid
                                @enderror
                                " placeholder="Password Baru" value="{{ old('passwordbaru') }}" name="passwordbaru">
                                @error('passwordbaru')
                                    <div class="invalid-feedback">
                                    {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control
                                @error('konfirmasipassword')
                                    is-invalid
                                @enderror
                                " placeholder="Konfirmasi Password" value="{{ old('konfirmasipassword') }}" name="konfirmasipassword">
                                @error('konfirmasipassword')
                                    <div class="invalid-feedback">
                                    {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="input-group mb-3">
                                <button type="submit" class="btn btn-success"><i class="fa fa-floppy-disk mr-2"></i> Ganti</button>
                                <a href="{{ route('renstra.dashboard') }}" id="back" class="btn btn-light "><i class="fa fa-times mr-2"></i> Nanti saja</a>
                            </div>
                        </form>                       
            </div>
        </div>
    </div>
</div>

@endsection