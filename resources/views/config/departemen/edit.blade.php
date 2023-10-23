@extends('layouts.admin')

@section('title', 'Edit Departemen')

{{-- @dd($departemen); --}}

@section('csslocal')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endsection

@section('content')
<div class="container">
    <!-- Page Heading -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="container mt-3 mb-2">
                
                <form action="{{ route('departemen.update', $departeman->kode)}}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Kode*</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control @error('kode') is-invalid @enderror" name="kode" placeholder="Kode" value="{{ old('kode', $departeman->kode) }}">
                            @error('kode')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Nama*</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Nama" value="{{ old('nama', $departeman->nama) }}">
                            @error('nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group py-3">
                        <button type="submit" class="btn btn-success"><i class="fa fa-floppy-disk"></i> Simpan</button>
                        <a href="{{ route('departemen.index') }}" id="back" class="btn btn-light"><i class="fa fa-times mr-2"></i> Batal</a>
                        
                    </div>
                </form>
                <form action="{{ route('departemen.destroy', $departeman->kode) }}" method="post" class="d-inline">@csrf @method('DELETE')<button type="button" class="btn btn-sm btn-danger confirm-delete"><i class="fas fa-trash"></i> Hapus</button></form>


            </div>
        </div>
    </div>
</div>
@endsection

@section('scriptlocal')

<script>
    $(document).on('click', 'button.confirm-delete', function () {
        Swal.fire({
        title: 'Hapus data Departemen?',
        text: "Ini akan membuat target dan realisasi untuk departemen ini akan dihapus!",
        showCancelButton: true,
        confirmButtonColor: '#17356d',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus'
        }).then((result) => {
        if (result.isConfirmed) {
            $(this).parent('form').trigger('submit')
        } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
        }
        })
    });;
</script>


@endsection
