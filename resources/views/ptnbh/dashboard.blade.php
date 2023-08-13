{{-- @dd($departemens) --}}
@extends('layouts.admin')

@section('title', 'Target Departemen Informatika')
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
            <div class="container">
                <div class="card mt-4" style="padding: 10px;border-width:1px;border-color:#ececec;background-color:#f8f9fa">
                    <div class="card-body">        
                        <h3 style="color:#17356d">Ketercapaian Target IKU Fakultas</h3>
                        <br>
                        <div class="container" style="display: flex; flex-direction:row">
                            <canvas id="KetercapaianFSM" style="height: 250px;width:300px"></canvas>
                            <div class="container" style="display: flex; flex-direction:column">
                                <div class="container mb-3" style="display: flex; flex-direction:row">
                                    <div class="container" >
                                        <div class="card" style="height:125px;background-color:#C51D1D; padding:10px">
                                            <h5 style="color: white">Tidak Tercapai</h5>
                                            <h2 style="color: white; text-align:center">{{$jmlrealisasis0}}</h2>
                                        </div>
                                    </div>
                                    <div class="container">
                                        <div class="card"style="height:125px;background-color:#1649A9; padding:10px ">
                                            <h5 style="color: white">Tercapai</h5>
                                            <h2 style="color: white; text-align:center">{{$jmlrealisasis1}}</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="container" style="display: flex; flex-direction:row">
                                    <div class="container">
                                        <div class="card"style="height:125px;background-color:#20942C; padding:10px ">
                                            <h5 style="color: white">Melampaui</h5>
                                            {{-- <br> --}}
                                            <h2 style="color: white; text-align:center">{{$jmlrealisasis2}}</h2>
                                        </div>
                                    </div>
                                    <div class="container">
                                        <div class="card"style="height:125px;background-color:#FFA800; padding:10px ">
                                            <h5 style="color: white">Sedang diproses</h5>
                                            <h2 style="color: white; text-align:center">{{$jmlrealisasis3}}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container" style="padding: 0px;display: flex; flex-direction:row;margin:auto;">
                    <div class="card mt-3" style="width:60%;margin-right: 15px;padding: 10px;border-width:1px;border-color:#ececec;background-color:#f8f9fa">
                        <div class="card-body">
                            <h4 style="color:#17356d">Jumlah Target yang Telah Disetujui</h4>
                            <div class="table-responsive">
                                <table class="table table-hover datatable">
                                    <thead>
                                        <tr style="background-color: #17356d;color:white">
                                            <th>Departemen</th>
                                            <th>Tidak Tercapai</th>
                                            <th>Tercapai</th>
                                            <th>Melampaui</th>
                                            <th>Sedang Diproses</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($ketercapaiantargetdept as $satuan)
                                            <tr >
                                                <td><a style="text-decoration:none" href="{{ route('renstra.realisasidepartemen',$satuan['kode']) }}" target="_blank" >{{$satuan['departemen']}}</a></td>
                                                <td>{{$satuan['0']}}</td>
                                                <td>{{$satuan['1']}}</td>
                                                <td>{{$satuan['2']}}</td>
                                                <td>{{$satuan['3']}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>            
                        </div>
                    </div>
                    <div class="card mt-3" style="width:40%;margin-right: 15px;padding: 10px;border-width:1px;border-color:#ececec;background-color:#f8f9fa">
                        <div class="card-body">
                            <h4 style="color:#17356d">Realisasi yang Belum Divalidasi</h4>
                            <div class="table-responsive">
                                <table class="table table-hover datatable">
                                    <thead>
                                        <tr style="background-color: #17356d;color:white">
                                            <th>Departemen</th>
                                            <th>jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($RealisasiUncheck as $satuan)
                                            <tr>
                                                <td><a style="text-decoration:none" href="{{ route('renstra.realisasidepartemen',$satuan['kode']) }}" target="_blank" >{{$satuan['departemen']}}</a></td>
                                                <td>{{$satuan['jumlah']}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>            
                        </div>
                    </div>
                </div>
                {{-- {{dd($targetmenunggupersetujuan)}} --}}
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



            </div>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                var ctx0 = document.getElementById("KetercapaianFSM");
                var ketercapaianFSM = new Chart(ctx0, {
                    type: 'doughnut',
                    data: {
                        labels: ['Tidak Tercapai','Tercapai','Melampaui','Sedang Diproses'],
                        datasets: [{
                            label: ' Indikator',
                            data: [{{$jmlrealisasis0}},{{$jmlrealisasis1}},{{$jmlrealisasis2}},{{$jmlrealisasis3}}],
                            backgroundColor: [
                                '#C51D1D',
                                '#1649A9',
                                '#20942C',
                                '#FFA800'
                            ],
                            borderColor: [
                                '#FFFFFF',
                                '#FFFFFF',
                                '#FFFFFF',
                                '#FFFFFF'
                            ],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        // cutoutPercentage: 40,
                        responsive: false,
                    }
                });
            
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
                            beginAtZero: true
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
                                // ticks: {
                                //     callback: function(value) {
                                //     return Math.ceil(value); // Use Math.ceil() to round up to the nearest integer
                                //     }
                                // }
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
                                // ticks: {
                                //     callback: function(value) {
                                //     return Math.ceil(value); // Use Math.ceil() to round up to the nearest integer
                                //     }
                                // }
                            }
                        }
                    }
                });
            </script>        
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

