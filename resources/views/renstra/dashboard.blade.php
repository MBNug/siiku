@extends('layouts.admin')

{{-- @section('title', ''.$title) --}}

@section('csslocal')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endsection
{{-- {{dd($jmlindikator)}} --}}
@if($err=='0')
    {{-- Departemen --}}
    @if($user->level==2)
        @section('content')
            <div id="dashboard" class="container">
                <h3 style="text-align: center">Dashboard Renstra Fakultas Sains dan Matematika</h3>
                <hr>
                <div class="container" style="padding: 0%;display:flex;justify-content:space-between">
                    <div class="card" style="width: 24%">
                        <div class="card-header">
                            <h4>Tahun Aktif</h4>
                        </div>
                        <div class="card-body" style="display: flex;align-items:center;justify-content:flex-end">
                            <h4 style="text-align: right">{{$actConfig->tahun}}</h4>
                        </div>
                    </div>
                    <div class="card" style="width: 24%">
                        <div class="card-header">
                            <h4>Triwulan</h4>
                        </div>
                        <div class="card-body" style="display: flex;align-items:center;justify-content:flex-end">
                            {{-- @dd($indikator); --}}
                            @if($triwulan->triwulan==0 )
                                <h4 style="text-align: right">Periode Selesai </h4>
                            @else
                                <h4 style="text-align: right">{{$triwulan->triwulan}}</h4>
                            @endif
                        </div>
                    </div>
                    <div class="card" style="width: 49%">
                        <div class="card-header">
                            <h4>Aktivitas Berlangsung</h4>
                        </div>
                        <div class="card-body">
                @if($indikator==0 && $jmlrealisasi==0)
                            <h4>Pengaturan Indikator IKU Oleh Fakultas</h4>
                        </div>
                    </div>
                </div>
                <div class="card mt-3 mb-3" style="width:100%;margin-right: 15px;padding: 20px;border-width:1px;border-color:#ececec;background-color:#f8f9fa;display: flex;justify-content: center;align-items: center;">
                    <h4 style="color: #17356d;text-align:center">Indikator Tahun {{$actConfig->tahun}} Belum diatur</h4>
                </div>
                @else
                    @if($jmltarget==0)
                        <h4>Pembentukan Target oleh Fakultas</h4>
                        </div>
                    </div>
                </div>
                <div class="card mt-3 mb-3" style="width:100%;margin-right: 15px;padding: 20px;border-width:1px;border-color:#ececec;background-color:#f8f9fa;display: flex;justify-content: center;align-items: center;">
                    <h4 style="color: #17356d;text-align:center">Target Tahun {{$actConfig->tahun}} Belum diatur</h4>
                </div>   
                    @else
                        @if($jmlbelumdisetujui!=0)
                            <h4>Pengisian Target Oleh Fakultas</h4>
                        </div>
                    </div>
                </div> 
                <div class="card mt-3 mb-3" style="width:100%;margin-right: 15px;padding: 20px;border-width:1px;border-color:#ececec;background-color:#f8f9fa;display: flex;justify-content: center;align-items: center;">
                    <h4 style="color: #17356d;text-align:center">Target Tahun {{$actConfig->tahun}} sedang diproses</h4>
                </div> 
                        @else
                            @if($jmltriwulan1==0 && $check==0 && $jmlrealisasi==0)
                            <h4>Pembentukan Realisasi oleh Fakultas</h4>
                        </div>
                    </div>
                </div>
                <div class="card mt-3 mb-3" style="width:100%;margin-right: 15px;padding: 20px;border-width:1px;border-color:#ececec;background-color:#f8f9fa;display: flex;justify-content: center;align-items: center;">
                    <h4 style="color: #17356d;text-align:center">Data Realisasi Tahun {{$actConfig->tahun}} sedang dibuat</h4>
                </div>   
                            @else
                                @if($triwulan->triwulan==0)
                                    
                            <h4>Periode IKU tahun 2023 telah selesai</h4>
                        </div>
                    </div>
                </div>
                <div class="card mt-3 mb-3" style="width:100%;margin-right: 15px;padding: 20px;border-width:1px;border-color:#ececec;background-color:#f8f9fa;display: flex;justify-content: center;align-items: center;">
                    <h4 style="color: #17356d;text-align:center">Waktu Pengisian Realisasi tahun {{$actConfig->tahun}} Telah Selesai</h4>
                    <a href="{{ route('renstra.realisasidepartemen', [$kode, $triwulan->triwulan]) }}" class="btn btn-primary mt-2 mb-1 px-10">Lihat Data Realisasi IKU Tahun {{$actConfig->tahun}}</a>
                </div>
                                @else    
                            <h4>Pengisian Realisasi Oleh Fakultas dan Departemen</h4>
                        </div>
                    </div>
                </div>
                                
                                <div class="card mt-3" style="border-width:1px;border-color:#ececec;background-color:#f8f9fa;display: flex;flex-direction:column">
                                    <div class="container" style="padding:15px;display: flex;justify-content: center;align-items: center;">
                                        <h4 style="color: #17356d;text-align:center">Monitoring Ketercapaian Target IKU Tahun {{$actConfig->tahun}}</h4>
                                        
                                    </div>
                                    <div style="display: flex;flex-direction:row">
                                        <div style="display: flex;flex-direction:column;width: 70%;">
                                            <div style="width: 100%; height: 320px;padding:17px;display:flex;justify-items:center;align-items:center">
                                                <canvas id="ChartDept" style="width: 100%;height:100%"></canvas>
                                            </div>
                                        </div>
                                        <div class="container" style="padding: 15px">
                                            <div class="table-responsive">
                                                <table class="table table-hover datatable">
                                                    <thead>
                                                        <tr style="background-color: #17356d;color:#ececec;text-align: center;vertical-align: middle;">
                                                            <th>Triwulan</th>
                                                            <th>Melampaui</th>
                                                            <th>Tercapai</th>
                                                            <th>Tidak Tercapai</th>
                                                            <th>Menunggu Penilaian</th>
                                                            <th>Belum diupdate</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        {{-- {{dd($ketercapaiantargetdept)}} --}}
                                                        @foreach ($ketercapaiantargetdept as $satuan)
                                                            <tr style="text-align: center">
                                                                <td><a style="text-decoration:none" href="{{route('renstra.realisasidepartemen', [substr($user->kode, 0, 2), $triwulan->triwulan] )}}" target="_blank" >{{$satuan['triwulan']}}</a></td>
                                                                <td>{{$satuan['0']}}</td>
                                                                <td>{{$satuan['1']}}</td>
                                                                <td>{{$satuan['2']}}</td>
                                                                <td>{{$satuan['3']}}</td>
                                                                <th>{{$satuan['4']}}</th>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                <script>
                                    // Sample dynamic data and labels (replace this with your actual data and labels)
                                    let triwuland = {{ Js::from($triwulanY) }};
                                    
                                    // Get the canvas element and create the chart
                                    let ketercapaianpertriwulan = {{ Js::from($ketercapaianpertriwulan) }};
                                    const ctx1 = document.getElementById('ChartDept');
                                    const ChartDept1 = new Chart(ctx1, {
                                        type: 'bar',
                                        data: {
                                            labels: triwuland,
                                            datasets: [{
                                                label: ' Indikator Tercapai & Melampaui',
                                                data: ketercapaianpertriwulan,
                                                backgroundColor: '#17356d',
                                                borderColor: '#071632',
                                                borderWidth: 1
                                            }]
                                        },
                                        options: {
                                            // maintainAspectRatio: false,
                                            scales: {
                                                y: {
                                                    beginAtZero: true,
                                                    suggestedMax: {{$indikator}},
                                                    ticks: {
                                                            stepSize: 1, // Set the interval between ticks
                                                            precision: 0 // Display integer values (no decimal places)
                                                    }
                                                }
                                            }
                                        }
                                    });
                                </script>
                                @endif
                            @endif
                        @endif  
                    @endif
                @endif
            </div>
        @endsection
    {{-- fakultas --}}
    @else
        @section('content')
            <div id="dashboard" class="container">
                <h3 style="text-align: center">Dashboard Renstra Fakultas Sains dan Matematika</h3>
                <hr>
                @if($jmlbelumdisetujui==0 && $jmlindikator!=0)
                    @if($jmltriwulan1==0 && $check==0 )
                        <div class="container" style="padding: 0%;display:flex;justify-content:space-between">
                            <div class="card" style="width: 24%">
                                <div class="card-header">
                                    <h4>Tahun Aktif</h4>
                                </div>
                                <div class="card-body">
                                    <h4 style="text-align: right">{{$actConfig->tahun}}</h4>
                                </div>
                            </div>
                            <div class="card" style="width: 24%">
                                <div class="card-header">
                                    <h4>Triwulan</h4>
                                </div>
                                <div class="card-body">
                                    <h4 style="text-align: right">1</h4>
                                </div>
                            </div>
                            <div class="card" style="width: 49%">
                                <div class="card-header">
                                    <h4>Aktivitas Berlangsung</h4>
                                </div>
                                <div class="card-body">
                                    <h4 style="text-align: right">Pembentukan Data Realisasi oleh Fakultas</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3 mb-3" style="width:100%;margin-right: 15px;padding: 20px;border-width:1px;border-color:#ececec;background-color:#f8f9fa;display: flex;justify-content: center;align-items: center;">
                            <h4 style="color: #17356d;text-align:center">Data Realisasi Tahun {{$actConfig->tahun}} Belum dibuat</h4>
                            <a href="{{ route('renstra.realisasi.index') }}" class="btn btn-primary mt-2 mb-1 px-10">Buat Data Realisasi IKU Tahun {{$actConfig->tahun}}</a>
                        </div>
                    @else
                        <div class="container" style="padding: 0%;display:flex;justify-content:space-between">
                            <div class="card" style="width: 24%">
                                <div class="card-header">
                                    <h4>Tahun Aktif</h4>
                                </div>
                                <div class="card-body">
                                    <h4 style="text-align: right">{{$actConfig->tahun}}</h4>
                                </div>
                            </div>
                            <div class="card" style="width: 24%">
                                <div class="card-header">
                                    <h4>Triwulan</h4>
                                </div>
                                <div class="card-body">
                                    @if($triwulan->triwulan==0 && $check==1)
                                    <h4 style="text-align: right">Periode Selesai </h4>
                                    @else
                                    <h4 style="text-align: right">{{$triwulan->triwulan}}</h4>
                                    @endif
                                </div>
                            </div>
                            <div class="card" style="width: 49%">
                                <div class="card-header">
                                    <h4>Aktivitas Berlangsung</h4>
                                </div>
                                <div class="card-body">
                                    @if($triwulan->triwulan==0 && $check==1)
                                    <h4 style="text-align: right">Periode IKU tahun {{$actConfig->tahun}} telah selesai</h4>
                                    @else
                                    <h4 style="text-align: right">Pengisian Realisasi oleh Departemen & Fakultas</h4>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3" style="border-width:1px;border-color:#ececec;background-color:#f8f9fa;display: flex;flex-direction:column">
                            <div class="container" style="padding:15px;display: flex;justify-content: center;align-items: center;">
                                @if($check==0)
                                <h4 style="color: #17356d;text-align:center">Monitoring Ketercapaian Target IKU Triwulan {{$triwulan->triwulan}}</h4>
                                @else
                                <h4 style="color: #17356d;text-align:center">Ketercapaian Target IKU FSM Tahun {{$actConfig->tahun}}</h4>
                                @endif
                            </div>
                            <div style="display: flex;flex-direction:row">
                                <div style="display: flex;flex-direction:column;width: 70%;">
                                    @if($check==0)
                                    <form action="{{ route('renstra.dashboard.filter') }}" method="GET">
                                        <div style="display: flex;justify-content:flex-start;padding-left:10px">
                                            <select name="triwulan">
                                                <option value="" selected disabled>Ganti Triwulan</option>
                                                <option value="1">Triwulan 1</option>
                                                <option value="2">Triwulan 2</option>
                                                <option value="3">Triwulan 3</option>
                                                <option value="4">Triwulan 4</option>
                                            </select>
                                            <button style="margin-left: 10px" type="submit" class="btn btn-primary ">Ganti</button>
                                        </div>
                                    </form>
                                    @endif
                                    <div style="width: 100%; height: 320px;padding:17px;display:flex;justify-items:center;align-items:center">
                                        <canvas id="Chart1" style="width: 100%;height:100%"></canvas>
                                    </div>
                                </div>
                                <div class="container" style="padding: 15px">
                                    <div class="table-responsive">
                                        <table class="table table-hover datatable">
                                            <thead>
                                                <tr style="background-color: #17356d;color:#ececec;text-align: center;     vertical-align: middle;">
                                                    <th>Departemen</th>
                                                    <th>Melampaui</th>
                                                    <th>Tercapai</th>
                                                    <th>Tidak Tercapai</th>
                                                    <th>Menunggu Penilaian</th>
                                                    <th>Belum diupdate</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- {{dd($ketercapaiantargetdept)}} --}}
                                                @foreach ($ketercapaiantargetdept as $satuan)
                                                    <tr style="text-align: center">
                                                        <td style="text-align:left;"><a style="text-decoration:none" href="{{route('renstra.realisasidepartemen', [$satuan['kode'], $triwulan->triwulan] )}}" target="_blank" >{{$satuan['departemen']}}</a></td>
                                                        <td>{{$satuan['0']}}</td>
                                                        <td>{{$satuan['1']}}</td>
                                                        <td>{{$satuan['2']}}</td>
                                                        <td>{{$satuan['3']}}</td>
                                                        <th>{{$satuan['4']}}</th>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>    
                        </div>
                        <div class="card mt-3 mb-3" style="width:100%;margin-right: 15px;padding: 20px;border-width:1px;border-color:#ececec;background-color:#f8f9fa;display: flex;justify-content: center;align-items: center;">
                            <h4 style="color: #17356d;text-align:center">Target tahun {{$actConfig->tahun}} untuk setiap departemen telah disetujui</h4>
                            <a target="_blank" href="{{ route('renstra.target.index') }}" class="btn btn-primary mt-2 mb-1 px-10">Lihat Data Target IKU Tahun {{$actConfig->tahun}}</a>
                        </div>
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                            // Sample dynamic data and labels (replace this with your actual data and labels)
                            let namadept = {{ Js::from($namadept) }};
                            
                            // Get the canvas element and create the chart
                            let ketercapaianpertriwulan = {{ Js::from($ketercapaianpertriwulan) }};
                            const ctx1 = document.getElementById('Chart1');
                            const ChartTarget1 = new Chart(ctx1, {
                                type: 'bar',
                                data: {
                                    labels: namadept,
                                    datasets: [{
                                        label: ' Indikator Tercapai & Melampaui',
                                        data: ketercapaianpertriwulan,
                                        backgroundColor: '#17356d',
                                        borderColor: '#071632',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    // maintainAspectRatio: false,
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            suggestedMax: {{$indikator}},
                                            ticks: {
                                                    stepSize: 1, // Set the interval between ticks
                                                    precision: 0 // Display integer values (no decimal places)
                                            }
                                        }
                                    }
                                }
                            });
                        </script>
                    @endif
                @else
                    <div class="container" style="padding: 0%;display:flex;justify-content:space-between">
                        <div class="card" style="width: 24%">
                            <div class="card-header">
                                <h4>Tahun Aktif</h4>
                            </div>
                            <div class="card-body">
                                <h4 style="text-align: right">{{$actConfig->tahun}}</h4>
                            </div>
                        </div>
                        <div class="card" style="width: 24%">
                            <div class="card-header">
                                <h4>Triwulan</h4>
                            </div>
                            <div class="card-body">
                                <h4 style="text-align: right">{{$triwulan->triwulan}}</h4>
                            </div>
                        </div>
                            
                    @if($indikator==0 && $jmlrealisasi==0)
                            <div class="card" style="width: 49%">
                                <div class="card-header">
                                    <h4>Aktivitas Berlangsung</h4>
                                </div>
                                <div class="card-body">
                                    <h4>Pengaturan Indikator IKU oleh Fakultas</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3 mb-3" style="width:100%;margin-right: 15px;padding: 20px;border-width:1px;border-color:#ececec;background-color:#f8f9fa;display: flex;justify-content: center;align-items: center;">
                            <h4 style="color: #17356d;text-align:center">Indikator Tahun {{$actConfig->tahun}} Belum diatur</h4>
                            @if($user->level == 1)
                            <a href="{{ route('config.index') }}" class="btn btn-primary mt-2 mb-1 px-10">Atur Indikator IKU Tahun {{$actConfig->tahun}}</a>
                            @endif
                        </div>
                    
                    @else
                        @if($jmltarget==0)
                        <div class="card" style="width: 49%">
                            <div class="card-header">
                                <h4>Aktivitas Berlangsung</h4>
                            </div>
                            <div class="card-body">
                                <h4>Pembentukan Target oleh Fakultas</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3 mb-3" style="width:100%;margin-right: 15px;padding: 20px;border-width:1px;border-color:#ececec;background-color:#f8f9fa;display: flex;justify-content: center;align-items: center;">
                        <h4 style="color: #17356d;text-align:center">Target Tahun {{$actConfig->tahun}} Belum diatur</h4>
                        @if($user->level == 1)
                        <a href="{{ route('renstra.target.index') }}" class="btn btn-primary mt-2 mb-1 px-10">Atur Target IKU Tahun {{$actConfig->tahun}}</a>
                        @endif
                    </div>
                        @else
                        <div class="card" style="width: 49%">
                            <div class="card-header">
                                <h4>Aktivitas Berlangsung</h4>
                            </div>
                            <div class="card-body">
                                <h4>Pengisian Target IKU oleh Fakultas</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3 mb-3" style="width:100%;margin-right: 15px;padding: 10px;border-width:1px;border-color:#ececec;background-color:#f8f9fa">
                        <div class="carousel-container">
                            <div class="carousel-wrapper">
                                <div class="carousel-slide">
                                        <h4 style="color:#17356d">Jumlah Target yang Telah Disetujui</h4>
                                        <div style="width: 56%; height: 300px">
                                            <canvas id="ChartTarget1" style="width: 56%; height: 300px"></canvas>
                                        </div>
                                    {{-- </div> --}}
                                </div>
                                <div class="carousel-slide">
                                    {{-- <div class="card-body"> --}}
                                        <h4 style="color:#17356d">Jumlah Target yang Ditolak</h4>
                                        <div style="width: 56%; height: 300px">
                                            <canvas id="ChartTarget2" style="width: 56%; height: 300px"></canvas>
                                        </div>
                                    {{-- </div> --}}
                                </div>
                                <div class="carousel-slide">
                                    {{-- <div class="card-body"> --}}
                                        <h4 style="color:#17356d">Jumlah Target yang Menunggu Persetujuan</h4>
                                        <div style="width: 56%; height: 300px">
                                            <canvas id="ChartTarget3" style="width: 56%; height: 300px"></canvas>
                                        </div>
                                    {{-- </div> --}}
                                </div>
                            </div>
                        </div>
                        <div style="display: flex; margin-top:10px; justify-content: space-between;">
                            <button class="btn btn-primary" onclick="prevSlide()">Previous</button>
                            <button class="btn btn-primary" onclick="nextSlide()">Next</button> 
                        </div>
                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        const carouselWrapper = document.querySelector('.carousel-wrapper');
                        const prevButton = document.querySelector('button[onclick="prevSlide()"]');
                        const nextButton = document.querySelector('button[onclick="nextSlide()"]');
                        const slideWidth = carouselWrapper.clientWidth; // Use the parent width for slide width

                        let slideIndex = 0;

                        function showSlide(index) {
                            const offset = -index * slideWidth;
                            carouselWrapper.style.transform = `translateX(${offset}px)`;
                        }

                        function prevSlide() {
                            slideIndex = (slideIndex - 1 + 3) % 3; // 3 is the total number of slides
                            showSlide(slideIndex);
                        }

                        function nextSlide() {
                            slideIndex = (slideIndex + 1) % 3; // 3 is the total number of slides
                            showSlide(slideIndex);
                        }

                        // Adjust slide width on parent resize
                        window.addEventListener('resize', () => {
                            slideWidth = carouselWrapper.clientWidth;
                            showSlide(slideIndex);
                        });

                        // Sample dynamic data and labels (replace this with your actual data and labels)
                        let namadept = {{ Js::from($namadepartemen) }};
                        
                        // Get the canvas element and create the chart
                        let targetdisetujui = {{ Js::from($targetdisetujui) }};
                        const ctx1 = document.getElementById('ChartTarget1');
                        const ChartTarget1 = new Chart(ctx1, {
                            type: 'bar',
                            data: {
                            labels: namadept,
                            datasets: [{
                                label: ' Indikator',
                                data: targetdisetujui,
                                backgroundColor: '#17356d',
                                borderColor: '#071632',
                                borderWidth: 1
                            }]
                            },
                            options: {
                                // maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        suggestedMax: {{$indikator}},
                                        ticks: {
                                                stepSize: 1, // Set the interval between ticks
                                                precision: 0 // Display integer values (no decimal places)
                                        }
                                    }
                                }
                            }
                        });

                        // Get the canvas element and create the chart
                        let targetditolak = {{ Js::from($targetditolak) }};
                        const ctx2 = document.getElementById('ChartTarget2');
                        const ChartTarget2 = new Chart(ctx2, {
                            type: 'bar',
                            data: {
                            labels: namadept,
                            datasets: [{
                                label: ' Indikator',
                                data: targetditolak,
                                backgroundColor: '#17356d',
                                borderColor: '#071632',
                                borderWidth: 1
                            }]
                            },
                            options: {
                                // maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        suggestedMax: {{$indikator}},
                                        ticks: {
                                            stepSize: 1, // Set the interval between ticks
                                            precision: 0 // Display integer values (no decimal places)
                                        }
                                    }
                                }
                            }
                        });

                        // Get the canvas element and create the chart
                        let targetmenunggupersetujuan = {{ Js::from($targetmenunggupersetujuan) }};
                        const ctx3 = document.getElementById('ChartTarget3');
                        const ChartTarget3 = new Chart(ctx3, {
                            type: 'bar',
                            data: {
                            labels: namadept,
                            datasets: [{
                                label: ' Indikator',
                                data: targetmenunggupersetujuan,
                                backgroundColor: '#17356d',
                                borderColor: '#071632',
                                borderWidth: 1
                            }]
                            },
                            options: {
                                // maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        suggestedMax: {{$indikator}},
                                        ticks: {
                                            stepSize: 1, // Set the interval between ticks
                                            precision: 0 // Display integer values (no decimal places)
                                        }
                                    }
                                }
                            }
                        });
                    </script>
                        @endif
                    @endif
                @endif
            </div> 
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
