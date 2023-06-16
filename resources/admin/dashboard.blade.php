@extends('layouts.admin')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/ap-fullscreen-modal/ap-fullscreen-modal.css') }}" type="text/css" media="screen" />
    <style>
         #waiting_list thead  th{
            font-family:Arial, Helvetica, sans-serif;
            font-size: 20px !important;
        }

        #waiting_list tbody tr td{
            font-family:Arial, Helvetica, sans-serif;
            font-size: 16px;
        }

        .panel-actions {
        margin-top: -30px;
        margin-bottom: 0;
        text-align: right;
        } 
        .panel-actions a {
        color:#333;
        }

        .panel-fullscreen {
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



    </style>
@endsection
@section('content')
<div id="modal-content-1" class="modal-content">
<div class="card">
    <div class="card-header">
    <div class="row">
    <div class="col-3 text-nowrap">
    <h3 class="panel-title">Student Calling Dashboard <span id="campus"></span></h3>
        </div>
           <div class="col-2">
                 <h3 class="panel-title">{{ date("d-M-Y") }}</h3>
          </div>
          <div class="col-6 border border-primary" style="padding-right:20px">
            <h3 class="panel-title" id="scanout"></h3>
         </div>
            <ul class="list-inline panel-actions">
                <li><a href="#" id="panel-fullscreen" role="button" title="Toggle fullscreen"><i class="fa-2x fa-regular fa-up-right-and-down-left-from-center"></i></a></li>
            </ul>
    </div>
    </div>
    <div class="card-body">

        <table class="table" id="waiting_list" width="100%">
            <thead class="bg-primary">
                <tr>
                <th></th>
                <th width="7%">ID Card</th>
                <th width="20%">Khmer Name</th>
                <th width="20%">English Name</th>
                <th>Class</th>
                <th>Time Scan In</th>
                <th>Duration</th>
                <th>Status</th>
                <th>#</th>
                </tr>
            </thead>
        </table>
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
      

        var tableTimeInterval;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });

        var rows_count = 0;
        var index_track =  0;
        var last_track = 0;

        var played = false;
        $("#panel-fullscreen").click(function (e) {
        e.preventDefault();
        
        var $this = $(this);
    
            if ($this.children('i').hasClass('fa-up-right-and-down-left-from-center'))
            {
                $this.children('i').removeClass('fa-up-right-and-down-left-from-center');
                $this.children('i').addClass('fa-down-left-and-up-right-to-center');
            }
            else if ($this.children('i').hasClass('fa-down-left-and-up-right-to-center'))
            {
                $this.children('i').removeClass('fa-down-left-and-up-right-to-center');
                $this.children('i').addClass('fa-up-right-and-down-left-from-center');
            }
            
            $(this).closest('.card').toggleClass('panel-fullscreen');
        });
        

        // $('#modal-content-1').apFullscreenModal({
        //             autoOpen: true,
		// 			openSelector: '#open-modal-1',
		// 			closeSelector: '.close-modal, #send-1',
        //             animationDuration: 1000,

		// 		});

        formData = {};
        $(document).on('click','.btn_takeout', function(e){
           var obj=$(this);

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
                if(data.status){
                // console.log('ddd' + data);
                    obj.closest('tr').remove();
                    rows_count = rows_count - 1;    
                
                    newData=[];pp=0;
                    for(i=0;i<sounds.length;i++){
                        if(sounds[i].rfid!=obj.data('rfid')){
                            //delete sounds[i];
                            newData[pp] = sounds[i];
                            pp++;
                        }
                        
                    }

                    sounds=newData;
                
                }
            //  console.log("Response Success: " + data.data);
        },
        error: function(data){
            console.log(data);
        }
        });

        });
        // ;
        let selectCampus = 'MC';

       // $('#campus').html(selectCampus);

        var table = $('#waiting_list').DataTable({
        "destroy": true,
        processing: true,
        serverSide: true,
        paging: false,

        ajax: {
            url:"{{ route('admin.calling.getwaiting') }}?campus=" + selectCampus,
            // dataSrc: function(res){
            //     var jsonObject = res.data; //$.parseJSON(res);
                
            //     function check_studentid(student_id){
            //         exists = false;
            //         $.each(sounds, function(key, value) {
                        
            //            // $.each(newArray, function(k, val2) {
            //               // console.log(value.id + '==' + student_id);
            //                 if(value.id == student_id)
            //                     exists = true;
            //           //  });
                        
            //         });

            //         return exists;
            //     }

            //     $.each(jsonObject, function (i, obj) {
            //         if(!check_studentid(obj.student_id) && obj.voice != null){
            //             //  index_track = i
            //             // sounds.push({'id':obj.student_id,'voice' : obj.voice, 'path':obj.path});
            //             sounds[i]={'id':obj.student_id,'voice' : obj.voice, 'path':obj.path, 'play':true};
            //         }

            //        //console.log(sounds);
            //     });
               
            //    if(rows_count < res.data.length)
            //         {
            //             console.log('index:' + last_track);
            //             $('#txt_index').val(rows_count+1);
            //            // $('#chatAudio')[0].play();
            //             // queue_sounds(sounds);
            //             init_play();
                        
            //            // last_track = rows_count;
                        
            //         }

            //     rows_count = res.data.length;
                
                //if(played){
                    
                        
              //  }

                // return res.data;
            // }
           // data: {'class_id':selectClassId},
        },
        select: false,
        columnDefs:[
            {
            'targets':[0, {{ (request()->input('show_action')=='yes')?0:8 }}],
            'visible':false,
            'searchable': false
            },
        ],
        "drawCallback": function(settings){

           // console.log(settings.json.data);
            var jsonObject = settings.json.data; //$.parseJSON(res);
                
                function check_studentid(student_id){
                    exists = false;
                    $.each(sounds, function(key, value) {
                        
                       // $.each(newArray, function(k, val2) {
                          // console.log(value.id + '==' + student_id);
                            if(value.id == student_id)
                                exists = true;
                      //  });
                        
                    });

                    return exists;
                }

                $.each(jsonObject, function (i, obj) {
                    if(!check_studentid(obj.student_id) && obj.voice != null){
                        //  index_track = i
                        sounds.push({'id':obj.student_id,'voice' : obj.voice, 'path':obj.path,'rfid':obj.rfid});
                        // sounds[i]={'id':obj.student_id,'voice' : obj.voice, 'path':obj.path, 'play':true};
                    }

                   //console.log(sounds);
                });
               
               if(rows_count < jsonObject.length)
                    {
                       // console.log('index:' + index_track);
                       // $('#txt_index').val(rows_count+1);
                       // $('#chatAudio')[0].play();
                        // queue_sounds(sounds);
                        index_track = rows_count;
                        init_play();
                        
                       // last_track = rows_count;
                        
                    }
                
                    rows_count = jsonObject.length;
                    
                

        },
        // "initComplete": function(settings){
        //    if(played){
        //        console.log(sounds);
        //         $('#chatAudio')[0].play();
        //         queue_sounds(sounds);
        //    }
        // },
        // order:[1,'desc'],
        columns: [
            {data: null, name : 'index'},
            {data: 'student_id', name : 'student_id'},
            {data: 'namekh', name : 'namekh'},
            {data: 'name', name : 'name'},
            {data: 'class_name', name : 'class_name',class:'text-nowrap'},
            {data: 'time', name : 'time'},
            {data: 'duration', name: 'duration'},
            {data: 'status', name : 'status'},
            {data: 'action', name : 'action'}
        ]
        });

        var rfidParser = function (rawData) {
            console.log(rawData);
            if (rawData.length != 11) return null;
            else return rawData;
            
        };

        // Called on a good scan (company card recognized)
        var goodScan = function (cardData) {
        // $("#rfid_card").val(cardData.substr(0,10));
        var rfidno=cardData.substr(0,10);
        formData = {};
        $.ajax({
            type:'POST',
            url: '/admin/calling_dashboard/action_update/' + rfidno,
            data: formData,
            cache:false,
            dataType: 'json',
            // contentType: false,
            // processData: false,
            success: (data) => {
                console.log(data.message);
                    if(data.message != ''){
                    //console.log('ddd' + item);
                        // obj.closest('tr').remove();
                        $("#scanout").empty().fadeIn();
                       // clearInterval(tableTimeInterval);
                        table.ajax.reload();
                        $('#scanout').html(data.message);
                        //tableTimeInterval;
                        
                        if(data.status=="success"){
                            $('#scanout').removeClass('text-danger');
                            $('#scanout').addClass('text-primary');
                            rows_count = rows_count - 1;
                            newData=[];pp=0;
                            for(i=0;i<sounds.length;i++){
                                if(sounds[i].rfid!=rfidno){
                                    //delete sounds[i];
                                    newData[pp] = sounds[i];
                                    pp++;
                                }
                                
                            }

                            sounds=newData;

                        }else{
                            $('#scanout').removeClass('text-primary');
                            $('#scanout').addClass('text-danger');
                        }
                        

                    //delay(5000)
                        $("#scanout").delay(4000).fadeOut(300);                  
                        
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

        tableTimeInterval=setInterval(function(){
            table.ajax.reload();
        },3000);

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
            
            // var times = 3;
            // var loop = setInterval(repeat, 1700);

            // function repeat() {
            //     times--;
            //     if (times === 0) {
            //         clearInterval(loop);
            //     }

            //      curr_track.src = audio;
            //      curr_track.play();
                
            //     //  if(times>0)
            //     //     curr_track.onended = repeat;
                
            // }


            //repeat();   
            
            curr_track.src = audio;
                 curr_track.play();

            
            if(index_track < sounds.length-1){
                
                curr_track.onended = play_nextaudio;
            }
                
       }

        function init_play(){

              playsong(sounds[index_track].path); 
        }

        function play_nextaudio(){
            if(index_track<sounds.length-1){
                console.log("play next:" + index_track);
                index_track = index_track + 1 ;
                playsong(sounds[index_track].path);  
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