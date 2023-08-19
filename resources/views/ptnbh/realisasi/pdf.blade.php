<!-- resources/views/pdf/custom_layout.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title> Download IKU PTNBH FSM Departemen {{ $departemen->nama }}</title>
    
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
    <div class="container">
        <p style="
            text-align: center;
            font-weight: bold;
            ">
            KONTRAK KINERJA PTNBH TAHUN {{ $tahun[0] }}
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
                <tr>
                    <th>No</th>
                    <th style="width: 4cm">Strategi</th>
                    <th colspan="2">Indikator Kinerja</th>
                    <th>Satuan</th>
                    <th colspan="1">Target Dep. {{ $departemen->nama }}</th>
                    <th style="width: 2cm">KET</th>
                    <th style="width: 2cm">Ketercapaian</th>
                    <th style="width: 2cm">Nilai Real</th>
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
                    <td style="
                    text-align: center
                    ">{{ $item['ketercapaians'][$indikatorIndex] }}</td>
                    <td style="
                    text-align: center
                    ">{{ $item['nilaireals'][$indikatorIndex] }}</td>
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
