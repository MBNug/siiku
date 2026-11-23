@extends('layouts.admin')

@section('title', $title)

@section('content')
    @include('partials.dept-picker', [
        'track' => 'renstra',
        'mode' => 'target',
        'heading' => 'Target Renstra per Departemen',
        'subtitle' => 'Pilih departemen untuk meninjau, mengisi, atau menyetujui target IKU Renstra.',
        'actionLabel' => 'Kelola Target Renstra',
    ])
@endsection
