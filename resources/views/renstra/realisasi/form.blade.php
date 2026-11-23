@extends('layouts.admin')

@section('title', $title)

@section('csslocal')
    <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet">
@endsection

@section('content')
    @include('partials.realisasi-form', ['track' => 'renstra'])
@endsection

@section('scriptlocal')
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    <script>
        const inputElement = document.querySelector('input[type="file"]');
        if (inputElement) {
            FilePond.create(inputElement, {
                allowMultiple: true,
                maxFiles: 5,
                labelIdle: 'Tarik &amp; letakkan file atau <span class="filepond--label-action">Pilih Berkas</span>',
                maxFileSize: '5MB',
                server: {
                    process: '{{ route('renstra.realisasi.tmpUpload', [$departemen->kode, $triwulan->triwulan, $realisasi->kode]) }}',
                    revert: '{{ route('renstra.realisasi.tmpDelete', [$departemen->kode, $triwulan->triwulan, $realisasi->kode]) }}',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                }
            });
        }
    </script>
@endsection
