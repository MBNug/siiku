@extends('layouts.admin')

@section('title', $title)

@section('content')
    @include('partials.dept-picker', [
        'track' => 'renstra',
        'mode' => 'realisasi',
        'heading' => 'Realisasi Renstra per Departemen',
        'subtitle' => 'Pilih departemen untuk memantau capaian triwulan, memeriksa dokumen bukti, atau mengakhiri triwulan.',
        'actionLabel' => 'Lihat Realisasi Renstra',
    ])
@endsection
