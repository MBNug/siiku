@extends('layouts.admin')

@section('title', $title)

@section('content')
    @include('partials.dept-picker', [
        'track' => 'ptnbh',
        'mode' => 'realisasi',
        'heading' => 'Realisasi PTN-BH per Departemen',
        'subtitle' => 'Pilih departemen untuk memantau capaian triwulan, memeriksa dokumen bukti, atau mengakhiri triwulan.',
        'actionLabel' => 'Lihat Realisasi PTN-BH',
    ])
@endsection
