@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
<style>

.btn_class  .result_new{
    color:#66ffff;
}

.btn_class .result_process{
    color:yellow;
}

.btn_class .result_overdue{
    color:#e6ffcc;
}

.active .result_new{
    color:#66ffff;
}

.active .result_process{
    color:Lime;
}

.active .result_overdue{
    color:#e6ffcc;
}

</style>
@endsection

@section('scripts')

<script>

  var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome/') > -1;
  if(is_chrome){
        document.getElementById('btn_notification').style.display = "none";
        setDevice();
    }

  $(function() {

 $("*").dblclick(function(e){
      e.preventDefault();
 });

  $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
   });


  var table;
  var selectClassId=0;
  var selectCampus ='all';
  var html=$('.class-list');

  $(document).on('click', '.campus', function (e) {


        e.preventDefault();
        $('.campus').removeClass('active');
        var campus = $(this).data('value');
        //console.log(campus);
        selectCampus = campus;
        selectClassId = 0;
        $(this).addClass('active');

        clearInterval(timmer);
        main_process();
        timmer = setInterval(main_process,9000);
  });

  $(document).on('click', '#closed_status', function (e) {
     clearInterval(timmer);
     table.ajax.url("{{ route('admin.dlp.getdlp') }}?campus=" + selectCampus + "&class_id=" + selectClassId + '&closed_status=' + $('#closed_status').is(':checked')).load();
     timmer = setInterval(main_process,9000);
  });

  $(document).on('click', '.btn_action', function (e) {
  e.preventDefault();

  clearInterval(timmer);

  var btn =$(this);



  if(btn.data('value')=='in progress'){
    solution = '';
    status = 'In progress';
  }else if(btn.data('value')=='completed'){
    solution = prompt("Enter your solution:");
    if(solution==null)
        return false;
    status = 'Completed';
  }else if(btn.data('value')=='closed'){
    solution = '';
    status = 'closed';
  }

  var data = {'dlp_id': btn.data('id'), 'solution': solution , 'status':status ,"_token": "{{ csrf_token() }}"};

    $.ajax({
        type: 'post',
        url : "{{ route('admin.dlp.update') }}",
        data: data,
        dataType: 'json',
        success: function(data){
           if(data.success){
                //table.ajax.url("{{ route('admin.dlp.getdlp') }}?class_id=" + selectClassId + '&closed_status=' + $('#closed_status').is(':checked')).load();
                main_process();
                timmer = setInterval(main_process,9000);
           }else{
                console.log('Error Update');
           }
        }
    });


  });

  $("#addform").on('shown.bs.collapse', function(){
    $('#txt_problem').focus();
  });

  $('#lst_type').change(function(){
    $('#txt_problem').focus();
  });

//   $('.btn_addnew').click(function(){

     $('#formsubmit').submit(function(e) {

     e.preventDefault();

     var formData = new FormData(this);

    var prob= $('#txt_problem').val();

    $(':input[type="submit"]').prop('disabled', true);

    clearInterval(timmer);

    if(prob==''){
        alert('Please enter problem first.');
        $('#txt_problem').focus();
        return false;
    }

    var data = {'class_id': $('#txt_class_id').val(), 'problem_type': $('#lst_type').val(), 'problem': prob ,"_token": "{{ csrf_token() }}"};

    $.ajax({
        type: 'post',
        url : "{{ route('admin.dlp.addnew') }}",
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: (data) => {
           if(data.success){
                $('#txt_problem').val('');
                $('#txtimage').val('');
                $('#txt_problem').focus();

		$(':input[type="submit"]').prop('disabled', false);

                // console.log(data.message);
                // DesktopNotify.init();
                // DesktopNotify.send(data.message);
                //new Notification(data.title,{body: data.message, renotify:true });
                //DesktopNotify.send('{!! Session::get('notifier.notice') !!}');

                table.ajax.url("{{ route('admin.dlp.getdlp') }}?campus=" + selectCampus + "&class_id=" + selectClassId).load();
                timmer = setInterval(main_process,9000);
           }else{
                console.log('Error Update');
           }
        }
    });

  });

   table = $('.dlp-table').DataTable({
        "destroy": true,
        processing: true,
        serverSide: true,
        paging: false,
        ajax: {
            url:"{{ route('admin.dlp.getdlp') }}?campus=" + selectCampus + "&class_id=" + selectClassId,
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
            {data: 'action', name : 'action'}
        ]
        });

 // } //end function table

  var main_process = function(){

    return $.ajax({
    type: 'get',
    url : "{{ route('admin.dlp.getclass') }}",
    data: {'campus':selectCampus},
    dataType: 'json',
    success: function(data){

    let classes = data.class;
    let alls = data.all;

   html.html('');

    var buttonAll = function(alls) {

        if(alls['new']>0)
            color_new = 'badge-danger';
        else
            color_new='badge-dark';

           if(alls['received']>0)
                color_progress = 'badge-warning';
            else
                color_progress='badge-dark';

           if(alls['overdue']>0)
                color_overdue = 'badge-success';
            else
                color_overdue='badge-dark';

        var button='<div class="col-sm-2 col-md-1 d-inline">';
            button+='<a href="#" class="btn btn-sm btn-secondary ' +  ((selectClassId!=null && selectClassId==0)?"active":"")  + ' btn_class" data-id="0" data-name="All" style="width:100px;padding:3px 3px 0px 0px;margin:3px 0px">';
            button+='<span class="text-uppercase font-weight-bold text-*-center">ALL</span><br/>';
           button+='<label class="text-right small">';
            button+='<span class="result_new">New: <span class="badge '+ color_new +'">' + alls['new'] + '</span></span><br/>';
            button+='<span class="result_process">In progress: <span class="badge '+ color_progress +'">' + alls['received'] + '</span></span><br/>';
            button+='<span class="result_overdue">Overdue: <span class="badge ' + color_overdue + '">' + alls['overdue'] + '</span></span>';
            button+='</label>';
            button+='</a>';
            button+='</div>';
            return button;
         };

   var tabsLiContent = classes.map(function(d) {

           if(d.new>0)
                color_new = 'badge-danger';
            else
                color_new='badge-dark';

           if(d.received>0)
                color_progress = 'badge-warning';
            else
                color_progress='badge-dark';

           if(d.overdue>0)
                color_overdue = 'badge-success';
            else
                color_overdue='badge-dark';

            var button = '<div class="col-sm-2 col-md-1 d-inline">';
            button+='<a href="#" class="btn btn-sm btn-secondary btn_class '+ ((selectClassId!=null && selectClassId==d.id)?"active":"") + '" data-id="' + d.id + '" data-name="' + d.name + '" style="width:100px;padding:3px 3px 0px 0px;margin:3px 0px">';
            button+='<span class="text-uppercase font-weight-bold text-*-center">' + d.name  + '</span><br/>';
            button+='<label class="text-right small">';
            button+='<span class="result_new text-right">New: <span class="badge ' + color_new + '">' + d.new + '</span></span><br/>';
            button+='<span class="result_process">In progress: <span class="badge ' + color_progress + '">' + d.received + '</span></span><br/>';
            button+='<span class="result_overdue">Overdue: <span class="badge ' + color_overdue + '">' + d.overdue + '</span></span>';
            button+='</label>';
            button+='</a>';
            button+='</div>';
        return button;
      });


    button=buttonAll(alls);

    tabsLiContent.unshift(button);

   html.html(tabsLiContent).on('click','.btn_class',function(e){
   // alert('ddd' + $(this).data('id'));
        e.preventDefault();
        let class_id = $(this).data('id');
        let class_name = $(this).data('name');
        clearInterval(timmer);
        selectClassId =class_id;

        $('#txt_class_id').val(selectClassId);
        $('#txt_class').val(class_name);

        if(selectClassId==0)
            $('.btn_addnew').prop('disabled', true);
        else
            $('.btn_addnew').prop('disabled', false);

        $(this).parents().find('.btn_class').removeClass('active');
        $(this).addClass('active');

       // console.log('class_id' + selectClassId);
        table.ajax.url("{{ route('admin.dlp.getdlp') }}?campus=" + selectCampus + "&class_id=" + selectClassId + '&closed_status=' + $('#closed_status').is(':checked')).load();

                $('#txt_problem').focus();

        timmer = setInterval(main_process,9000);

  }); //end of click button class

  // ---------- Set Appearance to button for first initailize
  if(selectClassId==0)
    $('.btn_addnew').prop('disabled', true);
  else
    $('.btn_addnew').prop('disabled', false);

  if(selectClassId==0){
    $('#txt_class').val('All');
    $('#txt_class_id').val('0');
  }

  table.ajax.url("{{ route('admin.dlp.getdlp') }}?campus=" + selectCampus + "&class_id=" + selectClassId + '&closed_status=' + $('#closed_status').is(':checked')).load();

 //   console.log(html);
    },
    error: function (data){
        console.log(data);
    }

  });

   } //end of main function

  //------- init main process

  main_process();
  //table_function();
  var timmer = setInterval(main_process,9000);

//       if(Notification.permission == 'granted'){
//        console.log('Granted');
//     }else if(Notification.permission != 'denied'){
//        Notification.requestPermission().then(permission => {
//             console.log(permission);
//        });
//     }


   });
    </script>
{{--
 @if (Session::has('user1'))
        <script>
            new PNotify("{!! Session::get('user1') !!}");
           new PNotify("{!! Session::get('user2') !!}");
        </script>
@endif
--}}

@endsection



@section('content')

@include('laravelPnotify::notify')

<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                <div class="row">
                    <div class="col-lg">DLP Dashboard
                    <a href='#' class='btn btn-sm btn-info campus active' data-value='all'>ALL</a>
                    <a href='#' class='btn btn-sm btn-info campus' data-value='mc'>MC</a>
                    <a href='#' class='btn btn-sm btn-info campus' data-value='cc'>CC</a>
                    </div>
                    <div class="col-lg text-center">
                        <a href="{{ route('admin.dlp.report') }}" class="btn btn-outline-primary">DLP Report</a>
                    </div>
                    <div class="col-lg text-right">
                    <button class='btn btn-warning' id='btn_notification' onclick="setDevice()">Get Notification</button>
                    Show Closed (Today): <input type="checkbox" id="closed_status" value="1"/></div>
                </div>
                </div>

                <div class="card-body">


                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                   <div class="class-list"></div>

                <hr>
                <p class="text-right" style="margin-bottom:0">
                    <a href="#mission" class="btn btn-outline-primary btn_addform" data-toggle="collapse" data-target="#addform"><i class="fa fa-angle-double-down text-lg-center"></i> Add Problem</a>

                <div class="container-fluid border border-primary collapse" id="addform">
                <form method="POST" enctype="multipart/form-data" id="formsubmit" action="javascript:void(0)" >
                    <div class="row">
                        <div class="col-sm">
                    <div class="form-group">
                         <label class="required" for="name">Class</label>
                         <input class="form-control" type="text" name="txt_class" id="txt_class" value="" readonly>
                         <input type='hidden' name="txt_class_id" id="txt_class_id">
                                <span class="help-block"></span>
                    </div>
                        </div>


                    <div class="col-sm">

                    <div class="form-group">
                         <label class="required" for="name">Type of Problem</label>
                         <select name='lst_type' id='lst_type' class="form-control">
                            @foreach($problem_types  as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                         </select>
                                <span class="help-block"></span>
                    </div>

                    </div>

                   <div class="col-sm-6">

                    <div class="form-group">
                         <label class="required" for="name">Problem</label>
                         <input class="form-control " type="text" name="txt_problem" id="txt_problem" value="" required>
                                <span class="help-block"></span>
                    </div>
                    </div>

                        <div class="col-sm-2">

                    <div class="form-group">
                         <label class="" for="name">Attachment</label>
                         <input class="form-control" type="file" id='txtimage' name='txtimage'>
                     </div>
                     </div>
                <!--

                    <div class="col-2">
                    <div class="form-group">
                         <label class="required" for="name">Solution</label>
                         <input class="form-control " type="text" name="name" id="name" value="" required="">
                                <span class="help-block"></span>
                    </div>
                    </div>

                   <div class="col-2">
                    <div class="form-group">
                         <label class="required" for="name">Status</label>
                         <input class="form-control " type="text" name="name" id="name" value="" required="">
                                <span class="help-block"></span>
                    </div>
                    </div>
                    -->
                     <div class="col-sm">
                    <div class="form-group">
                        <label class=""></label>
                        <button class="form-control btn btn-primary btn_addnew" type="submit">Add New</button>
                                <span class="help-block"></span>
                    </div>
                     </div>
                    </div>

                </form>
                </div>
               </p>


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
                                <th>Action</th>
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
