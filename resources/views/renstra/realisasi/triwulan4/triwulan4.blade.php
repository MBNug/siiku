@extends('layouts.admin')

@section('title', $title)

@section('content')
    @include('partials.realisasi-table', ['track' => 'renstra', 'deptKode' => $renstradept, 'quarter' => '4'])
@endsection
