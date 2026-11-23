@extends('layouts.admin')

@section('title', $title)

@section('content')
    @include('partials.uncreate-empty', [
        'heading' => $title . ' Belum Dibentuk',
        'description' => 'Klik tombol di bawah untuk menyalin seluruh target PTN-BH yang sudah disetujui ke lembar Realisasi Triwulan 1.',
        'actionHref' => route('ptnbh.realisasi.store', [$ptnbhdept, $triwulan->triwulan]),
        'actionLabel' => 'Buat ' . $title,
    ])
@endsection
