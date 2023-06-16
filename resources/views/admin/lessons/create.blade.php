@extends('layouts.admin')

@section('styles')
{{-- <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css"/> --}}
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer&display=swap" rel="stylesheet">
    <style>
        .khmer_os {
            font-family: 'Noto Sans Khmer', sans-serif;
            font-size:100%;
        }

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
          line-height: 1em 
      }

      .breaktime-bg-kindergarten {
           background: #FFBDA6 !important;
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
            background-color: rgb(185,219,164) !important;
        }

        .header-secondary {
            font-weight: bold;
            background-color: rgba(15, 60, 184, 0.747) !important;
            color: #000000;
        }

        .header-kindergarten  {
            font-weight: bold;
            background-color: rgb(132,224,130) !important;
            color: #000000;
        }

      .breaktime-bg-primary {
            background-color: rgb(244,190,156) !important;
        }

        .breaktime-color-primary {
            /* font-weight: bold; */
            color: rgb(231, 0, 8);
        }

        .study-color-primary {
           color: #0064C2;
        }

        .breaktime-bg-secondary {
            background-color: rgb(201, 57, 59) !important;
        }

        .breaktime-color-secondary {
            /* font-weight: bold; */
            color: #0000009c;
        }

        .study-color-secondary {
           color: #000000;
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
@endsection

@section('content')

<div class="card">
    <div class="card-header">
      <form name="frmcampus" method="get" action="{{ route("admin.timetable.create") }}" enctype="multipart/form-data">
      <div class="row">
      <div class="col-lg">  
        {{ trans('global.create') }} {{ trans('cruds.lesson.title_singular') }}
      </div>

      <div class="col">
      <div class="form-group row">
          <label class="required col-sm-3 col-form-label" for="class_id">Campus</label>
          <div class="col-sm-9">
                <select  class="custom-select {{ $errors->has('campus') ? 'is-invalid' : '' }}" name="campus" id="campus" onchange="document.forms['frmcampus'].submit()">
                    @foreach($campus as $id => $key)
                        <option value="{{ $key }}" {{ old('campus') == $key ? 'selected' : '' }} {{ $key==$current_filter['campus']?'selected':'' }}>{{ $key }}</option>
                    @endforeach
                </select>
          </div>      
        </div>
      </div>

      <div class="col">    
            <div class="form-group row">
                <label class="required col-sm-3 col-form-label" for="class_id">{{ trans('cruds.lesson.fields.class') }}</label>
                <div class="col-sm-9">
                <select class="select2 {{ $errors->has('class') ? 'is-invalid' : '' }}" name="class_id" id="class_id" onchange="document.forms['frmcampus'].submit()">
                    @foreach($classes as $id => $class)
                        <option value="{{ $id }}" {{ old('class_id') == $id ? 'selected' : '' }} {{ $id==$current_filter['class_id']?'selected':'' }}>{{ $class }}</option>
                    @endforeach
                </select>
                @if($errors->has('class'))
                    <div class="invalid-feedback">
                        {{ $errors->first('class') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.lesson.fields.class_helper') }}</span>
                </div>
            </div>
       </div>
      </div>
    </form>  
    </div>

    <div class="card-body">
    <div class="row">
      <div class="col">
          <a href="{{ route('admin.timetable.exporttimetable') }}" class="btn btn-info">Print Timetable</a>
      </div>

      <div class="col text-right">
        Schedule Template
        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          {{ empty($current_filter['template_id'])?'No Template Assigned': $templates[$current_filter['template_id']] }}
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          @foreach ($templates as $key=>$name)
            @if($key!=$current_filter['template_id'])
              <a class="dropdown-item" href="{{ route("admin.timetable.create",['campus'=>$current_filter['campus'],'class_id'=>$current_filter['class_id'],'template_id'=>$key]) }}">{{ $name }}</a>
            @endif
          @endforeach
        </div>
      </div>
     </div>
      <br/>
      <hr/>
        {{-- <div id="content">
        <div id="" class="row"> 

                @foreach($teachers as $id => $teacher)
                    <div id="card{{ $id }}" class="col">
                         <div class="form-control text-nowrap bg-primary btn_teacher" data-number="{{ $id }}">{{ $teacher }}</div>
                    </div>
                @endforeach

        </div>

        <div id="cardSlots" class="row"> 
            @foreach($teachers as $id => $teacher)
            <div class="col">
                <div class="form-control text-nowrap bg-outline-warning" data-number="{{ $id }}">&nbsp;</div>
            </div>

                @endforeach
        </div>

        </div> --}}
        <div class="row">
          <div class="col-12">
        @include('admin.lessons.calendar')
          </div>
        </div>
    </div>
</div>



@endsection

@section('scripts')
@parent

{{-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script> --}}
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

    $(document).on("dblclick",'td > div.btn_teacher, td > div.btn_course',function(e){
      remove_course_teacher($(this));      
    });
    
    function remove_course_teacher(element){
      var obj = $(element).parents('td');
      var item = $(element);

      var formData = {'column_name': obj.data('column') , 'class_id': obj.data('class_id'),'template_id': obj.data('template_id'), 'item': item.hasClass('btn_course')?'course':'teacher','value': item.data('value')};

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
              }else if(item.hasClass('btn_course')){
                
                  obj.data('countcourse', parseInt(obj.data('countcourse'))-1);
                  item.remove();

              }

              // console.log(obj.data('countcourse') + '--' + obj.data('countteacher'));

              if(obj.data('countcourse')===0 && obj.data('countteacher')===0){
                  obj.css('background-color','#FFF');
                  
              }
                  
              }
          //  console.log("Response Success: " + data.data);

          },
          error: function(data){
            console.log(data);
          }
        });
  
    }
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
        var formData = {'column_name': obj.data('column') , 'class_id': obj.data('class_id'),'template_id': obj.data('template_id'),'item': ui.draggable.hasClass('btn_course')?'course':'teacher','value': item.data('value')};
      
        $.ajax({
          type:'POST',
          url: obj.data('url'),
          data: formData,
          cache:false,
         // contentType: false,
         // processData: false,
          success: (data) => {

             console.log(data); 
            if(data.status){
              //console.log('ddd' + item);
              item.find("i").remove();
              // obj.prepend($('<div></div>').html(item.text()).addClass('btn_course'));
              if(itemClassCourse){
                  // console.log(item.data('color'));
                  obj.css('background-color',item.data('color'));
                  obj.prepend($('<div class="btn_course" />').html('<strong>' + item.html() + '</strong>').data('value',item.data('value')));
                  
              }else
                  obj.append($('<div class="btn_teacher" />').html(item.html()).data('value',item.data('value')));
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
@endsection
