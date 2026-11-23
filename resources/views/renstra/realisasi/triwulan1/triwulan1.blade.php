@extends('layouts.admin')

@section('title', $title)

@section('content')
    @include('partials.realisasi-table', ['track' => 'renstra', 'deptKode' => $renstradept, 'quarter' => '1'])
@endsection
