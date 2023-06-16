<!DOCTYPE html>
<html>

<head>
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="csrf-token" content="<?php echo e(csrf_token(), false); ?>">

    <title><?php echo e(trans('panel.site_title'), false); ?></title>
    
    
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet"/>
    <link href="<?php echo e(asset('css/bootstrap.css'), false); ?>" rel="stylesheet" />
   
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer&display=swap" rel="stylesheet">
    
    <style>

        .title_header1 {
            font-family:'centuryschoolbookbold' !important;
            font-weight:bold !important;
            font-size:110%;
            line-height: 1.2em;
        }

        .title_header2 {
            font-family:'centuryschoolbookbold' !important;
            font-weight:bold !important;
            font-size:80%
        }

        .khmer_os {
            font-family: 'khmerosbattambong','Century Schoolbook';
            font-size:95%;
        }

        .table-bordered thead tr > th {
            border:solid 1px #000 !important;
            padding: 5px;
        }

        .table-bordered tbody tr > td {
            border:solid 1px #000 !important;
            padding: 5px;
        }

        .breaktime-bg-primary {
            background-color: rgb(244,190,156);
        }

        .breaktime-color-primary {
            /* font-weight: bold; */
            color: rgb(231, 0, 8);
        }

        .study-color-primary {
           color: #0064C2;
        }

        .breaktime-bg-secondary {
            background-color: rgb(201, 57, 59);
        }

        .breaktime-color-secondary {
            /* font-weight: bold; */
            color: #0000009c;
        }

        .study-color-secondary {
           color: #000000;
        }

        .page-break {
            page-break-after: always;
        }

        

        .breaktime-bg-kindergarten {
           background-color: #FFBDA6;
        }

        .breaktime-color-kindergarten {
            /* font-weight: bold; */
           color: #AE3248 !important;
        }

        .study-color-kindergarten {
           color: #0064C2;
        }


        .header-primary {
            font-weight: bold;
            background-color: rgb(185,219,164);
        }

        .header-secondary {
            font-weight: bold;
            background-color: rgba(15, 60, 184, 0.747);
            color: #000000;
        }

        .header-kindergarten  {
            font-weight: bold;
            background-color: rgb(132,224,130);
            color: #000000;
        }

        .div_position {
            text-align: center;
            position: absolute; 
    

            right:50px;
            /* margin: 10px 0 0 0; */
            float: right;
            width:250px;
        }
        

        @media  print {
            .main_header{
                display: none !important;
            }
            /* .div_position {
            text-align: center;
            position: relative;
            right:30px;
            margin: 10px 0 0 0;
            float: right;
            width:300px;
        }  */

            .background-primary {

            background-color: #EFCBAF !important;

            }

            .color-primary {
            font-weight: bold;
            color: rgb(255, 0, 0);

            }

            .header-primary {
            background-color: #CADEB8 !important;
            }

            .text-primary {
            color: #0b5cf3;
            }
        }
     </style>

</head>

<body style="background-color:#fff;margin:10px;">  
    
    <form name="frmcampus" method="get" action="<?php echo e(route("admin.timetable.exporttimetable"), false); ?>" enctype="multipart/form-data">
    <div class="row main_header" style="display: <?php echo e(request()->input('btn_submit')=='Print Pdf' ? 'none':'', false); ?>">
       
        <div class="col-1">
            &nbsp;
        </div>
        <div class="col-2">
            <div class="form-group row">
                <label class="required col-sm-3 col-form-label" for="class_id">Campus</label>
                <div class="col-sm-9">
                      <select  class="custom-select <?php echo e($errors->has('campus') ? 'is-invalid' : '', false); ?>" name="campus" id="campus" onchange="document.forms['frmcampus'].submit()">
                          <?php $__currentLoopData = $campus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          
                              <option value="<?php echo e($key, false); ?>" <?php echo e(strtolower(request()->input('campus') ?? 'MC') == strtolower($key) ? 'selected' : '', false); ?>><?php echo e($key, false); ?></option>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                </div>      
              </div>
            </div>
          
            <div class="col-3">    
                  <div class="form-group row">
                      <label class="required col-sm-3 col-form-label" for="class_id"><?php echo e(trans('cruds.lesson.fields.class'), false); ?></label>
                      <div class="col-sm-9">
                      <select class="custom-select select2 <?php echo e($errors->has('class') ? 'is-invalid' : '', false); ?>" name="class_id[]" id="class_id"  multiple>
                          <?php $__currentLoopData = $allclasses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          
                               <?php if( strtolower($class->campus) == strtolower(request()->input('campus') ?? 'MC')): ?> 
                                    <option value="<?php echo e($class->id, false); ?>" <?php echo e(in_array($class->id,request()->input('class_id',[])) ? 'selected' : '', false); ?> ><?php echo e($class->name, false); ?></option>
                                <?php endif; ?>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                      <?php if($errors->has('class')): ?>
                          <div class="invalid-feedback">
                              <?php echo e($errors->first('class'), false); ?>

                          </div>
                      <?php endif; ?>
                      <span class="help-block"><?php echo e(trans('cruds.lesson.fields.class_helper'), false); ?></span>
                      </div>
                  </div>
             </div>
             <div class="col-1">
                <div class="form-group row">
                   
                    <label class="col-sm-2 col-form-label">Show Saturday</label>
                    <div class="col-sm-10">
                         <input type="checkbox" name="btn_saturday" class="form-check-input" value="1" <?php echo e(request()->has('btn_saturday') ? 'checked':'', false); ?>/>
                    </div>
                </div>
            </div>

             <div class="col-3">    
                <div class="form-group row">

                    <p>&nbsp;</p>
                    
                    <div class="col-12">
                        
                    <input type="submit" class="btn btn-primary" name="btn_submit" value="Preview">
                    <input type="submit" class="btn btn-primary" name="btn_submit" value="Print Pdf">
                    <a href="<?php echo e(route('admin.timetable.create'), false); ?>" class="btn btn-success">Back to Timetable</a>
                    </div>
                </div>
             </div>
             
    </div>
    </form>
    <?php $__currentLoopData = $timetables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        

      
    <?php $__currentLoopData = $class->timetables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
     
    <?php if(strtolower($k)=='odd'): ?>
                <div class="border rounded p-3 shadow div_position" style="font-size:80%">
                <h5 class="text-primary">ODD MONTHS</h5>
                Use for September, November, January, March, May, July
            </div>
            <?php elseif(strtolower($k)=='even'): ?>
                <div class="border rounded p-3 shadow div_position" style="font-size:80%">
                    <h5 class="text-primary">EVEN MONTHS</h5>
                    Use for August, October, December, February , April, June
                </div>
            <?php endif; ?>

    <div class="row">
        <div class="col-lg text-center">  
            <?php if(request()->btn_submit=='Preview'): ?>
                <img src="<?php echo e(asset('images/ics_header.png'), false); ?>" height="50px">
            <?php else: ?>
                 <img src="<?php echo e(public_path('images/ics_header.png'), false); ?>" height="50px">
            <?php endif; ?>
            
          <p class="mb-0 p-0 title_header1">Class Schedule<br/>
          School Year <?php echo e(date('Y'), false); ?> - <?php echo e(date('Y')+1, false); ?><br/>
          <?php echo e($class->class->name ?? '', false); ?></p>
        </div>
       
      </div>

     
       
        <table width="100%" class="khmer_os">
            <tr>
              <td class="text-nowrap" style="font-size:110%">
           
                  <p class="title_header2">Homeroom: <?php echo e($class->class->homeroom, false); ?><br/>
                  Khmer Teacher:  <?php echo e($class->class->khmerteacher, false); ?><br/>
                  Teacher Aide: </strong> <?php echo e($class->class->teacheraide, false); ?>

                  </p>
              </td>

              <td class="text-right text-nowrap">
               
                  <label>&nbsp;</label> <br/>
                  <p class="title_header2">Room: <?php echo e($class->class->roomno, false); ?></p>
                  <label>&nbsp;</label>
               
              </td>
            </tr>
        </table>
       <?php
           if(request()->has('btn_saturday'))
                $width="12%";
            else {
                $width="17%";
            }
       ?> 
      <table class="khmer_os" id="tbl_timetable" width="100%" style="font-family:khmerosmoullight;" border="1" cellpadding="8">
        <thead class="text-center">
          <tr class="
           
           <?php if(strtolower($class->class->level_type)=='primary'): ?>
                    header-primary 
            <?php elseif(strtolower($class->class->level_type)=='secondary'): ?>
                     header-secondary
            <?php elseif(strtolower($class->class->level_type)=='kindergarten'): ?>
                    header-kindergarten
            <?php endif; ?>
          ">
            <th style="text-align:center"  width="125">TIME</th>
            <th style="text-align:center" width="<?php echo e($width, false); ?>">MONDAY</th>
            <th style="text-align:center" width="<?php echo e($width, false); ?>">TUESDAY</th>
            <th style="text-align:center" width="<?php echo e($width, false); ?>">WEDNESDAY</th>
            <th style="text-align:center" width="<?php echo e($width, false); ?>">THURSDAY</th>
            <th style="text-align:center" width="<?php echo e($width, false); ?>">FRIDAY</th>
            <?php if(request()->has('btn_saturday')): ?>
                <th style="text-align:center" width="<?php echo e($width, false); ?>">SATURDAY</th>
            <?php endif; ?>
          </tr>
        </thead>
        <tbody>
            <?php
              $pp=0;
            ?>

            <?php $__currentLoopData = $template; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $timetable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $pp++;

                $days = ['monday','tuesday','wednesday','thursday','friday']; //'saturday'

                if (request()->has('btn_saturday'))
                    $days[]='saturday';
                $data=[];

                foreach ($days as $day) {
                        $data[$day] = [
                        'course' => '', //$timetable->getcourse($day),
                        'teacher' => '', //$timetable->getteacher($day),
                    ];     
                }
        
            ?>
            <tr>
                <td class="text-nowrap align-middle text-center">
                    <?php echo e($timetable->time ?? '', false); ?>

                </td>
                <?php if(strtolower($timetable->breaktime)!='study time'): ?>
                    <td colspan="<?php echo e(count($days), false); ?>" class="text-center align-middle khmer_os 
                     
                    <?php if($pp>1): ?>
                        <?php if(strtolower($class->class->level_type)=='primary'): ?>
                                breaktime-bg-primary breaktime-color-primary
                        <?php elseif(strtolower($class->class->level_type)=='secondary'): ?>
                                breaktime-bg-secondary breaktime-color-secondary
                        <?php elseif(strtolower($class->class->level_type)=='kindergarten'): ?>
                                breaktime-bg-kindergarten breaktime-color-kindergarten
                        <?php endif; ?>
                    <?php endif; ?>
                    ">
                        <?php echo e($timetable->breaktime, false); ?>

            
                    </td>
                 
                <?php else: ?>
                
                    <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <td class="text-center align-middle khmer_os
                        
                        <?php if(strtolower($class->class->level_type)=='primary'): ?>
                                study-color-primary 
                        <?php elseif(strtolower($class->class->level_type)=='secondary'): ?>
                                study-color-secondary
                        <?php elseif(strtolower($class->class->level_type)=='kindergarten'): ?>
                                study-color-kindergarten
                        <?php endif; ?>
                        ">
                            <?php echo $timetable->{$day} ?? '&nbsp;'; ?>

                            
                            
                            
                          
                        </td>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    
                <?php endif; ?>
                
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
        </tbody>
    </table>
    <p>&nbsp;</p>
    <div class="page-break">
    </div>            
    
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
    <script>
        $(document).ready(function () {
          $('.select2').select2()
        });
    </script>
</body>


</html>

<?php /**PATH /var/www/school/resources/views/admin/lessons/exporttimetable.blade.php ENDPATH**/ ?>