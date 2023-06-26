{{-- @dd($status); --}}

@extends('layouts.admin')

@section('title', ''.$title)

@section('content')
<div class="container">
    <!-- Page Heading -->
    <section class="content-header">
        <div class="row">
            <div class="col-lg-9">
                <h1 class="h3 mb-4 text-primary">@yield('title')</h1>
            </div>
        </div>
    </section>
    @foreach ($departemens as $departemen)
        <a href="{{ route('renstra.targetdepartemen', $departemen->kode) }}" class="btn btn-secondary">{{ $departemen->nama }}</a>
    @endforeach
</div>
@endsection