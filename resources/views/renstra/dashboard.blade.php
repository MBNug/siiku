@extends('layouts.admin')

@section('title', ''.$title)

@section('csslocal')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endsection

@if($err=='0')
    {{-- Departemen --}}
    @if($user->level==2)
        @section('content')
            <div id="dashboard" class="container">
                departemen 
            </div>
        @endsection
    {{-- fakultas --}}
    @else
        @section('content')
        {{-- @dd($targetapproved) --}}
            Fakultas        
        @endsection
    @endif
@else
    @section('content')
    <div id="dashboard" class="container">
        <div style="display: flex;justify-content: center;align-items:center;height:80vh">
            <div class="card shadow" style="padding: 70px;background-color:#f8f9fa;border-width:5px;border-color:#ececec;">
                <h3 style="color:#17356d">Config Tahun Belum diatur</h3>
                @if($user->level==1)
                    <div style="display: flex;justify-content: center;align-items:center;">
                        <a style="padding: 15px" href="{{ route('config.index') }}" class="btn btn-primary mt-3"><h5>Set Config Tahun</h5></a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endsection
@endif
