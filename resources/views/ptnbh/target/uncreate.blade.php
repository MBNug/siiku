@extends('layouts.admin')

@section('title', $title)

@section('content')
    @include('partials.uncreate-empty', [
        'heading' => $title . ' Belum Tersedia',
        'description' => 'Buat lembar target baru dari katalog indikator PTN-BH aktif tahun berjalan.',
        'actionHref' => route('ptnbh.target.store', $ptnbhdept),
        'actionLabel' => 'Buat Target Baru',
    ])
@endsection
