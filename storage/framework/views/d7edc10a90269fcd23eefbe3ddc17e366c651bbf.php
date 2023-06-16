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

        .font-big {
            font-size:20px;
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

        /* .dataTables_wrapper table thead{
            display:none;
        } */

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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div id="modal-content-1" class="modal-content">
<div class="card">
    <div class="card-header">
    <div class="row">
    <div class="col-3 text-nowrap">
    <h3 class="panel-title">Calling Dashboard - <span class="text-primary">[<?php echo e(date("d-M-Y"), false); ?>]</span><span id="campus"></span></h3>
        </div>
           <div class="col-2 text-center">
        
                <div class="btn-group" role="group">
                      
                    <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php if(request('category')==1): ?>
                                Kindergarten & Primary
                        <?php elseif(request('category')==2): ?>
                                Secondary
                        <?php elseif(request('category')==3): ?>
                                Monitoring        
                        <?php endif; ?>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <?php if(request('category')!=1): ?>
                            <a class="dropdown-item" href="<?php echo e(route("admin.calling.dashboard",['MC','1']), false); ?><?php echo e(request()->length ? '?length=' . request()->length : '', false); ?>"> Kindergarten & Primary</a>
                        <?php endif; ?>
                        <?php if(request('category')!=2): ?>
                              <a class="dropdown-item" href="<?php echo e(route("admin.calling.dashboard",['MC','2']), false); ?><?php echo e(request()->length ? '?length=' . request()->length : '', false); ?>">Secondary</a>
                        <?php endif; ?>
                        <?php if(request('category')!=3): ?>
                            <a class="dropdown-item" href="<?php echo e(route("admin.calling.dashboard",['MC','3']), false); ?><?php echo e(request()->length ? '?length=0' : '', false); ?>">Monitoring</a>
                        <?php endif; ?>
                    </div>
                    
                  </div>

                
              
          </div>
          <div class="col-5 border border-primary" style="padding-right:20px">
            <h4 class="panel-title" id="scanout"></h4> 
         </div>
         <div class="col-2">
             <!-- Default checked -->
                <input type="checkbox" data-on="Sound On" data-off="Sound Off" class="custom-control-input" checked data-toggle="toggle" data-size="normal" id="soundswitch">
                &nbsp;
                <input type="checkbox" data-on="Search On" data-off="Scan On" class="custom-control-input"  data-toggle="toggle" data-size="normal" id="searchswitch" style="display: <?php echo e((request('category')==3)?'':'none', false); ?>">
         </div>
        
    </div>
    </div>
    <div class="card-body">
        <div class="row">
        <div class="col-lg-12">
            <table class="table table-bordered  table-striped " style="width: 100%;overflow:hidden" id="waiting_list">
                <thead class="bg-primary">
                    <tr>
                    <th width="20px"></th>
                    <th class="text-capitalize text-left" style="width: 90px">Photo</th>
                    <th class="text-capitalize text-left">Student ID</th>
                    <th class="text-capitalize text-left">Khmer Name</th>
                    <th class="text-capitalize">English Name</th>
                    <th class="text-capitalize">Class</th>
                    <th class="text-capitalize">Duration</th>
                    <th>#</th>
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
            // alert('dd');
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
                            $('#scanout').addClass('text-primary');
                            
                            // table1.ajax.reload();
                            // table2.ajax.reload();
                            // table3.ajax.reload();
                            // table4.ajax.reload();
                            //getAllWaiting();
                        

                        }else{
                            $('#scanout').removeClass('text-primary');
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
        let selectCampus = "<?php echo e(request('campus'), false); ?>";

        var table1 = $('#waiting_list').on("draw.dt", function () {
            $(this).find(".dataTables_empty").parents('tbody').empty();
        }).DataTable({
        destroy: true,
        processing: false,
        serverSide: true,
        paging: false,
        bFilter: true,
        bInfo:false,
        "ordering": false,
        oLanguage:{
            "sSearch":'Search only[Student ID, English Name]: '
        },
       // "deferLoading": 0,
        ajax: {
            url:"<?php echo e(route('admin.calling.getwaiting'), false); ?>?campus=" + selectCampus + '&category=<?php echo e(request("category"), false); ?>&startrow=0&lengthrow=1000',
        },
        cache:false,
        buttons: [],
        select: false,
        columnDefs:[
            // {
            // 'targets':[1],
            // 'visible':false,
            // 'searchable': false
            // },
            {
             'targets':[0,2,4,5,6],
             
             'searchable': false 
            }
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
            // name : 'DT_RowIndex',
            // "render": function(data,type){
                
            //     return '<h5 class="text-center p-2 m-0">' + (data + (next_page -1) * lengthrow) + '</h5>';
            // },
            class:'text-center align-middle p-2 text-weight'
           
            },
            {data: 'thumnail',name:'thumnail',clas:'p-0 m-0 text-center'},
            {data: 'student_id', name : 'student_id' ,  class:'text-uppercase align-middle text-weight-normal p-2'},
            {data: 'namekh', name : 'namekh', class:'text-uppercase align-middle font-big text-weight p-2'},
            {data: 'name', name : 'name', class:'text-uppercase align-middle text-weight-normal p-2'},
            {data: 'class_name', name : 'class_name', class:'text-weight-normal align-middle p-2'},
            {data: 'duration', name : 'duration',class:'text-weight-normal align-middle p-2'},
            {data: 'action', name : 'action',class:'p-2 text-center align-middle'},
            
        ]
        });

       
       

        var rfidParser = function (rawData) {
           // alert('ddd' + rawData.length );
            if (rawData.length != 11) return null;
            else return rawData;
            
        };

        // Called on a good scan (company card recognized)
        var goodScan = function (cardData) {
            console.log(cardData);
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
                        // table1.ajax.reload();
                        $('#scanout').html(data.message);
                        //tableTimeInterval;
                        
                        if(data.status=="success"){
                            $('#scanout').removeClass('text-danger');
                            $('#scanout').addClass('text-primary');
                            table1.ajax.reload();
                            // getAllWaiting();  
                            // table1.ajax.reload();
                            // table2.ajax.reload();
                            // table3.ajax.reload();
                            // table4.ajax.reload();
                            
                        

                        }else{
                            $('#scanout').removeClass('text-primary');
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
        // $('.dataTables_filter input').on({

            // keypress: function() { typed_into = true; },
            // change: function() {
            //     if (typed_into) {
            //         $.rfidscan({
            //             enabled: false,
            //             parser: rfidParser,
            //             success: goodScan,
            //             error: badScan
            //         });
            //         typed_into = false; //reset type listener
            //     } else {
            //         $.rfidscan({
            //             enabled: true,
            //             parser: rfidParser,
            //             success: goodScan,
            //             error: badScan
            //         });
            //     }
            // }
        // });

     
        $.rfidscan({
                    enabled: true,
                    parser: rfidParser,
                    success: goodScan,
                    error: badScan
                });
                $(document).unbind(".dataTables_filter input"); 
             //   $(document).unbind(".dataTables_filter input");       
        
        var  default_scan = true;
        $('#searchswitch').on("change",function(){
                default_scan = !default_scan;
                if(default_scan)
                    $.rfidscan({
                        enabled: true,
                        parser: rfidParser,
                        success: goodScan,
                        error: badScan
                    });
            else{
                    $.rfidscan({
                            enabled: false,
                            parser: rfidParser,
                            success: goodScan,
                            error: badScan
                        });
                        $(document).unbind(".rfidscan");
            }  
        });

        // $('#waiting_list').on('order.dt search.dt', function(){

        //         console.log('ddd' + $('.dataTables_filter input').val());
        // });

        var x = -1;
        var delta = 0;
        var count = 0;
        function detectHumans() {
            count += 1;
            if ($("#card_number").val().length != count) {
                alert('human detected');
                $("body").html('');
            }
            console.log($("#card_number").val());
            y = Date.now();
            if (x == -1) {
                x = y;
            }
            else if (delta == 0) {
                delta = y - x;
                x = y;
            }
            else{
                var new_delta = y - x;
                console.log(delta);
                console.log(new_delta);
                if (Math.abs(new_delta - delta) > 10) {
                    alert('human detected');
                    $("body").html('');
                }
                delta = new_delta;
                x = y;
            }
        }


        // Refresh data 

       voiceTimeInterval=setInterval(function(){
               getAllWaiting();
       },4000);

        

        getAllWaiting = function(){
            $.ajax({
                type:'get',
                url: "<?php echo e(route('admin.calling.getwaitingvoice'), false); ?>?campus=" + selectCampus + '&category=<?php echo e(request("category"), false); ?>&startrow=0',
                data: {},
                cache:false,
                dataType: 'json',
                // contentType: false,
                // processData: false,
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

                    if(data.length > total_audio  && played)
                        index_track++;
                    else if(data.length < total_audio  && played)
                        index_track--;

                    //sounds = sounds.reverse();
                    // if(!played)
                    
                    

                    if(sounds.length>0){
                          init_play();
                          
                    }

                    // if(next_page >= total_page)
                    //     next_page = 0;
                    //console.log(sounds);
                }
            });

        }


        tableTimeInterval=setInterval(function(){
            
            // console.log("Page:" + next_page + 'of Total ' + total_page);
            //            if(total_page > 3){
            //                next_page = next_page + 1;
            //                next_page1 = next_page1 + 1;
            //                next_page2 = next_page2 + 1;
            //               // next_page3 = next_page3 + 1;
           
            //                if(next_page>total_page)
            //                next_page=1;
            //                if(next_page1>total_page)
            //                    next_page1=1;
            //                if(next_page2>total_page)
            //                    next_page2=1;
            //                // if(next_page3>total_page)
            //                //     next_page3=1;
           
            //             }
                       
                      
                       table1.ajax.url("<?php echo e(route('admin.calling.getwaiting'), false); ?>?campus=" + selectCampus + '&category=<?php echo e(request("category"), false); ?>&startrow=0&lengthrow=1000').load();
                      
                       
                      
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
            var playPromise=curr_track.play();
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
                
                
                //if(sounds.length>0){
                    delayVoice=setTimeout(() => {
                        if(sounds.length>0){
                          index_track = 0;
                          playsong(sounds[index_track].path);
                         } else{
                          played=false;
                          index_track=0;
                        }
                    }, 5000);
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
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /mnt/wwww/school/resources/views/admin/calling/dashboard-monitoring.blade.php ENDPATH**/ ?>