{{-- @dd($status); --}}

@extends('layouts.admin')

@section('title', ''.$title)

@section('content')
<div class="container">
    <div>
        <h1 class="h3 mb-4 text-primary">@yield('title')</h1>
    </div>
    <div class="container" style="display: flex;flex-direction:column;padding-left: 0px">
        @foreach ($departemens as $departemen)
        <a style="width:75%;text-align:left;margin-bottom: 15px;background-color:#f8f9fa;padding:20px;color:#213f76;font-size:20px;border-width:2px;border-color:#b5b5b5" href="{{ route('renstra.targetdepartemen', $departemen->kode) }}" class="btn">Departemen {{ $departemen->nama }}</a>
        @endforeach
    </div>
</div>
@endsection