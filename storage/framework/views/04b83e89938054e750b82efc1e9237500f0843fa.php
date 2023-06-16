<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/ap-fullscreen-modal/ap-fullscreen-modal.css'), false); ?>" type="text/css" media="screen" />
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
        position: relative;
        margin-right: 10px;
        margin-bottom: 0px;
        float:right;

        text-align: right;
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

        table.dataTable tr th{
            font-size: 1.3em;
            text-align: center;
        }
        table.dataTable tr td{
            margin: 0px;
            padding: 2px;
        }
        .dataTables_wrapper table thead{
            display:none;
        }
        
        .dataTables_wrapper table tbody tr td.detail {
            max-width: 200px;
        }

    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div id="modal-content-1" class="modal-content">
<div class="card">
    <div class="card-header">
    <div class="row">
    <div class="col-3 text-nowrap">
    <h3 class="panel-title">Calling Dashboard-<span class="text-primary">[<?php echo e(date("d-M-Y"), false); ?>]</span><span id="campus"></span></h3>
        </div>
           <div class="col-3">
            <div class="btn-toolbar float-sm-right" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group mr-2" role="group" aria-label="First group">
                  <a class="btn <?php echo e(request('category')==1?'btn-primary':'btn-secondary', false); ?> " href="<?php echo e(route("admin.calling.dashboard",['MC','1']), false); ?><?php echo e(request()->length ? '?length=' . request()->length : '', false); ?>">Kindergarten & Primary</a>
                </div>
                <div class="btn-group mr-2" role="group" aria-label="Second group">
                  <a  class="btn <?php echo e(request('category')==2?'btn-primary':'btn-secondary', false); ?>" href="<?php echo e(route("admin.calling.dashboard",['MC','2']), false); ?><?php echo e(request()->length ? '?length=' . request()->length : '', false); ?>">Secondary</a>
                </div>
              </div>
          </div>
          <div class="col-5 border border-primary" style="padding-right:20px">
            <h4 class="panel-title" id="scanout"></h4>
         </div>
         <div class="col-1">
             <!-- Default checked -->
                <input type="checkbox" data-on="Sound On" data-off="Sound Off" class="custom-control-input" checked data-toggle="toggle" data-size="normal" id="soundswitch" checked>
         </div>
        
    </div>
    </div>
    <div class="card-body">
        <div class="row">
        <div class="col-lg-3">
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
        <div class="col-3">
            <table class="table table-bordered yajra-datatable table-striped" id="waiting_list2" width="100%">
                <thead class="bg-primary d-done">
                    <tr>
                    <th width="20px"></th>
                    <th>checkbox</th>
                    <th>Student Info</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="col-3">
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
        <div class="col-3">
            <table class="table table-bordered yajra-datatable table-striped" id="waiting_list4" width="100%">
                <thead class="bg-primary d-done">
                    <tr>
                    <th width="20px"></th>
                    <th>checkbox</th>
                    <th>Student Info</th>
                    </tr>
                </thead>
            </table>
        </div>
        </div>
    </div>
</div>
</div>
<audio id="chatAudio">
        <source src="<?php echo e(asset('audio/notify.ogg'), false); ?>" type="audio/ogg">
        <source src="<?php echo e(asset('audio/notify.mp3'), false); ?>" type="audio/mpeg">
        <source src="<?php echo e(asset('audio/notify.wav'), false); ?>" type="audio/wav">
</audio>
<audio id="playvoice">
</audio>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('js/ap-fullscreen-modal/ap-fullscreen-modal.js'), false); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jquery.rfid.js'), false); ?>"></script>
<?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
<script>

    $(document).ready(function(){
        let curr_track= document.createElement('audio');  //$('#playvoice');
        var sounds=[];
        var delayVoice;
        var lengthrow=<?php echo e(request()->length ?? 6, false); ?>;
        var startrow = 0;
        var tableTimeInterval;
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
                    
                    curr_track.pause();
                    clearInterval(delayVoice);
                    curr_track.currentTime = 0;
                
            
            }
                

              

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
            if(data.message != ''){
                    //console.log('ddd' + item);
                        // obj.closest('tr').remove();
                        $("#scanout").empty().fadeIn();
                       // clearInterval(tableTimeInterval);
                        // table.ajax.reload();
                        $('#scanout').html(data.message);
                        //tableTimeInterval;
                        
                        if(data.status=="success"){
                            $('#scanout').removeClass('text-danger');
                            $('#scanout').addClass('text-primary');
                            
                            table.ajax.reload();
                            table2.ajax.reload();
                            table3.ajax.reload();
                            table4.ajax.reload();
                            getAllWaiting();  
                        

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

        });
        // ;
        let selectCampus = "<?php echo e(request('campus'), false); ?>";

        var table = $('#waiting_list').on("draw.dt", function () {
            $(this).find(".dataTables_empty").parents('tbody').empty();
        }).DataTable({
        "destroy": true,
        processing: true,
        serverSide: true,
        paging: false,
        bFilter: false,
        bInfo:false,
        ajax: {
            url:"<?php echo e(route('admin.calling.getwaiting'), false); ?>?campus=" + selectCampus + '&category=<?php echo e(request("category"), false); ?>&startrow=' + startrow + '&lengthrow=' + lengthrow,
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
                return '<h3 class="text-center">' + data + '</h3>';
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
        processing: true,
        serverSide: true,
        paging: false,
        bFilter: false,
        bInfo:false,
        ajax: {
            url:"<?php echo e(route('admin.calling.getwaiting'), false); ?>?campus=" + selectCampus + '&category=<?php echo e(request("category"), false); ?>&startrow=' + (startrow + lengthrow ) + '&lengthrow=' + lengthrow,
           
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
                return '<h3 class="text-center">' + (data + startrow + lengthrow) + '</h3>';
            },
            class:'align-middle'
            },
            {data: 'student_id', name : 'student_id'},
            {data: 'detail', name : 'detail',class:'text-nowrap detail'}
         ]
        });


        var table3 = $('#waiting_list3').on("draw.dt", function () {
            $(this).find(".dataTables_empty").parents('tbody').empty();
        }).DataTable({
        "destroy": true,
        processing: true,
        serverSide: true,
        paging: false,
        bFilter: false,
        bInfo:false,
        ajax: {
            url:"<?php echo e(route('admin.calling.getwaiting'), false); ?>?campus=" + selectCampus + '&category=<?php echo e(request("category"), false); ?>&startrow=' + (startrow + (lengthrow * 2) ) + '&lengthrow=' + lengthrow,
           
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
                return '<h3 class="text-center">' + (data+startrow + (lengthrow * 2)) + '</h3>';
            },
            class:'align-middle'
            },
            {data: 'student_id', name : 'student_id'},
            {data: 'detail', name : 'detail',class:'text-nowrap detail'}
        ]
        });


        var table4 = $('#waiting_list4').on("draw.dt", function () {
            $(this).find(".dataTables_empty").parents('tbody').empty();
        }).DataTable({
        "destroy": true,
        processing: true,
        serverSide: true,
        paging: false,
        bFilter: false,
        bInfo:false,
        ajax: {
            url:"<?php echo e(route('admin.calling.getwaiting'), false); ?>?campus=" + selectCampus + '&category=<?php echo e(request("category"), false); ?>&startrow=' + (startrow + (lengthrow * 3) ) + '&lengthrow=' + lengthrow,
           
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
                return '<h3 class="text-center">' + (data + startrow + (lengthrow * 3)) + '</h3>';
            },
            class:'align-middle'
            },
            {data: 'student_id', name : 'student_id'},
            {data: 'detail', name : 'detail',class:'text-nowrap detail'}
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
                //console.log(data.message);
                    if(data.message != ''){
                    //console.log('ddd' + item);
                        // obj.closest('tr').remove();
                        $("#scanout").empty().fadeIn();
                       // clearInterval(tableTimeInterval);
                        // table.ajax.reload();
                        $('#scanout').html(data.message);
                        //tableTimeInterval;
                        
                        if(data.status=="success"){
                            $('#scanout').removeClass('text-danger');
                            $('#scanout').addClass('text-primary');
                            
                            table.ajax.reload();
                            table2.ajax.reload();
                            table3.ajax.reload();
                            table4.ajax.reload();
                            getAllWaiting();  
                        

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
            table2.ajax.reload();
            table3.ajax.reload();
            table4.ajax.reload();
                getAllWaiting();
        },4000);

        getAllWaiting = function(){
            $.ajax({
                type:'get',
                url: "<?php echo e(route('admin.calling.getwaitingvoice'), false); ?>?campus=" + selectCampus + '&category=<?php echo e(request("category"), false); ?>&startrow=0&lengthrow=' + (lengthrow*4),
                data: {},
                cache:false,
                dataType: 'json',
                // contentType: false,
                // processData: false,
                success: (data) => {

                    var total_audio = sounds.length;

                    sounds=[];

                   
                    $.each(data, function (i, obj) {
                        // console.log(obj);
                    //if(!check_studentid(obj.student_id) && obj.voice != null){
                        //  index_track = i
                        sounds[i]={'id':obj.student.email,'voice' : obj.student.voice, 'path':obj.student.path,'rfid':obj.student.rfidcard};
                        // sounds[obj.student_id]={'id':obj.student_id,'voice' : obj.voice, 'path':obj.path, 'play':true};
                    });

                    if(data.length > total_audio  && played)
                        index_track++;
                    else if(data.length < total_audio  && played)
                        index_track--;

                    //sounds = sounds.reverse();
                    // if(!played)
                

                    if(sounds.length>0)
                            init_play();

                    //console.log(sounds);
                }
            });

        }
        
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
            played = true;
            curr_track.src = audio;
            curr_track.play();
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
                
                
                //if(sounds.length>0){
                    delayVoice=setTimeout(() => {
                        if(sounds.length>0){
                          index_track = 0;
                          playsong(sounds[index_track].path);
                         } else{
                          played=false;
                          index_track=0;
                        }
                    }, 4000);
                //}
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/school/resources/views/admin/calling/dashboard.blade.php ENDPATH**/ ?>