@extends('layouts.admin')

@section('title', 'Dashboard Renstra')

@section('content')
    @include('partials.dashboard-content', ['track' => 'renstra'])
@endsection
