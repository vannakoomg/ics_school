@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
@endsection

@section('scripts')

<script>

  $(function() {

  $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
   });

  var table;
  var selectClassId=0;
  var selectCampus ='all';
  var html=$('.class-list');
  var date_fr = $('#date_fr').val();
  var date_to = $('#date_to').val();

   getClassList(selectCampus);

   table = $('.dlp-table').DataTable({
        "destroy": true,
        processing: true,
        serverSide: true,
        paging: false,
        ajax: {
            url:"{{ route('admin.dlp.getdlp') }}?campus=" + selectCampus + "&class_id=" + selectClassId + "&date_fr="+ date_fr + "&date_to="  + date_to ,
           // data: {'class_id':selectClassId},
        },
        select: false,
        columnDefs:[
            {
            'targets':[0],
            'visible':false,
            'searchable': false
            },
            {
            'targets':[5],
            'sortable':false,
            'searchable': false
            }
        ],
        order:[1,'desc'],
        columns: [
            {data: null,name:'index'},
            {data: 'created_date', name : 'created_at'},
            {data: 'class', name : 'class_id'},
            {data: 'problem_type', name : 'problem_type'},
            {data: 'problem', name : 'problem',width:'20%'},
            {data: 'full_path', name : 'full_path'},
            {data: 'solution', name : 'solution',width:'20%'},
            {data: 'status', name : 'status'},
            // {data: 'action', name : 'action'}
        ]
        });

     $('input[name="campus"]').on("click",function(){
        var campus=$(this).val();

        getClassList(campus);

     });   

     function getClassList(selectCampus){
        var lst_class = $('#lst_class');
        $.ajax({
            type: 'get',
            url : "{{ route('admin.dlp.getclass') }}",
            data: {'campus':selectCampus},
            dataType: 'json',
            success: function(data){
            console.log(data);
            let classes = data.class;
            let alls = data.all;

            lst_class.children().remove();
            lst_class.append($('<option></option>')
                        .attr('value','0')
                        .text('ALL'));    
        var tabsLiContent = classes.map(function(d) {
            lst_class.append($('<option></option>')
                        .attr('value',d.id)
                        .text(d.name));
        });

        }
    });

     }   

$('#frm_report').submit(function(e){
    e.preventDefault();

    selectCampus=$('input[name="campus"]:checked').val();
    selectClassId=$('#lst_class').val();

    date_fr = $('#date_fr').val();
    date_to = $('#date_to').val();

    table.ajax.url("{{ route('admin.dlp.getdlp') }}?date_fr="+ date_fr + "&date_to="  + date_to +  "&campus=" + selectCampus + "&class_id=" + selectClassId + '&closed_status=true').load();

});
  
  
});
    </script>

@endsection



@section('content')

@include('laravelPnotify::notify')

<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <Form id="frm_report"  method="POST" action="{{ route("admin.dlp.report") }}" enctype="multipart/form-data">
                <div class="row">
                  
                        @csrf
                    <div class="col-lg">
                      <div class="row">
                        <div class="btn-group col"  role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="btn-check" name="campus" id="btnradio1" value="all" autocomplete="off" checked>
                            <label class="btn btn-sm btn-outline-primary" for="btnradio1">ALL</label>
                          
                            <input type="radio" class="btn-check" name="campus" id="btnradio2" value="MC" autocomplete="off">
                            <label class="btn btn-sm btn-outline-primary" for="btnradio2">MC</label>
                          
                            <input type="radio" class="btn-check" name="campus" id="btnradio3" value="CC" autocomplete="off">
                            <label class="btn btn-sm btn-outline-primary" for="btnradio3">CC</label>
                          </div>

                          <label class="col text-right">Class:</label>

                          <div class="col-lg">

                          <select  name="lst_class" id="lst_class" class="form-control-sm select2">
                              <option value="all">ALL<option>
                          </select> 
                          </div>
                      </div>
                    </div>
                    {{-- <div class="col-lg text-center">
                        <a href="{{ route('admin.dlp.index') }}" class="btn btn-outline-secondary">Back to DLP Dashboard</a>
                    </div> --}}
                    <div class="col-lg text-right text-nowrap">
                        Date From: <input type="text" id="date_fr" class="form-control-sm date" value="{{ date("d/m/Y") }}" />To <input type="text" id="date_to"  class="form-control-sm date" value="{{ date("d/m/Y") }}" /> 
                        <input type="submit" class="btn btn-sm btn-primary" value="View Report"/>
                        <a href="{{ route('admin.dlp.index') }}" class="btn btn-sm btn-secondary">Back to DLP Dashboard</a>
                    </div>
                    
                </div>
            </Form>
                </div>

                <div class="card-body">

                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                   <div class="class-list"></div>

                <hr>

                  <div class="row col-12">

                           <!-- <div class="tabs-inside-here"></div>  -->
                        <div class="table-responsive">
                            <table class="dlp-table table table-bordered table-striped" width="100%">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Date</th>
                                <th>Class</th>
                                <th>Type of Problem</th>
                                <th>Problem</th>
                                <th>Attachment</th>
                                <th>Solution</th>
                                <th>Current Status</th>
                            
                                </tr>
                            </thead>
                            </table>
                        </div>

                  </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent

@endsection
