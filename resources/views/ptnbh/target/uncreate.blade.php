@extends('layouts.admin')

@section('title', ''.$title)

@section('csslocal')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endsection

@section('content')
<div class="container" style="height: 100vh;margin-top:30px;">
    <!-- Page Heading -->
    <div class="card shadow mb-4">
        <div class="card-body"style="height: 80vh;display: flex;
        flex-direction: column;justify-content:center;align-items:center;" >
            <h4>@yield('title') belum tersedia, Silahkan buat target dengan mengklik tombol dibawah.</h4>
            <a href="{{ route('ptnbh.target.store', $ptnbhdept) }}" class="btn btn-primary mb-3 px-10"><i class="fa fa-plus mr-2"></i> Buat Target Baru</a>
        </div>
    </div>
</div>
@endsection

{{-- @section('scriptlocal') --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
    $('#date-tahun').datepicker({
        minViewMode: "years",
        format: "yyyy",
        viewMode: "years",
        autoclose: true
    });

    $('#indikator_kinerja').change(function(){
        $.ajax({
            url: '/renstra/indikators/' + $(this).val(),
            type: 'get',
            data: {},
            success: function(data) {
                if (data.success == true) {
                    $("#definisi").val(data.definisi);
                    $("#cara_perhitungan").val(data.cara_perhitungan);
                    $("#satuan").val(data.satuan);
                    $("#keterangan").val(data.keterangan);
                } else {
                    alert('Cannot find info');
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Exception:', exception);
            }
        });
    });

    $('#strategi').change(function(){
        // Empty the dropdown
        $('#indikator_kinerja').find('option').not(':first').remove();
        $.ajax({
            url: '/renstra/strategis/' + $(this).val(),
            type: 'get',
            dataType: 'json',
            data: {},
            success: function(response) {
                if(response['data'] != null){
                    len = response['data'].length;
                    for(var i=0; i<len; i++){

                        var id = response['data'][i].kode;
                        var name = response['data'][i].indikator_kinerja;

                        var option = new Option(name, id); 

                        $("#indikator_kinerja").append($(option)); 
                    }
                }
                else{
                    alert('Cannot find info');
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Exception:', exception);
            }
        });
    });
</script> --}}


{{-- @endsection --}}
