{{-- @if(request()->print=="pdf")
    @extends('layouts.pdf')
@else
    @extends('layouts.admin')
@endif --}}

@extends((request()->print=="pdf")?'layouts.pdf':'layouts.admin')

@section('content')
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
 * @bugfix Prevent webkit from removing list semantics
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
            @if($user == null)
              <a href="{{ route('admin.users.pickup_report') }}?student&campus={{ request()->input('campus') ?? 'MC' }}&class={{ request()->input('class') ?? $selected_class->id }}&btn_pdf_front" class="btn btn-primary float-left m-2">Print Pdf (Front Side)</a>
              <a href="{{ route('admin.users.pickup_report') }}?student&campus={{ request()->input('campus') ?? 'MC' }}&class={{ request()->input('class') ?? $selected_class->id }}&btn_pdf_back" class="btn btn-primary float-left m-2">Print Pdf (Back Side)</a>
            @else
            <a href="{{ route('admin.users.show', $user) }}?print=pdf_front" class="btn btn-primary float-left m-2">Print Pdf (Front Side)</a>
            <a href="{{ route('admin.users.show', $user) }}?print=pdf_back" class="btn btn-primary float-left m-2">Print Pdf (Back Side)</a>
            @endif
            <a href="javascript:history.back()" class="btn btn-secondary float-right">Back to List</a>
        </div>
   
    
    @php
        if($user != null){
            $users=[$user];
        }
    @endphp
    
  

    <table border="0" class="table table-borderless">
        <tr>
            @foreach($users as $index=>$user)
            <td>
                <div class="card-body text-center" style="background:rgb(219, 219, 252);padding-left:10px;padding-right:0px; width:15cm;height:10cm;">
                    @if(empty($user->rfidcard))
                        <div style="height:110px;width:110px;border:solid 1px rgb(13, 47, 238);position: absolute;" class="mb-0">
                            
                        </div>
                    @else
                        {{-- <img style="" class="mb-4" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(80)->generate($user->rfidcard)) !!} "> --}}
                        <div class="mb-1 text-center" style="position: absolute;">
                        <div style="height: 7px"></div>
                        {!! QrCode::size(110)->generate($user->rfidcard) !!}
                        </div>
                    @endif

                    
                    <h3 class="mb-3 text-center" style="color:rgba(18, 18, 233, 0.87)"><strong>PICK UP CARD</strong></h3>
                    
                    <div class="text-left align-top float-left">
                    
                       
                        {{-- <div class="mb-1" style="margin-left:-10px">{!! empty($user->rfidcard) ? '' : QrCode::size(80)->generate($user->rfidcard); !!}</div> --}}
                      
                        
                         <div style="height:130px;width:110px;margin-top:110px;overflow:hidden;border:solid 1px rgb(13, 47, 238)" class="mb-0">
                            @if($user->photo)    
                                <img src="{{ ($user->photo ? asset('storage/photo/' . $user->photo ?? '') : asset('storage/image/' . ($user->roles->contains(4) ? 'student-avatar.png' : 'teacher-avatar.png'))) }}" class="" id="img_thumbnail" alt="select thumbnail" width="100%">
                            @endif
                        </div>
                            <br/>
                            <p class="p-1 mb-0 text-center" style="background:#fff;width:110px;"> {{ $user->email ?? 'NO ID' }}</p>
            
                    </div> 
                    
                    <div class="text-center float-right" style="width:11.2cm;padding-right:20px;padding-left:0px">
                        
                        <div class="p-1 mb-3 bg-white text-left" style="font-size:14px;">
                            <strong>Name: {{ $user->name }}</strong>
                        </div>
                        <div class="p-1 mb-4 bg-white" style="font-size:14px;">
                            <span class="float-left"><strong>Class: {{ str_replace("Morning","",str_replace("Afternoon","", $user->class->name))  }}</strong></span>&nbsp;
                            <span class="float-right"><strong>School Year: {{ (date('Y')-1) . '-' . date('Y') }}</strong></span>
                        </div>
                        <div class="text-left mb-0">
                            <div class="d-inline-block mb-1" style="padding-top: 12px;">
                                <div style="height:130px;width:110px;overflow:hidden;border:solid 1px rgb(13, 47, 238)" class="text-center">
                                @if($user->guardian1)   
                                    <img src="{{ ($user->guardian1 ? asset('storage/photo/' . "{$user->id}_guardian1.png" ?? '') : asset('storage/image/guardian-avatar.png')) }}" id="collect_thumbnail1" alt="select thumbnail" width="100%">
                                @endif
                                </div>
                                <br/>
                                <p class="p-1 mb-0 text-center" style="background:#fff;width:110px;"> {{ $user->guardian1 ?? 'Relative 1' }}</p>
                            </div>
                            <div class="d-inline-block mb-0" style="padding-left: 30px;padding-right: 30px;">
                                <div style="height:130px;width:110px;overflow:hidden;border:solid 1px rgb(13, 47, 238)" class="text-center">
                                @if($user->guardian2)   
                                    <img src="{{ ($user->guardian2 ? asset('storage/photo/' . "{$user->id}_guardian2.png" ?? '') : asset('storage/image/guardian-avatar.png')) }}"  id="collect_thumbnail2" alt="select thumbnail" width="100%">
                                @endif        
                                </div>
                                <br/>
                               <p class="p-1 mb-0 text-center" style="background:#fff;width:110px;"> {{ $user->guardian2 ?? 'Relative 2' }}</p>
                            </div>
                            <div class="d-inline-block mb-1" style="">
                                <div style="height:130px;width:110px;overflow:hidden;border:solid 1px rgb(13, 47, 238)" class="text-center">
                                 @if($user->guardian3)   
                                      <img src="{{ ($user->guardian3 ? asset('storage/photo/' . "{$user->id}_guardian3.png" ?? '') : asset('storage/image/guardian-avatar.png')) }}" id="collect_thumbnail3" alt="select thumbnai"  width="100%">
                                 @endif
                                </div>
                                <br/>
                                <p class="p-1 mb-0 text-center" style="background:#fff;width:110px;"> {{ $user->guardian3 ?? 'Relative 3' }}</p>
                            </div>
                        </div>
                    </div>
                    
            
                </div>
            </td>
            @if(($index+1)%2==0)
                <tr>
            @endif
            @endforeach

        </tr>
    </table>
    
    
 
  
  

    </div>
    


</div>

{{-- <div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#teacher_lessons" role="tab" data-toggle="tab">
                {{ trans('cruds.lesson.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="teacher_lessons">
            @includeIf('admin.users.relationships.teacherLessons', ['lessons' => $user->teacherLessons])
        </div>
    </div>
</div> --}}

@endsection