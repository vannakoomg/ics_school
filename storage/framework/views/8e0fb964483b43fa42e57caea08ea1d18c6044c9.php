<?php $__env->startSection('styles'); ?>

    <style>
    #cardSlots {
  padding: 10px 10px;
  /* background: #ddf; */
}

.list-group-item {
    position: relative;
    display: block;
    padding: 7px 10px; /* adjust here */
    margin-bottom: -1px;
    border: 1px solid #ddd;
    line-height: 1em /* set to text height */
}

/* The initial pile of unsorted cards */

/* #cardPile {
  margin: 0 auto;
  background: #ffd;
} */

/* 
#cardSlots, #cardPile {
  width: 100%;
  height: 120px;
  padding: 20px;
  border: 2px solid #333;
  -moz-border-radius: 10px;
  -webkit-border-radius: 10px;
  border-radius: 10px;
  -moz-box-shadow: 0 0 .3em rgba(0, 0, 0, .8);
  -webkit-box-shadow: 0 0 .3em rgba(0, 0, 0, .8);
  box-shadow: 0 0 .3em rgba(0, 0, 0, .8); 


 #cardSlots div, #cardPile div {
  float: left;
  width: 58px;
  height: 78px;
  padding: 10px;
  padding-top: 40px;
  padding-bottom: 0;
  border: 2px solid #333;
  -moz-border-radius: 10px;
  -webkit-border-radius: 10px;
  border-radius: 10px;
  margin: 0 0 0 10px;
  background: #fff;
} 

*/

#cardSlots div:first-child, #cardPile div:first-child {
  margin-left: 0;
}

#cardSlots div div.hovered {
  background: #aaa;
  /* border-color: #000000; */
}

#cardSlots div div{
  border-style: dashed;
}



#cardPile .btn_teacher.ui-draggable-dragging {
  -moz-box-shadow: 0 0 .5em rgba(0, 0, 0, .8);
  -webkit-box-shadow: 0 0 .5em rgba(0, 0, 0, .8);
  box-shadow: 0 0 .5em rgba(0, 0, 0, .8);
}

/* Individually coloured cards */

/* #card1.correct { background: red; }
#card2.correct { background: brown; }
#card3.correct { background: orange; }
#card4.correct { background: yellow; }
#card5.correct { background: green; }
#card6.correct { background: cyan; }
#card7.correct { background: blue; }
#card8.correct { background: indigo; }
#card9.correct { background: purple; }
#card10.correct { background: violet; } */
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="card">
    <div class="card-header">
    <div class="row">
      <div class="col-lg">  
        <h3>Template: <?php echo e($scheduletemplate->name, false); ?>,  Type: <?php echo e($scheduletemplate->type, false); ?> </h3>
      </div> 
    </div>

    <div class="card-body">
          <?php if(!empty($scheduletemplatedetail)): ?>
            <form name="frmtimetable" method="POST" action="<?php echo e(route("admin.scheduletemplatedetail.update", $scheduletemplatedetail->id), false); ?>" enctype="multipart/form-data">  
            <?php echo method_field('PUT'); ?>
          <?php else: ?>
            <form name="frmtimetable" method="POST" action="<?php echo e(route("admin.scheduletemplatedetail.create"), false); ?>" enctype="multipart/form-data">  
          <?php endif; ?>
            <?php echo csrf_field(); ?>
            
            <input type="hidden" name="template_id" value="<?php echo e($scheduletemplate->id, false); ?>">
            <div class="row">  
    
            <div class="col-2">  
            <div class="form-group">
                <label class="required" for="start_time"><?php echo e(trans('cruds.lesson.fields.start_time'), false); ?></label>
                <input class="form-control lesson-timepicker <?php echo e($errors->has('start_time') ? 'is-invalid' : '', false); ?>" type="text" name="start_time" id="start_time" value="<?php echo e(old('start_time', $scheduletemplatedetail->start_time ?? ''), false); ?>" required>
                <?php if($errors->has('start_time')): ?>
                    <div class="invalid-feedback">
                        <?php echo e($errors->first('start_time'), false); ?>

                    </div>
                <?php endif; ?>
                <span class="help-block"><?php echo e(trans('cruds.lesson.fields.start_time_helper'), false); ?></span>
            </div>
            </div>

            <div class="col-2">  
            <div class="form-group">
                <label class="required" for="end_time"><?php echo e(trans('cruds.lesson.fields.end_time'), false); ?></label>
                <input class="form-control lesson-timepicker <?php echo e($errors->has('end_time') ? 'is-invalid' : '', false); ?>" type="text" name="end_time" id="end_time" value="<?php echo e(old('end_time', $scheduletemplatedetail->end_time ?? ''), false); ?>" required>
                <?php if($errors->has('end_time')): ?>
                    <div class="invalid-feedback">
                        <?php echo e($errors->first('end_time'), false); ?>

                    </div>
                <?php endif; ?>
                <span class="help-block"><?php echo e(trans('cruds.lesson.fields.end_time_helper'), false); ?></span>
            </div>
            </div>

            <div class="col-2">  
              <div class="form-group">
                <?php
                 // $breaktimes=['Study Time'=>'Study Time','Break time'=>'Break Time','Lunch Break'=> 'Lunch Break'];   
                ?>
                  <label class="" for="start_time">Break Time</label>
                  <select name="breaktime" class="custom-select">
                       <?php $__currentLoopData = $breaktimes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value, false); ?>" <?php echo e(old('breaktime', $scheduletemplatedetail->breaktime ?? '') == $value ? 'selected' : '', false); ?>><?php echo e($value, false); ?></option>
                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                        
                  </select>
              </div>
              </div>
     
            <div class="col-2">  
            <div class="form-group">
              <label>&nbsp;</label>
                <button class="btn btn-primary form-control" type="submit">
                    <?php if(!empty($scheduletemplatedetail)): ?>
                      <?php echo e(trans('global.save'), false); ?> Time
                    <?php else: ?>
                      <?php echo e(trans('global.add'), false); ?> Time
                    <?php endif; ?>
                    
                </button>         
            </div>
            </div>
            <div class="col-2">  
              <div class="form-group">
                <label>&nbsp;</label><br/>
                 <a href="<?php echo e(route('admin.scheduletemplate.index'), false); ?>" class="btn btn-success">Back to Template List</a>
              </div>    
            </div>
            </div>
          </form>
          <hr/>
        
        <?php echo $__env->make('admin.scheduletemplate.schedule', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##


<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script>

// $( init );
correctCards = 0;
// function init() {


  $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
  });

//   // Reset the game
//   correctCards = 0;
//   $('#cardPile').html( '' );
//   $('#cardSlots').html( '' );

//   // Create the pile of shuffled cards
//   var numbers = [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ];
//   numbers.sort( function() { return Math.random() - .5 } );

//   for ( var i=0; i<10; i++ ) {
//     $('<div>' + numbers[i] + '</div>').data( 'number', numbers[i] ).attr( 'id', 'card'+numbers[i] ).appendTo( '#cardPile' ).draggable( {
//       containment: '#content',
//       stack: '#cardPile div',
//       cursor: 'move',
//       revert: true
//     } );
//   }

//   var words = [ 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten' ];
//   for ( var i=1; i<=10; i++ ) {
//     $('<div>' + words[i-1] + '</div>').data( 'number', i ).appendTo( '#cardSlots' ).droppable( {
//       accept: '#cardPile div span',
//       hoverClass: 'hovered',
//       drop: handleCardDrop
//     } );
//   }

// }



    $('#save_timetable').click(function(){

        var table = $('#tbl_timetable');

        table.find('tr').each(function(i){
          var $tds = $(this).find('td'),
              time = $tds.eq(0).text();
          console.log(time);   
        });
    })

    $('#teacher .btn_teacher').draggable( {
      containment: '.card-body',
      stack: '#teacher .btn_teacher',
      cursor: 'move',
      revert: true,
      helper: 'clone',
      opacity: 0.40,
    //   drag: handleCardDrag,
    } );

    $('#course .btn_course').draggable( {
      containment: '.card-body',
      stack: '#course .btn_course',
      cursor: 'move',
      revert: true,
      helper: 'clone',
      opacity: 0.40,
    //   drag: handleCardDrag,
    } );

    var limit = 1;
    var count_course = 0;
    var count_teacher=[];


    $('#body td').droppable( {
      accept: '.btn_course , .btn_teacher',
      activeClass: "ui-state-default",
      hoverClass: 'hovered',
      drop: handleCardDrop
    } );

    $(document).on("dblclick",'td > li.btn_teacher, td > li.btn_course',function(e){
      var obj = $(this).parents('td');
      var item = $(this);
      var formData = {'column_name': obj.data('column') , 'item': item.hasClass('btn_course')?'course':'teacher','value': item.data('value')};

      $.ajax({
          type:'POST',
          url: obj.data('urlremove'),
          data: formData,
          cache:false,
         // contentType: false,
         // processData: false,
          success: (data) => {
            
            if(data.status){
              //console.log('ddd' + item);
              if(item.hasClass('btn_teacher')){
                  obj.data('countteacher', parseInt(obj.data('countteacher'))-1);
                  item.remove();
              }else if($(this).hasClass('btn_course')){
                  obj.data('countcourse', parseInt(obj.data('countcourse'))-1);
                  item.remove();

              }

              }
          //  console.log("Response Success: " + data.data);

          },
          error: function(data){
            console.log(data);
          }
        });
  

      
      
    });
    
    // function removeItSelf(){
    

    //   if($(this).hasClass('btn_teacher')){
    //        $(this).parents('td').data('countteacher', parseInt($(this).parents('td').data('countteacher'))-1);
    //        $(this).remove();
    //   }else if($(this).hasClass('btn_course')){
    //       $(this).parents('td').data('countcourse', parseInt($(this).parents('td').data('countcourse'))-1);
    //       $(this).remove();

    //   }
     
     
    // }

    function handleAccept(item){

      //  if($(item).hasClass('btn_teacher')){
      //     if(count_teacher >= limit)
      //       return false;

      //     return true;
      //  }else if($(item).hasClass('btn_course')){
      //     if(count_course >= limit)
      //       return false;

      //     return true;
      //  }
      // if($(item).hasClass('btn_teacher'))
      //     return true;
    }

    function handleCardDrag(event, ui){
        var cardTeacher = $(this);
        var slotNumber =  ui.dropable;
    //    / console.log("dd" + cardTeacher.attr('class'));
        // cardTeacher.removeClass('bg-info');
        // slotNumber.droppable( 'enable' );


    }

    function handleCardDrop( event, ui ) {
    

    var slotNumber = $(this).data( 'number' );
    var cardNumber = ui.draggable.data( 'number' );

    $(this).addClass("ui-state-highlight");

    var obj = $(this);
    // console.log('Techer' +  count_teacher + ', Course' + count_course);
    // ui.draggable.position( { of: $(this), my: 'left top', at: 'left top' } );
    ui.draggable.draggable( 'option', 'revert', false );
    item = $(ui.draggable).clone();
    
    //item.addClass('btn_teacher');
    //item.on("dblclick",{extract: 'hello'}, removeItSelf);

    //item.dblclick();

    if(ui.draggable.hasClass('btn_teacher'))
        if($(this).data('countteacher')<1)
          $(this).data('countteacher',parseInt($(this).data('countteacher')) + 1);
        else
          return false;

    if(ui.draggable.hasClass('btn_course'))
        if($(this).data('countcourse')<1)
          $(this).data('countcourse',parseInt($(this).data('countcourse')) + 1);
        else
          return false;      

    if($(this).data('countteacher')<=1 || $(this).data('countcourse')<=1) {

        var itemClassCourse = ui.draggable.hasClass('btn_course');
        var formData = {'column_name': obj.data('column') , 'item': ui.draggable.hasClass('btn_course')?'course':'teacher','value': item.data('value')};
      
        $.ajax({
          type:'POST',
          url: obj.data('url'),
          data: formData,
          cache:false,
         // contentType: false,
         // processData: false,
          success: (data) => {
            
            if(data.status){
              //console.log('ddd' + item);
              item.find("i").remove();

              if(itemClassCourse)
                  obj.prepend(item);
               else
                  obj.append(item);
              }else{
                obj.data('countteacher',parseInt(obj.data('countteacher')) - 1);
                alert(data.data['message']);
              }
          //  console.log("Response Success: " + data.data);

          },
          error: function(data){
            console.log(data);
          }
        });
  

    }


        //  console.log('data teacher' + $(this).data('countteacher'));
    //$(this).html( $(ui.draggable).clone().on('click', removeItSelf));

    // if(ui.draggable.hasClass('btn_teacher'))
    //     count_teacher++;
    
    // if(ui.draggable.hasClass('btn_course'))
    //     count_course++;

    
    //$(this).html($(ui.draggable).clone().on('click', removeItSelf));
    // $(this).html($(ui.draggable).clone().on('click', removeItSelf));
    // item = (ui.draggable.clone();
    // ui.draggable.clone().appendChild($(this));
//     correctCards++;
//   } 
  
  // If all the cards have been placed correctly then display a message
  // and reset the cards for another go

  if ( correctCards == 10 ) {
    $('#successMessage').show();
    $('#successMessage').animate( {
      left: '380px',
      top: '200px',
      width: '400px',
      height: '100px',
      opacity: 1
    } );
  }

}

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/school/resources/views/admin/scheduletemplate/templatedetail.blade.php ENDPATH**/ ?>