@extends('layouts.admin')

@section('title', $title)

@section('content')
    @include('partials.target-table', [
        'track' => 'renstra',
        'deptKode' => $renstradept,
    ])
@endsection
