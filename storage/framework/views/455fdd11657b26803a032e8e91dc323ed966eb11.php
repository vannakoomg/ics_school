



<?php $__env->startSection('content'); ?>
<style>
.page-break {
    page-break-after: always;
}

.list-inline {
	list-style: none;
	margin-left: -0.5em;
	margin-right: -0.5em;
	padding-left: 0;
}

/**
 * @bugfix  Prevent webkit from removing list semantics
 * https://www.scottohara.me/blog/2019/01/12/lists-and-safari.html
 * 1. Add a non-breaking space
 * 2. Make sure it doesn't mess up the DOM flow
 */
.list-inline > li:before {
	content: "\200B"; /* 1 */
	position: absolute; /* 2 */
}

.list-inline > li {
	display: inline-block;
	margin-left: 0.5em;
	margin-right: 0.5em;
    vertical-align: top;
}
</style>


<div class="card">

  
        <div class="card-body mb-2">
            <?php if($user == null): ?>
              <a href="<?php echo e(route('admin.users.pickup_report'), false); ?>?student&campus=<?php echo e(request()->input('campus') ?? 'MC', false); ?>&class=<?php echo e(request()->input('class') ?? $selected_class->id, false); ?>&btn_pdf_front" class="btn btn-primary float-left m-2">Print Pdf (Front Side)</a>
              <a href="<?php echo e(route('admin.users.pickup_report'), false); ?>?student&campus=<?php echo e(request()->input('campus') ?? 'MC', false); ?>&class=<?php echo e(request()->input('class') ?? $selected_class->id, false); ?>&btn_pdf_back" class="btn btn-primary float-left m-2">Print Pdf (Back Side)</a>
            <?php else: ?>
            <a href="<?php echo e(route('admin.users.show', $user), false); ?>?print=pdf_front" class="btn btn-primary float-left m-2">Print Pdf (Front Side)</a>
            <a href="<?php echo e(route('admin.users.show', $user), false); ?>?print=pdf_back" class="btn btn-primary float-left m-2">Print Pdf (Back Side)</a>
            <?php endif; ?>
            <a href="javascript:history.back()" class="btn btn-secondary float-right">Back to List</a>
        </div>
   
    
    <?php
        if($user != null){
            $users=[$user];
        }
    ?>
    
  

    <table border="0" class="table table-borderless">
        <tr>
            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <td>
                <div class="card-body text-center" style="background:rgb(219, 219, 252);padding-left:10px;padding-right:0px; width:15cm;height:10cm;">
                    <?php if(empty($user->rfidcard)): ?>
                        <div style="height:110px;width:110px;border:solid 1px rgb(13, 47, 238);position: absolute;" class="mb-0">
                            
                        </div>
                    <?php else: ?>
                        
                        <div class="mb-1 text-center" style="position: absolute;">
                        <div style="height: 7px"></div>
                        <?php echo QrCode::size(110)->generate($user->rfidcard); ?>

                        </div>
                    <?php endif; ?>

                    
                    <h3 class="mb-3 text-center" style="color:rgba(18, 18, 233, 0.87)"><strong>PICK UP CARD</strong></h3>
                    
                    <div class="text-left align-top float-left">
                    
                       
                        
                      
                        
                         <div style="height:130px;width:110px;margin-top:110px;overflow:hidden;border:solid 1px rgb(13, 47, 238)" class="mb-0">
                            <?php if($user->photo): ?>    
                                <img src="<?php echo e(($user->photo ? asset('storage/photo/' . $user->photo ?? '') : asset('storage/image/' . ($user->roles->contains(4) ? 'student-avatar.png' : 'teacher-avatar.png'))), false); ?>" class="" id="img_thumbnail" alt="select thumbnail" width="100%">
                            <?php endif; ?>
                        </div>
                            <br/>
                            <p class="p-1 mb-0 text-center" style="background:#fff;width:110px;"> <?php echo e($user->email ?? 'NO ID', false); ?></p>
            
                    </div> 
                    
                    <div class="text-center float-right" style="width:11.2cm;padding-right:20px;padding-left:0px">
                        
                        <div class="p-1 mb-3 bg-white text-left" style="font-size:14px;">
                            <strong>Name: <?php echo e($user->name, false); ?></strong>
                        </div>
                        <div class="p-1 mb-4 bg-white" style="font-size:14px;">
                            <span class="float-left"><strong>Class: <?php echo e(str_replace("Morning","",str_replace("Afternoon","", $user->class->name)), false); ?></strong></span>&nbsp;
                            <span class="float-right"><strong>School Year: <?php echo e((date('Y')-1) . '-' . date('Y'), false); ?></strong></span>
                        </div>
                        <div class="text-left mb-0">
                            <div class="d-inline-block mb-1" style="padding-top: 12px;">
                                <div style="height:130px;width:110px;overflow:hidden;border:solid 1px rgb(13, 47, 238)" class="text-center">
                                <?php if($user->guardian1): ?>   
                                    <img src="<?php echo e(($user->guardian1 ? asset('storage/photo/' . "{$user->id}_guardian1.png" ?? '') : asset('storage/image/guardian-avatar.png')), false); ?>" id="collect_thumbnail1" alt="select thumbnail" width="100%">
                                <?php endif; ?>
                                </div>
                                <br/>
                                <p class="p-1 mb-0 text-center" style="background:#fff;width:110px;"> <?php echo e($user->guardian1 ?? 'Relative 1', false); ?></p>
                            </div>
                            <div class="d-inline-block mb-0" style="padding-left: 30px;padding-right: 30px;">
                                <div style="height:130px;width:110px;overflow:hidden;border:solid 1px rgb(13, 47, 238)" class="text-center">
                                <?php if($user->guardian2): ?>   
                                    <img src="<?php echo e(($user->guardian2 ? asset('storage/photo/' . "{$user->id}_guardian2.png" ?? '') : asset('storage/image/guardian-avatar.png')), false); ?>"  id="collect_thumbnail2" alt="select thumbnail" width="100%">
                                <?php endif; ?>        
                                </div>
                                <br/>
                               <p class="p-1 mb-0 text-center" style="background:#fff;width:110px;"> <?php echo e($user->guardian2 ?? 'Relative 2', false); ?></p>
                            </div>
                            <div class="d-inline-block mb-1" style="">
                                <div style="height:130px;width:110px;overflow:hidden;border:solid 1px rgb(13, 47, 238)" class="text-center">
                                 <?php if($user->guardian3): ?>   
                                      <img src="<?php echo e(($user->guardian3 ? asset('storage/photo/' . "{$user->id}_guardian3.png" ?? '') : asset('storage/image/guardian-avatar.png')), false); ?>" id="collect_thumbnail3" alt="select thumbnai"  width="100%">
                                 <?php endif; ?>
                                </div>
                                <br/>
                                <p class="p-1 mb-0 text-center" style="background:#fff;width:110px;"> <?php echo e($user->guardian3 ?? 'Relative 3', false); ?></p>
                            </div>
                        </div>
                    </div>
                    
            
                </div>
            </td>
            <?php if(($index+1)%2==0): ?>
                <tr>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </tr>
    </table>
    
    
 
  
  

    </div>
    


</div>



<?php $__env->stopSection(); ?>
<?php echo $__env->make((request()->print=="pdf")?'layouts.pdf':'layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wrok_in_ics\web_backend\resources\views/admin/users/show.blade.php ENDPATH**/ ?>