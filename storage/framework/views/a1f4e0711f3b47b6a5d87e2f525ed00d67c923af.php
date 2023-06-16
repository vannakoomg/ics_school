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


<div class="card" style="width:12.8cm;height:9.9cm">
    <div class="card-body" style="background:rgb(219, 219, 252);padding:10px;">

        <div class="text-left align-top" style="width: 2.5cm !important;height:100%; padding-top:0;display: inline-block;vertical-align: top;">
            
            <img src="<?php echo e(asset('images/logo.png'), false); ?>" width="78px" class="mb-3"> <br/>
            
            <?php if(empty($user->rfidcard)): ?>
                <div style="height:80px;width:90px;border:solid 1px rgb(13, 47, 238)" class="mb-0">
                </div>
            <?php else: ?>
                
                <div class="mb-1">
                <?php echo QrCode::size(80)->generate($user->rfidcard); ?>

                </div>
            <?php endif; ?>
            <br/>
             <div style="height:110px;width:90px;border:solid 1px rgb(13, 47, 238)" class="mb-0">
                <?php if($user->photo): ?>   
                    <img src="<?php echo e(($user->photo ? asset('storage/photo/' . $user->photo ?? '') : asset('storage/image/' . ($user->roles->contains(4) ? 'student-avatar.png' : 'teacher-avatar.png'))), false); ?>" class="" id="img_thumbnail" alt="select thumbnail" width="100%">
                <?php endif; ?>
            </div>
                <br/>
                <p class="p-1 mb-0 text-center" style="background:#fff;width:90px;"> <?php echo e($user->email ?? 'NO ID', false); ?></p>

        </div> 
        
        <div class="text-center d-inline-block" style="padding-left: 10px;vertical-align: top; width:9.5cm;height:100%;">
            
             <img align="center" src="<?php echo e(asset('images/ics_header.png'), false); ?>" height="35px" class="mb-2"> <br/>
            <h3 class="mb-3 text-center" style="color:rgba(18, 18, 233, 0.87)"><strong>COLLECTION CARD</strong></h3>
            <div class="p-1 mb-3 bg-white text-left" style="font-size:14px"><strong>Name: <?php echo e($user->name, false); ?></strong></div>
            <div class="p-1 mb-4 bg-white text-left" style="font-size:14px"><strong>Class: <?php echo e($user->class->name, false); ?></strong></div>
            <div class="text-left mb-0">
                <div class="d-inline-block mb-1" style="padding-top: 10px">
                    <div style="height:110px;width:90px;border:solid 1px rgb(13, 47, 238)" class="text-center">
                    <?php if($user->guardian1): ?>   
                        <img src="<?php echo e(($user->guardian1 ? asset('storage/photo/' . "{$user->id}_guardian1.png" ?? '') : asset('storage/image/guardian-avatar.png')), false); ?>" id="collect_thumbnail1" alt="select thumbnail" width="85px">
                    <?php endif; ?>
                    </div>
                    <br/>
                    <p class="p-1 mb-0 text-center" style="background:#fff;width:90px;"> <?php echo e($user->guardian1 ?? 'Relative 1', false); ?></p>
                </div>
                <div class="d-inline-block mb-0" style="padding-left: 20px;padding-right: 20px;">
                    <div style="height:110px;width:90px;border:solid 1px rgb(13, 47, 238)" class="text-center">
                    <?php if($user->guardian2): ?>   
                        <img src="<?php echo e(($user->guardian2 ? asset('storage/photo/' . "{$user->id}_guardian2.png" ?? '') : asset('storage/image/guardian-avatar.png')), false); ?>"  id="collect_thumbnail2" alt="select thumbnail" height="80px">
                    <?php endif; ?>        
                    </div>
                    <br/>
                   <p class="p-1 mb-0 text-center" style="background:#fff;width:90px;"> <?php echo e($user->guardian2 ?? 'Relative 2', false); ?></p>
                </div>
                <div class="d-inline-block mb-0" style="">
                    <div style="height:110px;width:90px;border:solid 1px rgb(13, 47, 238)" class="text-center">
                     <?php if($user->guardian3): ?>   
                          <img src="<?php echo e(($user->guardian3 ? asset('storage/photo/' . "{$user->id}_guardian3.png" ?? '') : asset('storage/image/guardian-avatar.png')), false); ?>" id="collect_thumbnail3" alt="select thumbnai"  height="80px">
                     <?php endif; ?>
                    </div>
                    <br/>
                    <p class="p-1 mb-0 text-center" style="background:#fff;width:90px;"> <?php echo e($user->guardian3 ?? 'Relative 3', false); ?></p>
                </div>
            </div>
        </div>
        

    </div>

    
    </div>
    
    <a href="<?php echo e(route('admin.users.show', $user->id), false); ?>?print=pdf" class="btn btn-primary">Print Pdf</a>

    <a href="<?php echo e(route('admin.users.index'), false); ?>?role=4" class="btn btn-secondary">Back to List</a>

</div>



<?php $__env->stopSection(); ?>
<?php echo $__env->make((request()->print=="pdf")?'layouts.pdf':'layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/school/resources/views/admin/users/show.blade.php ENDPATH**/ ?>