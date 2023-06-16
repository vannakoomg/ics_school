<!DOCTYPE html>
<html>

<head>
    {{-- <meta charset="UTF-8"> --}}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ trans('panel.site_title') }}</title>
    {{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/@coreui/coreui@2.1.16/dist/css/coreui.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" /> --}}
    {{-- <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" /> --}}
    {{-- <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" /> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet"/>
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" />
   
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
        

        @media print {
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
    
    <form name="frmcampus" method="get" action="{{ route("admin.timetable.exporttimetable") }}" enctype="multipart/form-data">
    <div class="row main_header" style="display: {{ request()->input('btn_submit')=='Print Pdf' ? 'none':'' }}">
       
        <div class="col-1">
            &nbsp;
        </div>
        <div class="col-2">
            <div class="form-group row">
                <label class="required col-sm-3 col-form-label" for="class_id">Campus</label>
                <div class="col-sm-9">
                      <select  class="custom-select {{ $errors->has('campus') ? 'is-invalid' : '' }}" name="campus" id="campus" onchange="document.forms['frmcampus'].submit()">
                          @foreach($campus as $id => $key)
                          {{-- {{ $key==$current_filter['campus']?'selected':'' }} --}}
                              <option value="{{ $key }}" {{ strtolower(request()->input('campus') ?? 'MC') == strtolower($key) ? 'selected' : '' }}>{{ $key }}</option>
                          @endforeach
                      </select>
                </div>      
              </div>
            </div>
          
            <div class="col-3">    
                  <div class="form-group row">
                      <label class="required col-sm-3 col-form-label" for="class_id">{{ trans('cruds.lesson.fields.class') }}</label>
                      <div class="col-sm-9">
                      <select class="custom-select select2 {{ $errors->has('class') ? 'is-invalid' : '' }}" name="class_id[]" id="class_id"  multiple>
                          @foreach($allclasses as $id => $class)
                          {{-- {{ $id==$current_filter['class_id']?'selected':'' }} --}}
                               @if( strtolower($class->campus) == strtolower(request()->input('campus') ?? 'MC')) 
                                    <option value="{{ $class->id }}" {{ in_array($class->id,request()->input('class_id',[])) ? 'selected' : '' }} >{{ $class->name }}</option>
                                @endif
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
             <div class="col-1">
                <div class="form-group row">
                   
                    <label class="col-sm-2 col-form-label">Show Saturday</label>
                    <div class="col-sm-10">
                         <input type="checkbox" name="btn_saturday" class="form-check-input" value="1" {{  request()->has('btn_saturday') ? 'checked':'' }}/>
                    </div>
                </div>
            </div>

             <div class="col-3">    
                <div class="form-group row">

                    <p>&nbsp;</p>
                    
                    <div class="col-12">
                        
                    <input type="submit" class="btn btn-primary" name="btn_submit" value="Preview">
                    <input type="submit" class="btn btn-primary" name="btn_submit" value="Print Pdf">
                    <a href="{{ route('admin.timetable.create') }}" class="btn btn-success">Back to Timetable</a>
                    </div>
                </div>
             </div>
             
    </div>
    </form>
    @foreach ($timetables as $class)
        

      
    @foreach($class->timetables as $k=>$template)
     
    @if(strtolower($k)=='odd')
                <div class="border rounded p-3 shadow div_position" style="font-size:80%">
                <h5 class="text-primary">ODD MONTHS</h5>
                Use for September, November, January, March, May, July
            </div>
            @elseif(strtolower($k)=='even')
                <div class="border rounded p-3 shadow div_position" style="font-size:80%">
                    <h5 class="text-primary">EVEN MONTHS</h5>
                    Use for August, October, December, February , April, June
                </div>
            @endif

    <div class="row">
        <div class="col-lg text-center">  
            @if(request()->btn_submit=='Preview')
                <img src="{{ asset('images/ics_header.png') }}" height="50px">
            @else
                 <img src="{{ public_path('images/ics_header.png') }}" height="50px">
            @endif
            
          <p class="mb-0 p-0 title_header1">Class Schedule<br/>
          School Year {{ date('Y') }} - {{ date('Y')+1 }}<br/>
          {{  $class->class->name ?? ''  }}</p>
        </div>
       
      </div>

     
       
        <table width="100%" class="khmer_os">
            <tr>
              <td class="text-nowrap" style="font-size:110%">
           
                  <p class="title_header2">Homeroom: {{ $class->class->homeroom }}<br/>
                  Khmer Teacher:  {{ $class->class->khmerteacher }}<br/>
                  Teacher Aide: </strong> {{ $class->class->teacheraide }}
                  </p>
              </td>

              <td class="text-right text-nowrap">
               
                  <label>&nbsp;</label> <br/>
                  <p class="title_header2">Room: {{ $class->class->roomno }}</p>
                  <label>&nbsp;</label>
               
              </td>
            </tr>
        </table>
       @php
           if(request()->has('btn_saturday'))
                $width="12%";
            else {
                $width="17%";
            }
       @endphp 
      <table class="khmer_os" id="tbl_timetable" width="100%" style="font-family:khmerosmoullight;" border="1" cellpadding="8">
        <thead class="text-center">
          <tr class="
           {{-- (strtolower($class->class->level_type)=='primary')?'table-warningcolor-primary':((strtolower($class->class->level_type)=='secondary')?'table-danger':'table-warningcolor-muted') --}}
           @if(strtolower($class->class->level_type)=='primary')
                    header-primary 
            @elseif(strtolower($class->class->level_type)=='secondary')
                     header-secondary
            @elseif(strtolower($class->class->level_type)=='kindergarten')
                    header-kindergarten
            @endif
          ">
            <th style="text-align:center"  width="125">TIME</th>
            <th style="text-align:center" width="{{ $width }}">MONDAY</th>
            <th style="text-align:center" width="{{ $width }}">TUESDAY</th>
            <th style="text-align:center" width="{{ $width }}">WEDNESDAY</th>
            <th style="text-align:center" width="{{ $width }}">THURSDAY</th>
            <th style="text-align:center" width="{{ $width }}">FRIDAY</th>
            @if (request()->has('btn_saturday'))
                <th style="text-align:center" width="{{ $width }}">SATURDAY</th>
            @endif
          </tr>
        </thead>
        <tbody>
            @php
              $pp=0;
            @endphp

            @foreach($template as $timetable)
            @php
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
        
            @endphp
            <tr>
                <td class="text-nowrap align-middle text-center">
                    {{ $timetable->time ?? '' }}
                </td>
                @if (strtolower($timetable->breaktime)!='study time')
                    <td colspan="{{ count($days) }}" class="text-center align-middle khmer_os 
                     
                    @if($pp>1)
                        @if(strtolower($class->class->level_type)=='primary')
                                breaktime-bg-primary breaktime-color-primary
                        @elseif(strtolower($class->class->level_type)=='secondary')
                                breaktime-bg-secondary breaktime-color-secondary
                        @elseif(strtolower($class->class->level_type)=='kindergarten')
                                breaktime-bg-kindergarten breaktime-color-kindergarten
                        @endif
                    @endif
                    ">
                        {{ $timetable->breaktime }}
            
                    </td>
                 
                @else
                {{-- {{ (strtolower($class->class->level_type)=='primary')  ? 'text-primary' : ((strtolower($class->class->level_type)=='secondary') ? 'text-black':'text-primary') }} --}}
                    @foreach ($days as $day)
                        <td class="text-center align-middle khmer_os
                        
                        @if(strtolower($class->class->level_type)=='primary')
                                study-color-primary 
                        @elseif(strtolower($class->class->level_type)=='secondary')
                                study-color-secondary
                        @elseif(strtolower($class->class->level_type)=='kindergarten')
                                study-color-kindergarten
                        @endif
                        ">
                            {!! $timetable->{$day} ?? '&nbsp;' !!}
                            
                            {{-- {{ $timetable->subject }}<br/>
                            {{ $timetable->teachername }} --}}
                            {{-- {{ $data[$day]['course'] }}<br/>
                            {{ $data[$day]['teacher'] }} --}}
                          
                        </td>
                    @endforeach
                    
                    
                @endif
                
            @endforeach
            
        </tbody>
    </table>
    <p>&nbsp;</p>
    <div class="page-break">
    </div>            
    {{-- <div class="row">
        <div class="col-12">
        <hr style="width: 50%">
        </div>
    </div> --}}
    @endforeach
    @endforeach
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
    <script>
        $(document).ready(function () {
          $('.select2').select2()
        });
    </script>
</body>


</html>

