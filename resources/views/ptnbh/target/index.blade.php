@extends('layouts.admin')

@section('title', $title)

@section('content')
    @include('partials.dept-picker', [
        'track' => 'ptnbh',
        'mode' => 'target',
        'heading' => 'Target PTN-BH per Departemen',
        'subtitle' => 'Pilih departemen untuk meninjau, mengisi, atau menyetujui target IKU PTN-BH.',
        'actionLabel' => 'Kelola Target PTN-BH',
    ])
@endsection
