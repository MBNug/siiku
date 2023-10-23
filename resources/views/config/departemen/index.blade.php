@extends('layouts.admin')

@section('title', 'Departemen Fakultas Sains dan Matematika')

@section('content')
<div class="container">
  <!-- Page Heading -->
  <section class="content-header">
    <div style="display: flex;flex-direction:row;justify-content:space-between">
      <h1 class="h3 mb-4 text-primary">Departemen Fakultas Sains dan Matematika</h1>
      <a href="{{ route('departemen.create') }}" class="btn btn-primary mb-3 px-10"><i class="fa fa-plus mr-2"></i>Tambah Departemen Baru</a>
    </div>
  </section>
  <div class="container" style="display: flex;flex-direction:column;padding-left: 0px">
    @foreach ($departemens as $departemen)
      <a style="width:75%;text-align:left;margin-bottom: 15px;background-color:#f8f9fa;padding:20px;color:#213f76;font-size:20px;border-width:2px;border-color:#b5b5b5" href="{{ route('departemen.edit', $departemen->kode) }}" class="btn">Departemen {{ $departemen->nama }}</a>
    @endforeach
  </div>
</div>
@endsection