@extends('layouts.admin')

@section('title', 'Departemen Fakultas Sains dan Matematika')

@section('content')
<div class="container">
  <!-- Page Heading -->
  <section class="content-header">
    <div class="row">
        <div class="col-lg-9">
            <h1 class="h3 mb-4 text-primary">Departemen Fakultas Sains dan Matematika</h1>
        </div>
    </div>
  </section>
  <div class="row">
    <div class="col-lg">
      <a href="{{ route('departemen.create') }}" class="btn btn-primary mb-3 px-10"><i class="fa fa-plus mr-2"></i>Tambah Departemen Baru</a>
    </div>
    <div>
      @foreach ($departemens as $departemen)
        <a href="{{ route('departemen.edit', $departemen->kode) }}" class="btn btn-secondary">{{ $departemen->nama }}</a>
      @endforeach
    </div>
  </div>
</div>
@endsection