@extends('layouts.admin')


@section('styles')
<style>
.simplecolorpicker.fontawesome span.color[data-selected]:after {
    font-family: 'FontAwesome';
    -webkit-font-smoothing: antialiased;
  
    content: '\f00c'; /* Ok/check mark */
    color:#000;
    margin-right: 1px;
    margin-left: 1px;
  }  


  </style>

@endsection
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} Course
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.course.store") }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group row">
                <div class="col-6">
                    <label class="required" for="name">{{ trans('cruds.schoolClass.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block"></span>
                    <br/>
                    <label class="required" for="name">{{ trans('Category') }}</label>
                    <select class="custom-select select2 {{ $errors->has('category') ? 'is-invalid' : '' }}" name="category" id="category" required>
                    @foreach($categories as $id => $category)
                        <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                  </select>
                    @if($errors->has('category'))
                        <div class="invalid-feedback">
                            {{ $errors->first('category') }}
                        </div>
                    @endif
                    <span class="help-block"></span>
                </div>
                <div class="col-4">
                  <label class="required" for="name">{{ trans('Language Type') }}</label>
                 <select name="language" id="language" class="custom-select">
                  @foreach($languages as $id => $language)
                     <option value="{{ $language }}" {{ old('language') == $language ? 'selected' : '' }}>{{ $language }}</option>
                  @endforeach
                 </select>
                  @if($errors->has('name'))
                      <div class="invalid-feedback">
                          {{ $errors->first('name') }}
                      </div>
                  @endif
                  <span class="help-block"></span>
              </div>
                <div class="col-2">
                    <img src="{{ asset('images/blank.jpeg') }}" class="img-thumbnail btn btn-outline-primary" id="img_thumbnail" alt="select thumbnail" width="150px" height="150px">
                    <input type="file" id="imgupload" name="imgupload" style="display:none"/>
                </div>    
            </div>
            
            <div class="form-group">
                <label class="" for="dlpinfo">{{ trans('Description') }}</label>
                <textarea class="form-control" name="description" id="description" value="{{ old('dlpinfo', '') }}"></textarea>
                <span class="help-block"></span>
            </div>

            <div class="form-group">
                <label class="" for="class_id">{{ trans('cruds.user.fields.class') }}</label>

                <select class="form-control select2 {{ $errors->has('class') ? 'is-invalid' : '' }}" name="class_id[]" id="class_id" multiple>
                    {{-- @foreach($classes as $id => $class)
                        <option value="{{ $id }}" {{ old('class_id') == $id ? 'selected' : '' }}>{{ $class }}</option>
                    @endforeach --}}
                </select>
                @if($errors->has('class'))
                    <div class="invalid-feedback">
                        {{ $errors->first('class') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.class_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="">Color</label>

                <select name="color">
                    @foreach ($colors as $color)
                       <option value="{{ $color }}" {{ (old('color','#ffffff')==$color) ? 'selected':'' }}>{{ $color }}</option>
                    @endforeach      
                   
                </select>

            </div>

            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>

$(function(){
  'use strict';

  /**
   * Constructor.
   */
  var SimpleColorPicker = function(select, options) {
    this.init('simplecolorpicker', select, options);
  };

  var allitems = {!! json_encode($classes) !!};

   $('select[name="category"]').on("change", function(){
       var arr_selected = {!! json_encode($filter) !!};
      
       var selected_category = (eval('arr_selected' + '["' + $(this).val().toLowerCase() + '"]'));
       

      $('#class_id').empty().trigger("change");

      // $('#class_id').val(null).trigger('change');
      for (var key in allitems) {
        //console.log($.inArray( key, selected_category));
        // console.log(key);
        if($.inArray( parseInt(key), selected_category) >=0){
          
          var newOption = new Option(allitems[key], key, true, true);
          $('#class_id').append(newOption);
        }
    }
      // $('#class_id').val(eval('arr_selected' + '["' + $(this).val().toLowerCase() + '"]')).trigger('change');

      // $('#class_id > option:not(:selected)').prop('disabled',true).trigger('change');

  //    console.log(jsonData[eval('arr_selected' + '.' + $(this).val().toLowerCase())]);
    })

   $('select[name="category"]').trigger('change');
  /**
   * SimpleColorPicker class.
   */
  SimpleColorPicker.prototype = {
    constructor: SimpleColorPicker,

    init: function(type, select, options) {
      var self = this;

      self.type = type;

      self.$select = $(select);
      self.$select.hide();

      self.options = $.extend({}, $.fn.simplecolorpicker.defaults, options);

      self.$colorList = null;

      if (self.options.picker === true) {
        var selectText = self.$select.find('> option:selected').text();
        self.$icon = $('<span class="simplecolorpicker icon"'
                     + ' title="' + selectText + '"'
                     + ' style="background-color: ' + self.$select.val() + ';"'
                     + ' role="button" tabindex="0">'
                     + '</span>').insertAfter(self.$select);
        self.$icon.on('click.' + self.type, $.proxy(self.showPicker, self));

        self.$picker = $('<span class="simplecolorpicker picker ' + self.options.theme + '"></span>').appendTo(document.body);
        self.$colorList = self.$picker;

        // Hide picker when clicking outside
        $(document).on('mousedown.' + self.type, $.proxy(self.hidePicker, self));
        self.$picker.on('mousedown.' + self.type, $.proxy(self.mousedown, self));
      } else {
        self.$inline = $('<span class="simplecolorpicker inline ' + self.options.theme + '"></span>').insertAfter(self.$select);
        self.$colorList = self.$inline;
      }

      // Build the list of colors
      // <span class="color selected" title="Green" style="background-color: #7bd148;" role="button"></span>
      self.$select.find('> option').each(function() {
        var $option = $(this);
        var color = $option.val();

        var isSelected = $option.is(':selected');
        var isDisabled = $option.is(':disabled');

        var selected = '';
        if (isSelected === true) {
          selected = ' data-selected';
        }

        var disabled = '';
        if (isDisabled === true) {
          disabled = ' data-disabled';
        }

        var title = '';
        if (isDisabled === false) {
          title = ' title="' + $option.text() + '"';
        }

        var role = '';
        if (isDisabled === false) {
          role = ' role="button" tabindex="0"';
        }

        var $colorSpan = $('<span class="color"'
                         + title
                         + ' style="background-color: ' + color + ';"'
                         + ' data-color="' + color + '"'
                         + selected
                         + disabled
                         + role + '>'
                         + '</span>');

        self.$colorList.append($colorSpan);
        $colorSpan.on('click.' + self.type, $.proxy(self.colorSpanClicked, self));

        var $next = $option.next();
        if ($next.is('optgroup') === true) {
          // Vertical break, like hr
          self.$colorList.append('<span class="vr"></span>');
        }
      });
    },

    /**
     * Changes the selected color.
     *
     * @param color the hexadecimal color to select, ex: '#fbd75b'
     */
    selectColor: function(color) {
      var self = this;

      var $colorSpan = self.$colorList.find('> span.color').filter(function() {
        return $(this).data('color').toLowerCase() === color.toLowerCase();
      });

      if ($colorSpan.length > 0) {
        self.selectColorSpan($colorSpan);
      } else {
        console.error("The given color '" + color + "' could not be found");
      }
    },

    showPicker: function() {
      var pos = this.$icon.offset();
      this.$picker.css({
        // Remove some pixels to align the picker icon with the icons inside the dropdown
        left: pos.left - 6,
        top: pos.top + this.$icon.outerHeight()
      });

      this.$picker.show(this.options.pickerDelay);
    },

    hidePicker: function() {
      this.$picker.hide(this.options.pickerDelay);
    },

    /**
     * Selects the given span inside $colorList.
     *
     * The given span becomes the selected one.
     * It also changes the HTML select value, this will emit the 'change' event.
     */
    selectColorSpan: function($colorSpan) {
      var color = $colorSpan.data('color');
      var title = $colorSpan.prop('title');

      // Mark this span as the selected one
      $colorSpan.siblings().removeAttr('data-selected');
      $colorSpan.attr('data-selected', '');

      if (this.options.picker === true) {
        this.$icon.css('background-color', color);
        this.$icon.prop('title', title);
        this.hidePicker();
      }

      // Change HTML select value
      this.$select.val(color);
    },

    /**
     * The user clicked on a color inside $colorList.
     */
    colorSpanClicked: function(e) {
      // When a color is clicked, make it the new selected one (unless disabled)
      if ($(e.target).is('[data-disabled]') === false) {
        this.selectColorSpan($(e.target));
        this.$select.trigger('change');
      }
    },

    /**
     * Prevents the mousedown event from "eating" the click event.
     */
    mousedown: function(e) {
      e.stopPropagation();
      e.preventDefault();
    },

    destroy: function() {
      if (this.options.picker === true) {
        this.$icon.off('.' + this.type);
        this.$icon.remove();
        $(document).off('.' + this.type);
      }

      this.$colorList.off('.' + this.type);
      this.$colorList.remove();

      this.$select.removeData(this.type);
      this.$select.show();
    }
  };

  /**
   * Plugin definition.
   * How to use: $('#id').simplecolorpicker()
   */
  $.fn.simplecolorpicker = function(option) {
    var args = $.makeArray(arguments);
    args.shift();

    // For HTML element passed to the plugin
    return this.each(function() {
      var $this = $(this),
        data = $this.data('simplecolorpicker'),
        options = typeof option === 'object' && option;
      if (data === undefined) {
        $this.data('simplecolorpicker', (data = new SimpleColorPicker(this, options)));
      }
      if (typeof option === 'string') {
        data[option].apply(data, args);
      }
    });
  };

  /**
   * Default options.
   */
  $.fn.simplecolorpicker.defaults = {
    // No theme by default
    theme: '',

    // Show the picker or make it inline
    picker: false,

    // Animation delay in milliseconds
    pickerDelay: 0
  };

});

    $(function(){


    $('select[name="color"]').simplecolorpicker({theme: 'fontawesome'});

    $('#img_thumbnail').click(function(){
        $('#imgupload').trigger('click');
    });

    $('#imgupload').change(function(e){
       var filename = e.target.files[0].name;
       var reader = new FileReader();

     reader.onload = function(e) {
        // get loaded data and render thumbnail.
        $('#img_thumbnail').attr('src',e.target.result);
  };
  // read the image file as a data URL.
  reader.readAsDataURL(this.files[0]);

    });

    });

    
</script>
    
@endsection