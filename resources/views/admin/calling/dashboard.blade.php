@extends('layouts.admin')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/ap-fullscreen-modal/ap-fullscreen-modal.css') }}" type="text/css" media="screen" />
    <style>
         /* #waiting_list thead  th{
            font-family:Arial, Helvetica, sans-serif;
            font-size: 20px !important;
        } */

        /* #waiting_list tbody tr td{
            font-family:Arial, Helvetica, sans-serif;
            font-size: 16px;
        } */

        .panel-actions2 {
        /* margin-top: -30px; */
        position: absolute;
        margin-left: -30px;
        margin-bottom: 0px;
        float:right;

        text-align: left;
        } 
        .panel-actions2 a {
        color:#333;
        }

        .panel-fullscreen2 {
            display: block;
            z-index: 9999;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
            overflow: auto;
        }

        /* table1.dataTable tr th{
            font-size: 1.3em;
            text-align: center;
        }
        table1.dataTable tr td{
            margin: 0px;
            padding: 0px;
            background:blue;
        } */

        .dataTables_wrapper table thead{
            display:none;
        }

        .dataTables_wrapper table tbody tr td{
            margin: 0px;
            padding: 2px 0px;
        }
        
        .dataTables_wrapper  table tbody tr td.detail {
            /* max-width: 200px; */
        }

        $dash-size: 5px;
$theme-color: mediumseagreen;
$fill-color: beige;

.box {
	padding: 60px;
	max-width: 650px;
	background: lighten($theme-color, 20%);
	border: $dash-size dashed $theme-color;
	box-shadow: 0 0 0 ($dash-size / 2) darken($theme-color, 20%),
		        0 0 0 ($dash-size * 2.5) #fff,
		        inset 0 0 0 ($dash-size / 2) darken($theme-color, 20%),
		        0 $dash-size ($dash-size * 2) ($dash-size * 3) rgba(0,0,0,0.5),
		        inset 0 0 0 ($dash-size * 1.2) #fff,
		        inset 0 0 100vw 100vw $fill-color;
	color: $theme-color;
	font-family: Marcellus, serif;
	font-size: 3em;
	text-shadow: 0 2px #fff;
	text-align: center;
}

    </style>
@endsection
@section('content')
<div id="modal-content-1" class="modal-content">
<div class="card">
    <div class="card-header">
    <div class="row">
    <div class="col-3 text-nowrap">
    <h3 class="panel-title">Calling Dashboard-<span class="text-primary">[{{ date("d-M-Y") }}]</span><span id="campus"></span></h3>
        </div>
           <div class="col-3 text-center">
        
                <div class="btn-group" role="group">
                      
                    <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if(request('category')==1)
                                Kindergarten & Primary
                        @elseif(request('category')==2)
                                Secondary
                        @elseif(request('category')==3)
                                Monitoring-ALL     
                        @elseif(request('category')==4)
                                Monitoring-Kindergarten     
                        @elseif(request('category')==5)
                                Monitoring-Primary
                        @elseif(request('category')==6)
                                Monitoring-Secondary             
                        @endif
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        @if(request('category')!=1)
                            <a class="dropdown-item" href="{{ route("admin.calling.dashboard",['MC','1']) }}{{ request()->length ? '?length=' . request()->length : '' }}"> Kindergarten & Primary</a>
                        @endif
                        @if(request('category')!=2)
                              <a class="dropdown-item" href="{{ route("admin.calling.dashboard",['MC','2']) }}{{ request()->length ? '?length=' . request()->length : '' }}">Secondary</a>
                        @endif
                        @if(request('category')!=3)
                            <a class="dropdown-item" href="{{ route("admin.calling.dashboard",['MC','3']) }}{{ request()->length ? '?length=0' : '' }}">Monitoring-ALL</a>
                        @endif
                        @if(request('category')!=4)
                            <a class="dropdown-item" href="{{ route("admin.calling.dashboard",['MC','4']) }}{{ request()->length ? '?length=0' : '' }}">Monitoring-Kindergarten</a>
                        @endif
                        @if(request('category')!=5)
                            <a class="dropdown-item" href="{{ route("admin.calling.dashboard",['MC','5']) }}{{ request()->length ? '?length=0' : '' }}">Monitoring-Primary</a>
                        @endif
                        @if(request('category')!=6)
                            <a class="dropdown-item" href="{{ route("admin.calling.dashboard",['MC','6']) }}{{ request()->length ? '?length=0' : '' }}">Monitoring-Secondary</a>
                        @endif

                    </div>
                  </div>

                {{-- <div class="btn-group mr-2" role="group" aria-label="First group">
                  <a class="btn {{ request('category')==1?'btn-primary':'btn-secondary' }} " href="{{ route("admin.calling.dashboard",['MC','1']) }}{{ request()->length ? '?length=' . request()->length : '' }}">Kindergarten & Primary</a>
                </div>
                <div class="btn-group mr-2" role="group" aria-label="Second group">
                  <a  class="btn {{ request('category')==2?'btn-primary':'btn-secondary' }}" href="{{ route("admin.calling.dashboard",['MC','2']) }}{{ request()->length ? '?length=' . request()->length : '' }}">Secondary</a>
                </div> --}}
              
          </div>
          <div class="col-5 border border-primary" style="padding-right:20px">
            <h4 class="panel-title" id="scanout"></h4> 
         </div>
         <div class="col-1">
             <!-- Default checked -->
                <input type="checkbox" data-on="Sound On" data-off="Sound Off" class="custom-control-input" data-toggle="toggle" data-size="normal" id="soundswitch">
         </div>
        
    </div>
    </div>
    <div class="card-body">
        <div class="row">
        <div class="col-lg-4">
            <table class="table table-bordered yajra-datatable table-striped " style="width: 100%;overflow:hidden" id="waiting_list">
                <thead class="bg-primary d-done">
                    <tr>
                    <th width="20px"></th>
                    <th>checkbox</th>
                    <th>Student Info</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="col-lg-4">
            <table class="table table-bordered yajra-datatable table-striped" id="waiting_list2" style="width:100%">
                <thead class="bg-primary d-done">
                    <tr>
                    <th width="20px"></th>
                    <th>checkbox</th>
                    <th>Student Info</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="col-lg-4">
            <table class="table table-bordered yajra-datatable table-striped" id="waiting_list3" width="100%">
                <thead class="bg-primary d-done">
                    <tr>
                    <th width="20px"></th>
                    <th>checkbox</th>
                    <th>Student Info</th>
                    </tr>
                </thead>
            </table>
        </div>
        {{-- <div class="col-3">
            <table class="table table-bordered yajra-datatable table-striped" id="waiting_list4" width="100%">
                <thead class="bg-primary d-done">
                    <tr>
                    <th width="20px"></th>
                    <th>checkbox</th>
                    <th>Student Info</th>
                    </tr>
                </thead>
            </table>
        </div> --}}
        </div>
    </div>
</div>
</div>
<audio id="chatAudio">
        <source src="{{ asset('audio/notify.ogg') }}" type="audio/ogg">
        <source src="{{ asset('audio/notify.mp3') }}" type="audio/mpeg">
        <source src="{{ asset('audio/notify.wav') }}" type="audio/wav">
</audio>
<audio id="playvoice">
</audio>


@endsection

@section('scripts')
<script src="{{ asset('js/ap-fullscreen-modal/ap-fullscreen-modal.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.rfid.js') }}"></script>
@parent
<script>

    $(document).ready(function(){
        let curr_track= document.createElement('audio');  //$('#playvoice');
        var sounds=[];
        var delayVoice;
        var lengthrow={{ request()->length ?? 6 }};
        var startrow = 0;
        var tableTimeInterval;
        var next_page = 1;
        var next_page1 = 2;
        var next_page2 = 3;
        var next_page3 = 4;

        var total_page = 0;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });

        var soundEnable = true;

        var rows_count = 0;
        var index_track =  0;
        var last_track = 0;
        var played = false;

        
        $('#soundswitch').change(function(){
            // console.log($(this).prop('checked'));
           
            if($(this).prop('checked')){
              
                    curr_track.play();
                    delayVoice;
            }
            else{
                //if(!curr_track.paused){
                    //alert('gg' + $(this).prop('checked'));
                   
                    curr_track.pause();
                    clearInterval(delayVoice);
                    curr_track.currentTime = 0;
                
            
            }
                

              

        });


        $('#soundswitch').change();
        

        // $('#modal-content-1').apFullscreenModal({
        //             autoOpen: true,
		// 			openSelector: '#open-modal-1',
		// 			closeSelector: '.close-modal, #send-1',
        //             animationDuration: 1000,

		// 		});

        
        $(document).on('click','.btn_takeout', function(e){
           var obj=$(this);
           // alert('ffff');
           formData = {'send':obj.data('send')};
           var rfidno = obj.data('rfid'); 
           $.ajax({
          type:'POST',
          url: obj.data('takeout'),
          data: formData,
          cache:false,
          dataType: 'json',
         // contentType: false,
         // processData: false,
          success: (data) => {
            //   console.log(data);
            if(data.message != ''){
                    //console.log('ddd' + item);
                        // obj.closest('tr').remove();
                        $("#scanout").empty().fadeIn();
                       // clearInterval(tableTimeInterval);
                        // table1.ajax.reload();
                        $('#scanout').html(data.message);
                        //tableTimeInterval;
                        
                        if(data.status=="success"){
                            $('#scanout').removeClass('text-danger');
                            $('#scanout').removeClass('text-warning');
                            $('#scanout').addClass('text-primary');
                            
                            //obj.closest('tr').remove();
                            remove_sound(data.student_id);
                            $('#row_' + data.student_id).remove();
                            // table1.ajax.reload();
                            // table2.ajax.reload();
                            // table3.ajax.reload();
                            // table4.ajax.reload();
                            //getAllWaiting();
                       		//alert('ss' + rfidno); 
			       if(obj.data('send')==1){
			       $.ajax({
			            type:'POST',
			            url: '/admin/calling_dashboard/action_notification/' + rfidno,
			            data: {},
			            cache:false,
			            dataType: 'json',
			            // contentType: false,
			            // processData: false,
			            success: (data) => {
            
				    }
		  	       });

				}
                        }else if(data.status=="error1"){
                            $('#scanout').removeClass('text-primary');
                            $('#scanout').removeClass('text-danger');
                            $('#scanout').addClass('text-warning');
                        }else{
                            $('#scanout').removeClass('text-primary');
                            $('#scanout').removeClass('text-warning');
                            $('#scanout').addClass('text-danger');
                        }
                        

                    //delay(5000)
                        //$("#scanout").delay(4000).fadeOut(300);                  
                        
                    }
            //  console.log("Response Success: " + data.data);
        },
        error: function(data){
            console.log(data);
        }
        });

        });
        // ;

        function remove_sound(student_id){

            $.each(sounds, function (i, value) {
                //obj = $.parseJSON(value);
            //  console.log(sounds[i].id);
                if(i<sounds.length && value['id'] == student_id){
                    sounds.splice(i,1);
                    //i--;
                }

            });

        }

        let selectCampus = "{{ request('campus') }}";
        
        $.fn.dataTable.ext.errMode = 'none';
        // function(settings, helPage, message){
        //     if(message=='Unahtorized') {
        //         window.location ='/login';
        //     }
        // };

        var table1 = $('#waiting_list').on("draw.dt", function () {
            $(this).find(".dataTables_empty").parents('tbody').empty();
        }).DataTable({
        destroy: true,
        processing: false,
        serverSide: true,
        paging: false,
        bFilter: false,
        bInfo:false,
       // "deferLoading": 0,
        ajax: {
            url:"{{ route('admin.calling.getwaiting') }}?campus=" + selectCampus + '&category={{ request("category") }}&startrow=' + startrow + '&lengthrow=' + lengthrow,
        },
        cache:false,
        buttons: [],
        select: false,
        // "error": function (xhr, error, thrown) {
        //         if()
        //         window.location.href = "/login";
        // },
        columnDefs:[
            {
            'targets':[1],
            'visible':false,
            'searchable': false
            },
        ],
        // "drawCallback": function(settings){

        //   // console.log(settings.json.data);
        //     var jsonObject = settings.json.data; //$.parseJSON(res);
                
        //         function check_studentid(student_id){
        //             exists = false;
        //             $.each(sounds, function(key, value) {
        //                     if(value.id == student_id)
        //                         exists = true;
        //             });

        //             return exists;
        //         }

        //         $.each(jsonObject, function (i, obj) {
        //             if(!check_studentid(obj.student_id) && obj.voice != null){
        //                 //  index_track = i
        //                 sounds.push({'id':obj.student_id,'voice' : obj.voice, 'path':obj.path,'rfid':obj.rfid});
        //                 // sounds[obj.student_id]={'id':obj.student_id,'voice' : obj.voice, 'path':obj.path, 'play':true};
        //             }

        //            //console.log(sounds);
        //         });          
        // if(rows_count < jsonObject.length)
        //             {
        //                // console.log('index:' + index_track);
        //                // $('#txt_index').val(rows_count+1);
        //                // $('#chatAudio')[0].play();
        //                 // queue_sounds(sounds);
        //                 index_track = rows_count;
        //                 //init_play();
                        
        //                // last_track = rows_count;
                        
        //             }
                
        //             rows_count = jsonObject.length;

        // },
      
        columns: [
            {data: 'DT_RowIndex', 
            name : 'DT_RowIndex',
            "render": function(data,type){
                
                return '<h3 class="text-center p-2 m-0">' + (data + (next_page -1) * lengthrow) + '</h3>';
            },
            class:'align-middle'
           
            },
            {data: 'student_id', name : 'student_id'},
            {data: 'detail', name : 'detail',class:'text-nowrap detail'}
            
        ]
        });

       
        var table2 = $('#waiting_list2').on("draw.dt", function () {
            $(this).find(".dataTables_empty").parents('tbody').empty();
            
        }).DataTable({
        "destroy": true,
        processing: false,
        serverSide: true,
        paging: false,
        bFilter: false,
        bInfo:false,
        ajax: {
            url:"{{ route('admin.calling.getwaiting') }}?campus=" + selectCampus + '&category={{ request("category") }}&startrow=' + ((startrow + lengthrow ) * next_page) + '&lengthrow=' + lengthrow,
           
        },
        buttons: [],
        select: false,
        columnDefs:[
            {
            'targets':[1],
            'visible':false,
            'searchable': false
            },
            // {
            //     'targets':[0],
            //     'width':'50%'
            // }
        ],
    
        columns: [
            {data: 'DT_RowIndex', 
            name : 'DT_RowIndex',
            "render": function(data,type){
                return '<h3 class="text-center p-2 m-0">' + (data + (next_page1 -1) * lengthrow ) + '</h3>';
            },
            class:'align-middle',
        
            },
            {data: 'student_id', name : 'student_id'},
            {data: 'detail', name : 'detail',class:'text-nowrap detail'}
         ]
        });


        var table3 = $('#waiting_list3').on("draw.dt", function () {
            $(this).find(".dataTables_empty").parents('tbody').empty();
        }).DataTable({
        "destroy": true,
        processing: false,
        serverSide: true,
        paging: false,
        bFilter: false,
        bInfo:false,
     
        ajax: {
            url:"{{ route('admin.calling.getwaiting') }}?campus=" + selectCampus + '&category={{ request("category") }}&startrow=' + ((startrow + (lengthrow * 2) ) * next_page)  + '&lengthrow=' + lengthrow,
           
        },
        buttons: [],
        select: false,
        columnDefs:[
            {
            'targets':[1],
            'visible':false,
            'searchable': false
            },
        ],
        columns: [
            {data: 'DT_RowIndex', 
            name : 'DT_RowIndex',
            "render": function(data,type){
                
                return '<h3 class="text-center p-2 m-0">' + (data + (next_page2 -1) * lengthrow ) + '</h3>';
            },
            class:'align-middle'
            },
            {data: 'student_id', name : 'student_id'},
            {data: 'detail', name : 'detail',class:'text-nowrap detail'}
        ]
        });


        // var table4 = $('#waiting_list4').on("draw.dt", function () {
        //     $(this).find(".dataTables_empty").parents('tbody').empty();
        // }).DataTable({
        // "destroy": true,
        // processing: false,
        // serverSide: true,
        // paging: false,
        // bFilter: false,
        // bInfo:false,
        // ajax: {
        //     url:"{{ route('admin.calling.getwaiting') }}?campus=" + selectCampus + '&category={{ request("category") }}&startrow=' + (startrow + (lengthrow * 3) * next_page ) + '&lengthrow=' + lengthrow,
           
        // },
        // buttons: [],
        // select: false,
        // columnDefs:[
        //     {
        //     'targets':[1],
        //     'visible':false,
        //     'searchable': false
        //     },
        // ],
        // columns: [
        //     {data: 'DT_RowIndex', 
        //     name : 'DT_RowIndex',
        //     "render": function(data,type){
        //         return '<h3 class="text-center">' +(data + (next_page3 -1) * lengthrow) + '</h3>';
        //     },
        //     class:'align-middle'
        //     },
        //     {data: 'student_id', name : 'student_id'},
        //     {data: 'detail', name : 'detail',class:'text-nowrap detail'}
        // ]
        // });

        var rfidParser = function (rawData) {
            console.log(rawData);
            if (rawData.length != 11) return null;
            else return rawData;
            
        };

        // Called on a good scan (company card recognized)
        var goodScan = function (cardData) {
        // $("#rfid_card").val(cardData.substr(0,10));
        var rfidno=cardData.substr(0,10);
	formData = {'send':1};
	// alert('dddd');

        $.ajax({
            type:'POST',
            url: '/admin/calling_dashboard/action_update/' + rfidno,
            data: formData,
            cache:false,
            dataType: 'json',
            // contentType: false,
            // processData: false,
            success: (data) => {
                //console.log(data.message);
                    if(data.message != ''){
                    //console.log('ddd' + item);
                        // obj.closest('tr').remove();
                        $("#scanout").empty().fadeIn();
                       // clearInterval(tableTimeInterval);
                        // table1.ajax.reload();
                        $('#scanout').html(data.message);
                        //tableTimeInterval;
                        
                        if(data.status=="success"){
                            $('#scanout').removeClass('text-danger');
                            $('#scanout').removeClass('text-warning');
                            $('#scanout').addClass('text-primary');
                            
                            remove_sound(data.student_id);
                            $('#row_' + data.student_id).remove();
                            // getAllWaiting();  
                            // table1.ajax.reload();
                            // table2.ajax.reload();
                            // table3.ajax.reload();
                            // table4.ajax.reload();
                            
	              //        alert('dddd');
                                $.ajax({
                                    type:'POST',
                                    url: '/admin/calling_dashboard/action_notification/' + rfidno,
                                    data: {},
                                    cache:false,
                                    dataType: 'json',
                                    // contentType: false,
                                    // processData: false,
                                    success: (data) => {

                                    }
                               });
                        

                        }else if(data.status=="error1"){
                            $('#scanout').removeClass('text-primary');
                            $('#scanout').removeClass('text-danger');
                            $('#scanout').addClass('text-warning');
                        }else{
                            $('#scanout').removeClass('text-primary');
                            $('#scanout').removeClass('text-warning');
                            $('#scanout').addClass('text-danger');
                        }
                        

                    //delay(5000)
                       // $("#scanout").delay(4000).fadeOut(300);                  
                        
                    }
                //  console.log("Response Success: " + data.data);
            },
            error: function(data){
                console.log(data);
            }
            });
            
        };

        // Called on a bad scan (company card not recognized)
        var badScan = function() {
            console.log("Bad Scan.");
        };

        // Initialize the plugin.
        $.rfidscan({
            parser: rfidParser,
            success: goodScan,
            error: badScan
        });

        // Refresh data 

    //    voiceTimeInterval=setInterval(function(){
    //            getAllWaiting();
    //    },4000);

        

        getAllWaiting = function(){
            $.ajax({
                type:'get',
                url: "{{ route('admin.calling.getwaitingvoice') }}?campus=" + selectCampus + '&category={{ request("category") }}&startrow=0',
                data: {},
                cache:false,
                dataType: 'json',
                // contentType: false,
                // processData: false,
                error: function (error){

                   if(error.responseJSON.message=='Unauthenticated.') 
                        window.location ='/login';
                },
                success: (data) => {

                    
                    sounds=[];

                    
                   
                    $.each(data, function (i, obj) {
                        // console.log(obj);
                    //if(!check_studentid(obj.student_id) && obj.voice != null){
                        //  index_track = i
                        sounds[i]={'id':obj.student.email,'voice' : obj.student.voice, 'path':obj.student.path,'rfid':obj.student.rfidcard};
                        // sounds[obj.student_id]={'id':obj.student_id,'voice' : obj.voice, 'path':obj.path, 'play':true};
                    });


                    var total_audio = sounds.length;
                    total_page = Math.ceil(total_audio / lengthrow);

                    // if(data.length > total_audio  && played)
                    //     index_track++;
                    // else if(data.length < total_audio  && played)
                    //     index_track--;

                    //sounds = sounds.reverse();
                    // if(!played)
                    
                    

                    if(sounds.length>0){
                          init_play();
                          
                    }else{

                        delayVoice=setTimeout(getAllWaiting, 5000);

                    }

                    // if(next_page >= total_page)
                    //     next_page = 0;
                    //console.log(sounds);
                }
            });

        }


        tableTimeInterval=setInterval(function(){
            
            console.log("Page:" + next_page + 'of Total ' + total_page);
                       if(total_page > 3){
                           next_page = next_page + 1;
                           next_page1 = next_page1 + 1;
                           next_page2 = next_page2 + 1;
                          // next_page3 = next_page3 + 1;
           
                           if(next_page>total_page)
                           next_page=1;
                           if(next_page1>total_page)
                               next_page1=1;
                           if(next_page2>total_page)
                               next_page2=1;
                           // if(next_page3>total_page)
                           //     next_page3=1;
           
                        }
                       
                      
                       table1.ajax.url("{{ route('admin.calling.getwaiting') }}?campus=" + selectCampus + '&category={{ request("category") }}&startrow=' + ((next_page -1) * lengthrow) + '&lengthrow=' + lengthrow).load();
                       table2.ajax.url("{{ route('admin.calling.getwaiting') }}?campus=" + selectCampus + '&category={{ request("category") }}&startrow=' + ((next_page1-1) * lengthrow) + '&lengthrow=' + lengthrow).load();
                       table3.ajax.url("{{ route('admin.calling.getwaiting') }}?campus=" + selectCampus + '&category={{ request("category") }}&startrow=' +  ((next_page2-1) * lengthrow)  + '&lengthrow=' + lengthrow).load();
                       //table4.ajax.url("{{ route('admin.calling.getwaiting') }}?campus=" + selectCampus + '&category={{ request("category") }}&startrow=' +  ((next_page3-1) * lengthrow)  + '&lengthrow=' + lengthrow).load();
                       
                      
                       //                     // table3.ajax.reload();
                       //                     // table4.ajax.reload();
                   },6000);
        
        getAllWaiting();


        

        // play queue mp3 voice
        

        // function play(audio, callback) {
           

            
        //     curr_track.src = sounds[audio].path;
        //    // console.log(curr_track);
        //    // curr_track.load();
        //     curr_track.play();
        
        //     if(callback)
        //         curr_track.onended = callback;
        // }
        
    
        function playsong(audio) {         

            played = true;
            curr_track.src = audio;

            var playPromise;

            if($('#soundswitch').prop('checked'))       
                  playPromis=curr_track.play();

            if(playPromise !== undefined){
                playPromise.then(_ => {

                    //curr_track.pause();
                })
                .catch(error => {
                    play_nextaudio();
                });
            }
            // console.log('Play song: ' + index_track + ', Sonuds length:' +  sounds.length);

            if(index_track <= sounds.length-1){
                curr_track.onended = play_nextaudio;
            }

       }

        function init_play(){
              if(!played){
               
                playsong(sounds[index_track].path); 
              }
                 
              
        }

        function play_nextaudio(){
            if(index_track<sounds.length-1){
                //console.log("play next:" + index_track);
                index_track = index_track + 1 ;
                playsong(sounds[index_track].path);  
            } else{
                
                    index_track=0;
                    played = false;
                    delayVoice=setTimeout(getAllWaiting, 5000);
                
            }    
        }

        // function queue_sounds(sounds){
           
        // function recursive_play()
        //     {            
        //       //  console.log(index);
        //     if(index+1 === sounds.length)
        //     {
        //         play(index,null);
            
        //       //  console.log('last' + sounds[index].play);
        //     }
        //     else if(index < sounds.length)
        //     {    
        //         play(index,function(){index++; recursive_play();});
                
        //     }
        // }

        // recursive_play();   
        // }


       

     });


    </script>
@endsection
