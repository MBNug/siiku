@extends('layouts.admin')

@section('title', $title)

@section('content')
    @include('partials.uncreate-empty', [
        'heading' => $title . ' Belum Tersedia',
        'description' => 'Buat lembar target baru dari katalog indikator aktif tahun berjalan.',
        'actionHref' => route('renstra.target.store', $renstradept),
        'actionLabel' => 'Buat Target Baru',
    ])
@endsection
