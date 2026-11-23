@extends('layouts.admin')

@section('title', $title)

@section('content')
    @include('partials.realisasi-table', ['track' => 'ptnbh', 'deptKode' => $ptnbhdept, 'quarter' => '2'])
@endsection
