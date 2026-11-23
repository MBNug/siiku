@extends('layouts.admin')

@section('title', 'Dashboard PTN-BH')

@section('content')
    @include('partials.dashboard-content', ['track' => 'ptnbh'])
@endsection
