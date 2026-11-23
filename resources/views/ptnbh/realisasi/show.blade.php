@extends('layouts.admin')

@section('title', $title)

@section('content')
    @include('partials.realisasi-detail', ['track' => 'ptnbh'])
@endsection
