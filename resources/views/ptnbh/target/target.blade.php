@extends('layouts.admin')

@section('title', $title)

@section('content')
    @include('partials.target-table', [
        'track' => 'ptnbh',
        'deptKode' => $ptnbhdept,
    ])
@endsection
