@extends('layouts.admin')

@section('title', $title)

@section('content')

<div class="container">
    <section class="content-header">
        <div class="row">
            <div class="col-lg-9">
                <h1 class="h3 mb-4 text-primary">@yield('title')</h1>
            </div>
        </div>
    </section>
    <div class="card shadow mb-4">
        <div class="container mt-3 mb-2">
            <div class="row">
                <div class="col-2">
                    <p class="fw-bold text-primary">Strategi</p>
                </div>
                <div class="col-1">
                    <p class="fw-bold text-primary ps-5 ms-5">: </p>
                </div>
                <div class="col-8">
                    <p class="fw-bold text-primary">{{ $realisasi->strategi }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <p class="fw-bold text-primary">Indikator Kinerja</p>
                </div>
                <div class="col-1">
                    <p class="fw-bold text-primary ps-5 ms-5">: </p>
                </div>
                <div class="col-8">
                    <p class="fw-bold text-primary">{{ $realisasi->indikator_kinerja }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <p class="fw-bold text-primary">Definisi</p>
                </div>
                <div class="col-1">
                    <p class="fw-bold text-primary ps-5 ms-5">: </p>
                </div>
                <div class="col-8">
                    <p class="fw-bold text-primary">{{ $realisasi->definisi }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <p class="fw-bold text-primary">Cara Perhitungan</p>
                </div>
                <div class="col-1">
                    <p class="fw-bold text-primary ps-5 ms-5">: </p>
                </div>
                <div class="col-8">
                    <p class="fw-bold text-primary">{{ $realisasi->cara_perhitungan }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <p class="fw-bold text-primary">Satuan</p>
                </div>
                <div class="col-1">
                    <p class="fw-bold text-primary ps-5 ms-5">: </p>
                </div>
                <div class="col-8">
                    <p class="fw-bold text-primary">{{ $realisasi->satuan }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <p class="fw-bold text-primary">Keterangan</p>
                </div>
                <div class="col-1">
                    <p class="fw-bold text-primary ps-5 ms-5">: </p>
                </div>
                <div class="col-8">
                    <p class="fw-bold text-primary">@if ($realisasi->keterangan === null)
                        -
                        @else
                        {{ $realisasi->keterangan }}
                        @endif</p>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <p class="fw-bold text-primary">Target</p>
                </div>
                <div class="col-1">
                    <p class="fw-bold text-primary ps-5 ms-5">: </p>
                </div>
                <div class="col-8">
                    <p class="fw-bold text-primary">{{ $realisasi->target }}</p>
                </div>
            </div>
            @if ($user->level!=2)
                <div class="row">
                    <div class="col-2">
                        <p class="fw-bold text-primary">Nilai</p>
                    </div>
                    <div class="col-1">
                        <p class="fw-bold text-primary ps-5 ms-5">: </p>
                    </div>
                    <div class="col-8">
                        <p class="fw-bold text-primary">{{ $realisasi->nilai }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-2">
                        <p class="fw-bold text-primary">Bukti</p>
                    </div>
                    <div class="col-1">
                        <p class="fw-bold text-primary ps-5 ms-5">: </p>
                        
                    </div>
                    <div class="col-8">
                        {{-- @dd($files) --}}
                        @foreach ($files as $file)
                        
                            @if ($file)
                                <div class="col-8">
                                    <li class="list-group-item px-2">
                                        <a href="{{ Storage::url($file) }}" target="_blank"> {{ basename($file) }}</a>
                                    </li>
                                </div>
                                
                            @endif
                        @endforeach
                    </div>
                </div>

            @endif
            <div class="row">
                <div class="col">
                    <div class="bg-primary rounded-4 py-4">
                        @if ($user->level!=2)
                            <form action="{{ route('renstra.realisasi.simpan2',[$departemen->kode, $realisasi->kode]) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group row">
                                    <label class="col-3 col-form-label py-3 px-5 text-white fw-bold">Status*</label>
                                    <div class="col-7">
                                        <select name="status" id="status" class="col-7 form-control @error('status') is-invalid @enderror" placeholder="Status" value="{{ old('status', $realisasi->status) }}" required>
                                            <option value="Tidak Tercapai">Tidak Tercapai</option>
                                            <option value="Tercapai">Tercapai</option>
                                            <option value="Melampaui Target">Melampaui Target</option>
                                        </select>
                                        @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3 col-form-label py-3 px-5 text-white fw-bold">Nilai Realisasi*</label>
                                    <div class="col-7">
                                        <input type="text" class="form-control" name="nilaireal" placeholder="Nilai Realisasi" required value="{{ old('nilaireal', $realisasi->nilaireal) }}">
                                        @error('nilaireal')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group py-3 px-5">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-floppy-disk mr-2"></i> Simpan</button>
                                    <a href="{{ url()->previous() }}" id="back" class="btn btn-light"><i class="fa fa-times mr-2"></i> Batal</a>
                                </div>
                            </form>
                        @else
                            <form action="{{ route('renstra.realisasi.simpan',[$departemen->kode, $realisasi->kode]) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group row">
                                    <label class="col-3 col-form-label py-3 px-5 text-white fw-bold">Nilai*</label>
                                    <div class="col-7">
                                        <input type="text" class="form-control" name="nilai" placeholder="Nilai" required value="{{ old('nilai', $realisasi->nilai) }}">
                                        @error('nilai')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3 col-form-label pt-3 px-5 text-white fw-bold" for="files">Pilih File</label>
                                    <div class="col-7">
                                        <input type="file" name="files[]" id="files" class="form-control-file" multiple accept=".pdf,.xls,.xlsx">
                                    </div>
                                    <small class="px-5 form-text text-muted">(Maksimal 5 file, Tiap file maksimal 5MB,File yang diterima *.pdf, *.xls, *.xlsx)</small>
                                </div>
                                <div class="form-group row">
                                    <small class="px-5 form-text">File dipilih:</small>
                                    <ul id="fileDipilih" class="list-unstyled mt-2 mb-0 px-5 form-text"></ul>
                                </div>
                                <div class="form-group py-3 px-5">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-floppy-disk mr-2"></i> Simpan</button>
                                    <a href="{{ url()->previous() }}" id="back" class="btn btn-light"><i class="fa fa-times mr-2"></i> Batal</a>
                                </div>
                            </form>
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>
    
    </div>
</div>

@endsection

@section('scriptlocal')
<script>
    // Display selected file names
    document.getElementById('files').addEventListener('change', function(e) {
        var fileList = e.target.files;
        var fileNamesList = document.getElementById('fileDipilih');

        fileNamesList.innerHTML = '';

        for (var i = 0; i < fileList.length; i++) {
            var fileName = document.createElement('li');
            fileName.textContent = fileList[i].name;
            fileNamesList.appendChild(fileName);
        }
    });
</script>
@endsection