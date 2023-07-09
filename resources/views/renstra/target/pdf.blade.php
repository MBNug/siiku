<!-- resources/views/pdf/custom_layout.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title> Download Renstra IKU FSM Departemen {{ $departemen->nama }}</title>
    
    <style>
        @page {
            size: A4;
            margin: 1cm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
        }
        .container {
            margin: 20px;
            margin-left: 1cm;
            margin-right: 1cm;
        }
        .table {
            padding-top: 1cm;
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;
            overflow: visible !important; 
            /* break-inside: avoid;
            page-break-inside: avoid !important;
            page-break-before: auto !important;
            page-break-after: auto !important; */
        }
        /* div.page
        {
            page-break-after: always;
            page-break-inside: avoid;
        } */
        /* .table thead{
            display: table-header-group;
            break-inside: avoid;
            page-break-inside: avoid;
        } */
        .table th,
        .table td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 10px;
        }
        .table td{
            /* page-break-inside: avoid !important;
            page-break-before: auto !important; */
        }
        thead { display: table-header-group }
        tfoot { display: table-row-group }
        tr { page-break-inside: avoid }
        .table th {
            font-weight: bold;
            background-color: #f2f2f2;
        }
        .no-border{
            border: none !important;
        }
        .footer-repeat {
            display: table-footer-group;
        }
        .signature-container {
            display: -webkit-box;
            -webkit-box-pack: justify;
            margin-top: 20px;
        }
        .signature {
            width: 250px;
            height: 60px;
            font-size: 14px;
        }
        .signature img {
            display: block;
            height: 50px;
            margin: 0;
            background-color: #fff;
            /* margin-bottom: 10px; */
        }
    </style>
</head>
<body>
    {{-- <div class="container">
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
    </div> --}}
    <div class="container">
        <p style="
            text-align: center;
            font-weight: bold;
            ">
            KONTRAK KINERJA RENSTRA TAHUN {{ $tahun[0] }}
        </p>
        <p style="
            text-align: center;
            font-weight: bold;
            ">
            FAKULTAS SAINS DAN MATEMATIKA
        </p>
        <p style="
            text-align: center;
            font-weight: bold;
            ">DEPARTEMEN {{ strtoupper($departemen->nama) }}
        </p>


        <table class="table">
            <thead>
                {{-- <tr class="no-border">
                    <td class="no-border">&nbsp;</td>
                 </tr>
                  <!-- add extra space for printing -->
                 <tr class="no-border">
                    <td class="no-border">&nbsp;</td>
                 </tr>
                 <!-- add extra space for printing --> --}}
                <tr>
                    <th>No</th>
                    <th style="width: 4cm">Strategi</th>
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
                {{-- <tr> --}}
                    @if($indikatorIndex === 0)
                    <td rowspan="{{ count($item['indikators']) }}">{{ $barisstrategi }}</td>
                    <td rowspan="{{ count($item['indikators']) }}">{{ $item['strategi'] }}</td>
                    @endif
                    <td>{{ $barisindikator }}</td>
                    <td>{{ $indikator}}</td>
                    <td style="
                    text-align: center;
                    width: 15px
                    " >{{ $item['satuans'][$indikatorIndex] }}</td>
                    <td style="
                    text-align: center
                    ">{{ $item['targets'][$indikatorIndex] }}</td>
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

        <div class="signature-container">
            <div class="signature">
                <p>Dekan Fakultas Sains dan Matematika</p>
                <img src="{{ public_path('storage/'.$pejabatFak->tandatangan) }}" alt="Left Signature" >
                <p>{{ $pejabatFak->nama }}</p>
                <p>NIP. {{ $pejabatFak->nip }}</p>
            </div>
            <div class="signature">
                {{-- @dd(asset('storage/'.$pejabatDep->tandatangan)) --}}
                {{-- @dd(Storage::url($pejabatDep->tandatangan)) --}}
                {{-- @dd(public_path('storage/'.$pejabatDep->tandatangan) ) --}}
                <p>{{ $pejabatDep->jabatan }}</p>
                <img src="{{ public_path('storage/'.$pejabatDep->tandatangan) }}" alt="Right Signature" >
                <p>{{ $pejabatDep->nama }}</p>
                <p>NIP. {{ $pejabatDep->nip }}</p>
            </div>
        </div>
    </div>
</body>
</html>
