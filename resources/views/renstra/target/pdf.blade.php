<!-- resources/views/pdf/custom_layout.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Download Target Renstra IKU FSM</title>
    <!-- Add Bootstrap CSS link here -->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="text-center">KONTRAK KINERJA RENSTRA TAHUN {{ $tahun[0] }}</h1>
        <h1 class="text-center">FAKULTAS SAINS DAN MATEMATIKA</h1>
        <h1 class="text-center pb-3">DEPARTEMEN {{ strtoupper($departemen->nama) }}</h1>


        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Strategi</th>
                    <th colspan="2">Indikator Kinerja</th>
                    <th>Satuan</th>
                    <th>Target Dep. {{ $departemen->nama }}</th>
                    <th>KET</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $barisstrategi = 1;
                    $barisindikator = 1;
                @endphp
                @foreach($combinedData as $index => $item)
                @foreach($item['indikators'] as $indikatorIndex => $indikator)
                <tr>
                    @if($indikatorIndex === 0)
                    <td rowspan="{{ count($item['indikators']) }}">{{ $barisstrategi }}</td>
                    <td rowspan="{{ count($item['indikators']) }}">{{ $item['strategi'] }}</td>
                    @endif
                    <td>{{ $barisindikator }}</td>
                    <td>{{ $indikator}}</td>
                    <td>{{ $item['satuans'][$indikatorIndex] }}</td>
                    <td>{{ $item['targets'][$indikatorIndex] }}</td>
                    <td>@if($item['keterangans'][$indikatorIndex] == null) 
                        - 
                        @else 
                        {{ $item['keterangans'][$indikatorIndex] }} 
                        @endif
                    </td>
                </tr>
                @php
                    $barisindikator +=1;
                @endphp
                @endforeach
                @php
                    $barisstrategi +=1;
                @endphp
                @endforeach
            </tbody>
        </table>

        <div class="row py-3">
            <div class="col-8 text-start">
                <p>Dekan Fakultas Sains dan Matematika</p>
                <img src="{{ Storage::url($pejabatFak->tandatangan) }}" alt="Left Signature" class="img-fluid w-25">
                <p>{{ $pejabatFak->nama }}</p>
                <p>NIP. {{ $pejabatFak->nip }}</p>
            </div>
            <div class="col-4">
                <p>{{ $pejabatDep->jabatan }}</p>
                <img src="{{ Storage::url($pejabatDep->tandatangan) }}" alt="Right Signature" class="img-fluid w-25">
                <p>{{ $pejabatDep->nama }}</p>
                <p>NIP. {{ $pejabatDep->nip }}</p>
            </div>
        </div>
    </div>

    <!-- Add Bootstrap JS script here -->
    <script src="{{ asset('assets/bootstrap.js') }}"></script>
</body>
</html>
