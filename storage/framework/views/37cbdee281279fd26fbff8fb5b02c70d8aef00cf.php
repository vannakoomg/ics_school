<?php $__env->startSection('styles'); ?>
<link href="<?php echo e(asset('summernote/summernote.min.css'), false); ?>" rel="stylesheet">
<style>
.note-editable { background-color: white !important; color: black !important; }
.dropzone .dz-preview .dz-error-message {
    top: 150px!important;
}

#image-editor {
    
    border: 1px solid #333;
    background: #e5e5e5;
    padding: 0; margin: 0px;
}

</style>


<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12">
          <div class="card">
                <div class="card-header">
                    Assignment: <?php echo e((($viewonly===0)?'Input ':'View'), false); ?> Score
                </div>
   <?php
    $roles=[];

   ?>
    <div class="card-body">

        <div class="row">
            <div class="col-sm-4 shadow p-3 mb-5 bg-body rounded">
                <div class="row g-2">
                    <div class="col-auto align-middle">
                        <label class="align-middle font-weight-bold col-form-label">Term &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    </div>
                    <div class="col">
                        <label class="form-control"><?php echo e(($homework->term), false); ?></label>
                    </div>
                </div>
                <div class="row g-2 align-items-middle">
                    <div class="col-auto align-middle">
                        <label class="align-middle col-form-label font-weight-bold">Class &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    </div>
                    <div class="col">
                        <label class="form-control"><?php echo e($homework->class->name, false); ?></label>
                    </div>
                </div>

                
                <div class="row g-2">
                    <div class="col-auto align-middle">
                        <label class="align-middle col-form-label text-nowrap font-weight-bold">Course &nbsp;&nbsp;&nbsp;</label>
                    </div>
                    <div class="col">
                        <label class="form-control"><?php echo e($homework->course->name, false); ?></label>
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col-auto align-middle">
                        <label class="align-middle col-form-label font-weight-bold">Marks &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    </div>
                    <div class="col">
                        <label class="form-control"><?php echo e($homework->marks, false); ?></label>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-auto align-middle">
                        <label class="font-weight-bold align-middle col-form-label">Due Date</label>
                    </div>
                    <div class="col">
                        <label class="form-control"><?php echo e($homework->due_date->format('d/m/Y H:i:s'), false); ?></label>
                    </div>
                </div>
               

                <div class="row g-2">
                    <div class="col-auto align-middle">
                        <label class="align-middle font-weight-bold col-form-label">Title &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    </div>
                    <div class="col">
                        <label class="form-control"><?php echo e(($homework->name), false); ?></label>
                    </div>
                </div>

                <div class="form-group contain">
                    <label class="font-weight-bold"" for="roles"><?php echo e(trans('Instruction'), false); ?></label>
                   
                    <div class="shadow-sm p-3  bg-body rounded"><?php echo ($homework->description); ?></div>
                </div>
                    <div class="form-group">
                        <input name="deleted_files" type="hidden" value=''/>
                        <label class="font-weight-bold">Attachments</label>
                        <ul class="list-group list-group-numbered" id="imageGallery">
                            <?php $__currentLoopData = $homework->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                               
                               <li class="list-group-item"><a href="<?php echo e($attachment->link, false); ?>" class="result_attach"><?php echo e($attachment->filename, false); ?></a></li>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                        </ul>
        
                        
                    </div>   
                   
          

            </div> 
            <div class="col-auto" style="width: 10px">
            </div>
            <div class="col shadow p-3 mb-5 bg-body rounded"> 

               

                <div class="row g-2 p-2">
                    <div class="col align-middle">
                        <div class="h5">List Assignments Submitted</div>
                    </div>
                    <div class="col text-right">
                        <?php if($viewonly===0): ?>
                            
                        <?php endif; ?>
                    </div>
                </div>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>1st Submit Date</th>
                            <th>Score</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $homeworkresult): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            if(empty($homeworkresult->turnedindate) && strtotime(date('Y-m-d'))>strtotime($homework->due_date))
                                $status= '<span class="badge p-2 badge-warning">Over-due</span>';
                            else if(empty($homeworkresult->turnedindate) && strtotime(date('Y-m-d'))<=strtotime($homework->due_date))
                                $status= '';
                            else if(strtotime($homeworkresult->turnedindate)>strtotime($homework->due_date))
                                $status= '<span class="badge p-2 badge-warning">Over-due</span>';
                            else 
                                $status='<span class="badge p-2 badge-success"></span>';
                            
                        ?>
                        <?php if($viewonly===0): ?>
                            <?php if($homeworkresult->turnedin==1): ?>
                            <tr>
                                <td><?php echo e($homeworkresult->student->email, false); ?></td>
                                <td><?php echo e($homeworkresult->student->name, false); ?></td>
                                <td><?php echo e($homeworkresult->turnedindate->format('d-m-Y'), false); ?></td>
                                <td><input type="hidden" name="trids[]" value="<?php echo e($homeworkresult->id, false); ?>"><?php echo e($homeworkresult->score, false); ?></td>
                                <td><?php echo $status; ?></td>
                                <td><a href="#" data-id='<?php echo e($homeworkresult->student_id, false); ?>' data-value="<?php echo e($homeworkresult->id, false); ?>" class="btn btn-sm p-1 btn-primary btn_view">Reviews & Give Score</a></td>
                            </tr>
                            <?php else: ?>
                            <tr>
                                <td><?php echo e($homeworkresult->student->email, false); ?></td>
                                <td><?php echo e($homeworkresult->student->name, false); ?></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><?php echo $status; ?></td>
                                <td><span><?php echo e($homeworkresult->submit_status, false); ?></span></td>
                            </tr>
                            <?php endif; ?>
                        <?php else: ?>
                                <tr>
                                    <td><?php echo e($homeworkresult->student->email, false); ?></td>
                                    <td><?php echo e($homeworkresult->student->name, false); ?></td>
                                    <td><?php echo e((($homeworkresult->turnedin==1)?$homeworkresult->turnedindate->format('d-m-Y'):''), false); ?></td>
                                    <td><?php echo e($homeworkresult->score, false); ?></td>
                                    <td><?php echo $status; ?></td>
                                    <td><span><?php echo e($homeworkresult->submit_status, false); ?></span></td>
                                </tr>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
              
            </div>
        </div>
        
        <?php if($viewonly===0): ?>
                <a href="<?php echo e(route('admin.homework.index'), false); ?>" class="btn btn-secondary float-right btn_send">
                    <?php echo e(trans('global.back_to_list'), false); ?>

                </a>
         <?php else: ?>
                <a href="<?php echo e(route('admin.homework.completed'), false); ?>" class="btn btn-secondary float-right btn_send">
                    <?php echo e(trans('global.back_to_list'), false); ?>

                </a>
         <?php endif; ?>
    </div>

    

    <form method="POST" enctype="multipart/form-data"  action="<?php echo e(route('admin.homework.savescore',[$homework->id]), false); ?>" >
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <input type="hidden" name="trid" id="trid" value="0"/> 
    <div id="myModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    

                    <h5 class="modal-title">Assignment: Turned-In</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        
                        <div class="col-4" id="model_content">

                        </div>
                  
                        <div class="col-8" id="image-editor">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-12 text-center">
                    
                    <button type="submit" class="btn btn-primary btn_submit">Update</button> 
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    
                    </div>
                </div>
                    
                </div>
            </div>
        </div>
    </div>

    <div id="myModal_small" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    

                    <h5 class="modal-title">Assignment: Turned-In</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        
                        <div class="col-12" id="model_content">

                        </div>
                  
                     
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-12 text-center">
                    
                    <button type="submit" class="btn btn-primary btn_submit">Update</button> 
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    
                    </div>
                </div>
                    
                </div>
            </div>
        </div>
    </div>
  </form>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>

<script src="<?php echo e(asset('js/filerobot-image-editor/filerobot-image-editor.min.js'), false); ?>"></script>
<script src="<?php echo e(asset('js/jquery.image-popup.js'), false); ?>"></script>
<script src="<?php echo e(asset('summernote/summernote-bs4.min.js'), false); ?>"></script>

<script>
var submitted=false;
$('.btn_submit').on("click", function(){

    submitted=true;

});


$("form").on("submit", function (e) {
    if(!submitted)
        e.preventDefault();

        submitted=false;
            console.log(e);
});

    window.onbeforeunload = function () {
        $("input[type=button], input[type=submit]").attr("disabled", "disabled");
    };
    
    $("#imageGallery").imagePopup({
    //overlay: "rgba(0, 100, 0, 0.5)"

    closeButton:{
        src: "<?php echo e(asset('js/images/close.png'), false); ?>",
        width: "40px",
        height:"40px"
    },
    imageBorder: "15px solid #ffffff",
    borderRadius: "10px",
    imageWidth: "auto",
    imageHeight: "90%",
    imageCaption: {
        exist: true,
        color: "#ffffff",
        fontSize: "40px"
    },
    open: function(){
        console.log("opened");
    },
    close: function(){
        console.log("closed");
    }
    });



    $('.btn_view').click(function(e){
        e.preventDefault();
        var trid = $(this).data('value');
        
        //var student_id = $(this).data('id');
        $.ajax({
            type:'get',
            url: "<?php echo e(route('admin.homework.homeworkdetail'), false); ?>",
            data: { trid: trid},
            success: function(result){
                if(result.status=='success'){
                        console.log(result.attatchment);

                        if(result.attachment){
                            $('#myModal').find('#model_content').html(result.html);
                            $('#trid').val(trid);
                            $("#myModal").modal('show');
                        }else{
                            $('#myModal_small').find('#model_content').html(result.html);
                            $('#trid').val(trid);
                            $('#myModal_small').modal('show');
                        }
                      //  

                        // ---------- Image editor ------------
                        
                        var current_attachment = null;
                        const { TABS, TOOLS } = FilerobotImageEditor;
                        const config = {
                        // source: 'https://scaleflex.airstore.io/demo/stephen-walker-unsplash.jpg',
                        // onSave: (editedImageObject, designState) => {
                        //     console.log('saved', editedImageObject, designState);
                        //     return false;
                        // },
                       moreSaveOptions:
                       [
                        {
                            label: 'Download',
                            onClick: (triggerSaveModal, triggerSave) =>
                            triggerSave((...args) => {
                                var tmpLink = document.createElement('a'); 
                                tmpLink.href = args[0].imageBase64; 
                                tmpLink.download = args[0].fullName; 
                                tmpLink.style = 'position: absolute; z-index: -111; visibility: none;'; 
                                document.body.appendChild(tmpLink); 
                                tmpLink.click(); 
                                document.body.removeChild(tmpLink); 
                                tmpLink = null; 
                                console.log('Donwload', args[0].imageBase64);
                            }), // Required to pass the callback function
                            icon: '<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">...</svg>', // HTML Element as string
                        },
                        ],
                        // source: "https://scaleflex.airstore.io/demo/stephen-walker-unsplash.jpg",
                        annotationsCommon: {
                            fill: '#ff0000',
                        },
                        onBeforeSave: () => false,
                        // avoidChangesNotSavedAlertOnLeave:true,
                        closeAfterSave:false,
                        showBackButton:true,
                        Text: { text: 'Text' },
                        Rotate: { angle: 90, componentType: 'slider' },
                        translations: {
                            profile: 'Profile',
                            coverPhoto: 'Cover photo',
                            facebook: 'Facebook',
                            socialMedia: 'Social Media',
                            fbProfileSize: '180x180px',
                            fbCoverPhotoSize: '820x312px',
                        },
                        // disableZooming:true,
                        useZoomPresetsMenu:false,
                        Crop: {
                            presetsItems: [
                            {
                                titleKey: 'classicTv',
                                descriptionKey: '4:3',
                                ratio: 4 / 3,
                                // icon: CropClassicTv, // optional, CropClassicTv is a React Function component. Possible (React Function component, string or HTML Element)
                            },
                            {
                                titleKey: 'cinemascope',
                                descriptionKey: '21:9',
                                ratio: 21 / 9,
                                // icon: CropCinemaScope, // optional, CropCinemaScope is a React Function component.  Possible (React Function component, string or HTML Element)
                            },
                            ],
                            presetsFolders: [
                            {
                                titleKey: 'socialMedia', // will be translated into Social Media as backend contains this translation key
                                // icon: Social, // optional, Social is a React Function component. Possible (React Function component, string or HTML Element)
                                groups: [
                                {
                                    titleKey: 'facebook',
                                    items: [
                                    {
                                        titleKey: 'profile',
                                        width: 180,
                                        height: 180,
                                        descriptionKey: 'fbProfileSize',
                                    },
                                    {
                                        titleKey: 'coverPhoto',
                                        width: 820,
                                        height: 312,
                                        descriptionKey: 'fbCoverPhotoSize',
                                    },
                                    ],
                                },
                                ],
                            },
                            ],
                        },
                        tabsIds: [TABS.ANNOTATE],//[TABS.ADJUST, TABS.ANNOTATE, TABS.WATERMARK, TABS.FINETUNE,TABS.FILTERS,TABS.RESIZE], // or ['Adjust', 'Annotate', 'Watermark']
                        defaultTabId: TABS.ANNOTATE, // or 'Annotate'
                        defaultToolId: TOOLS.TEXT, // or 'Text'
                        };

                        // Assuming we have a div with id="editor_container"
                       
                        const onBeforeComplete = (editedImageObject, designState) => {
                        
                       // console.log('saved', editedImageObject, designState, current_attachment);

                        let imageBase64 = editedImageObject.imageBase64;
                      
                        //Download option

                        //                         var tmpLink = document.createElement('a'); 
                        //   tmpLink.href = editedImageObject.imageBase64; 
                        //   tmpLink.download = editedImageObject.fullName; 
                        //   tmpLink.style = 'position: absolute; z-index: -111; visibility: none;'; 
                        //   document.body.appendChild(tmpLink); 
                        //   tmpLink.click(); 
                        //   document.body.removeChild(tmpLink); 
                        //   tmpLink = null; 

                        // console.log("props is: ", props);
                        // console.log("props is: ", props.canvas.toDataURL());
                        // console.log(base64ToBlob(imageBase64));

                        const formdata = new FormData
                        formdata.append('trid', $(current_attachment).find('a').data('id'));
                        formdata.append('imageFile', base64ToBlob(imageBase64));
                        formdata.append('imageName', editedImageObject.fullName)
                        // imageName= "<?php echo e(asset('storage/docs/'), false); ?>/" + props.imageName;
                        // imageFile = base64ToBlob(imageBase64);
                        $.ajax({
                            type:'post',
                            url: "<?php echo e(route('admin.homework.updateimgae'), false); ?>",
                            contentType: false,
                            processData: false,
                            data: formdata,
                     
                            success: function(result){
                                if(result.status=='success'){
                                    $(current_attachment).find('a').html(result.filename);
                                    // $(current_attachment).trigger("click");
                                }
                               
                                
                            }
                        });
                            return false;
                        }

                        call_imageeditor = function (e) {                            
                            //let image = this.getElementsByTagName('img')[0]
                            allowedfileExtension=['jpg','png','gif'];
                            
                            let image = this.getElementsByTagName('a')[0];
                            
                            if($.inArray($(image).data('type'),allowedfileExtension)==-1)
                                return true;
                            
                            e.preventDefault();

                            current_attachment = this;
                           
                            config.source = $(image).attr('href') + '?t=' + new Date();
                            
                            config.onSave = onBeforeComplete;
                            
                            const filerobotImageEditor = new FilerobotImageEditor(
                            document.querySelector('#image-editor'),
                            config
                            );

                            filerobotImageEditor.render({
                            onClose: (closingReason) => {
                                console.log('Closing reason', closingReason);
                                filerobotImageEditor.terminate();
                            },
                            });

                            
                        };

                        let imagesToEdit = document.getElementsByClassName('image-to-edit')

                        for (let i = 0; i < imagesToEdit.length; i++) {
                        const element = imagesToEdit[i];
                        element.onclick = call_imageeditor
                        
                        }

                        if(imagesToEdit.length>0){
                            console.log('laod ....');
                            const element = imagesToEdit[0];
                            //let image = this.getElementsByTagName('img')[0]
                            $(element).trigger( "click" );
                        }


                        const base64ToBlob = (base64) => {
                        const bytes = atob(base64.split(',')[1]);
                        const mime_type = base64.split(',')[0].split(';')[0].split(':')[1]
                        const aB = new ArrayBuffer(bytes.length)
                        const u8B = new Uint8Array(aB)
                        for (let i = 0; i < bytes.length; i++) {
                            u8B[i] = bytes.charCodeAt(i)
                        }
                        return new Blob([aB], {type: mime_type})
                        }


                    }

                        
                //         const config = {
                //             cloudimage: {
                //                 token: 'dabkfabvu',
                            
                //             },
                           
                //         };

                //         const onComplete = (url, file) => {
                //         console.log("the file url is: ", url);
                //         console.log("the main file: ", file);
                //         }



                //         const onBeforeComplete = (props) => {
                //         let imageBase64 = props.canvas.toDataURL()
                      
                //         console.log("props is: ", props);
                //         console.log("props is: ", props.canvas.toDataURL());
                //         console.log(base64ToBlob(imageBase64));

                //         const formdata = new FormData
                //         formdata.append('trid', trid);
                //         formdata.append('imageFile', base64ToBlob(imageBase64));
                //         formdata.append('imageName', props.imageName)
                //         // imageName= "<?php echo e(asset('storage/docs/'), false); ?>/" + props.imageName;
                //         // imageFile = base64ToBlob(imageBase64);
                //         $.ajax({
                //             type:'post',
                //             url: "<?php echo e(route('admin.homework.updateimgae'), false); ?>",
                //             contentType: false,
                //             processData: false,
                //             data: formdata,
                     
                //             success: function(result){

                //             }
                //         });

                // //         fetch('<?php echo e(route('admin.homework.updateimgae'), false); ?>', {
                // //             headers: {
                // // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                // // },
                // //             body: formdata,
                // //             method: 'POST',
                // //         }).then(res => res.json()).then(data => 
                // //         console.log(data)
                // //         )

                //         }

                        


                //         let imagesToEdit = document.getElementsByClassName('image-to-edit')

                //         for (let i = 0; i < imagesToEdit.length; i++) {
                //         const element = imagesToEdit[i];
                //         element.onclick = function (e) {
                //             e.preventDefault();
                //             //let image = this.getElementsByTagName('img')[0]
                //             let image = $(this).find('a');
                //             const ImageEditor = new FilerobotImageEditor(config, {
                //             onComplete: onComplete,
                //             onBeforeComplete: onBeforeComplete,
                //             onClose: () => {
                //                 ImageEditor.unmount()
                //             }
                //             });
                //             ImageEditor.open(image.attr('href'));
                            
                //         }
                        
                //         }

                

            }
            
          
        });
        

    });

    


     $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
    });

    
//    $('#upload_image_form').submit(function(e) {

//      e.preventDefault();
   
//      if($('#imgupload').val()==''){
//          alert('Picture is required.');
//          return false;
//      }

//      btn_send = $('.btn_send');

//      btn_send.prop('disabled', true);

//      $('#txt_body_hidden').val($('#txt_body').summernote('code'));

//      var formData = new FormData(this);

//      $.ajax({
//         type:'POST',
//         url: "<?php echo e(route('admin.announcement.store'), false); ?>",
//         data: formData,
//         cache:false,
//         contentType: false,
//         processData: false,
//         success: (data) => {
           
//             btn_send.prop('disabled', false);
//            //this.reset();
//         //    $('#txt_body').summernote('reset');
//         //    $('#txt_class').val('');
//         //    $('#img_thumbnail').attr('src','<?php echo e(asset('images/blank.jpeg'), false); ?>');
//            alert('The Announcement has been added.');
          
//            window.location = data.edit_link ;
//         },
//         error: function(data){
//            console.log(data);
//          }
//        });
//    });


// to download the file use filesaver, link is:
// https://www.npmjs.com/package/file-saver



</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/laravel/school/resources/views/admin/homework/show.blade.php ENDPATH**/ ?>