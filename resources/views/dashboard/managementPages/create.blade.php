@extends('layouts.dashboard.app')

@section('title', __('site.create'))

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <h1> @lang('site.managementPages') </h1>
        <ol class="breadcrumb">
            <li>
                <a class="active" href="{{ route('dashboard.index') }}"> <i class="fa fa-dashboard"></i>
                    @lang('site.dashboard') </a>
            </li>

            <li>
                <a href="{{ route('dashboard.managementPages.index') }}"> <i class="fa fa-dashboard"></i> @lang('site.managementPages') </a>
            </li>

            <li class="active">
                @lang('site.add')
            </li>
        </ol>
    </section>


    <section class="content">

        <div class="box box-primary">

            <div class="box-header with-border">
                <h3 class="box-title">@lang('site.add')</h3>
            </div><!-- end of box header -->

            <div class="box-body">
                @include('partials._errors')
                <form action="{{route('dashboard.managementPages.store')}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('post')}}

                    <div class="form-group">
                        <label>@lang('site.type')</label>
                        <select name="type" id="type" class="form-control js-example-basic-single" required>
                            <option value="" >@lang('site.choselist')</option>
                            <option value="1" {{ old('type') == 1 ? 'selected' : '' }}>@lang('site.management_main')</option>
                            <option value="2" {{ old('type') == 2 ? 'selected' : '' }}>@lang('site.management_sub')</option>
                            <option value="3" {{ old('type') == 3 ? 'selected' : '' }}>@lang('site.page')</option>
                            <option value="4" {{ old('type') == 4 ? 'selected' : '' }}>@lang('site.page_Independent')</option>
                        </select>
                        {!! isError($errors,"type") !!}                      
                    </div>

                    <div class="form-group">
                        <label>@lang('site.pages')</label>
                        <select name="route" class="form-control route" id="route" required >
                            <option value="" >Route~Uri~Controller~Namespace~@lang('site.choselist')</option>
                            <option value="#" disabled>#~#~#~ادارة رئيسية او فرعية~</option>
                            @foreach ($routes as $route)
                            <option data-mytxt="this text needs to be styled differently" value="{{ $route->getName() }}"  {{ !empty(old('route'))&& old('route')== $route->getName() ? 'selected' : '' }}  {{ empty($route->getName()) ? 'disabled' : '' }} >{{ !empty($route->getName()) ? $route->getName() : 'لا يوجد روت لهاذا المسار'.$route->uri()  }}~{{$route->uri()}}~{{$route->getActionName()}}~{{$route->getAction()['namespace']}} </option>
                            @endforeach
                        </select>
                        {!! isError($errors,"route") !!}                      

                    </div>


                    {{--<div class="form-group">
                        <label>@lang('site.control_panel')</label>
                        <select name="control_panel[]" class="form-control js-example-basic-single" multiple="multiple" required>
                            <option value="" >@lang('site.choselist')</option>
                            <option value="admin" {{ old('control_panel.0') == "admin" ? 'selected' : '' }}>@lang('site.control_panel_admin')</option>
                            <option value="member" {{ old('control_panel.1') == "member" ? 'selected' : '' }}>@lang('site.control_panel_member')</option>
                            <option value="vendor" {{ old('control_panel.2') == "vendor" ? 'selected' : '' }}>@lang('site.control_panel_vendor')</option>
                        </select>
                        {!! isError($errors,"control_panel") !!}                      
                    </div>--}}

                    <div class="form-group">
                        <label>@lang('site.status')</label>
                        <select name="status" class="form-control js-example-basic-single"  required>
                            <option value="open" {{ old('status') == "open" ? 'selected' : '' }} >@lang('site.open')</option>
                            <option value="close" {{ old('status') == "close" ? 'selected' : '' }} >@lang('site.close')</option>
                        </select>
                        {!! isError($errors,"status") !!}                      
                    </div>

                    <div class="form-group">
                        <label>@lang('site.management_page_id')</label>
                        <select name="management_page_id" id="management_page_id" class="form-control js-example-basic-single" required>
                            <option value="" >@lang('site.choselist')</option>
                            @foreach ($management_page_ids as $management_page_id)
                                <option value="{{$management_page_id->id}}" {{ old('management_page_id') == $management_page_id->id ? 'selected' : '' }}>{{$management_page_id->name}}</option>
                            @endforeach
                        </select>
                        {!! isError($errors,"management_page_id") !!}                      
                    </div>
                    <div class="form-group" id="div_permission" hidden>
                        <label>@lang('site.permission')</label>
                        <input disabled type="text" class="form-control" name="permission" id="permission" value="{{old('permission')}}" required>
                        {!! isError($errors,"permission") !!}                      
                    </div>
                    <div class="form-group col-sm-12">
                        <label>@lang('site.fa_icon')</label>
                        <button class="form-control btn btn-default fa_icon" name="fa_icon" data-icon="{{old('fa_icon')}}" data-rows="5" data-cols="10" role="iconpicker"></button>
                    </div>

                    @foreach (config('translatable.locales') as $locale)
                    <div class="form-group">
                        <label>@lang('site.' . $locale . '.name')</label>
                        <input type="text" name="{{ $locale }}[name]" class="form-control" value="{{ old($locale . '.name') }}" required>
                        {!! isError( $errors , $locale.'.name') !!}                      
                    </div>

                    <div class="form-group">
                        <label>@lang('site.' . $locale . '.description')</label>
                        <textarea  name="{{ $locale }}[description]" class="form-control ckeditor" required>{{ old($locale . '.description') }}</textarea>
                        {!! isError( $errors , $locale.'.description') !!}                      
                    </div>
                    @endforeach


                   


                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('site.add')</button>
                    </div>
                </form>

            </div><!-- End box-body -->

        </div><!-- End of box -->

    </section>

</div>

@endsection
@push('scripts')
<script>

$(".route").select2({
    escapeMarkup : function(text){
        text = text.split("~");
        return '<span class="btn btn-success btn-sm" >'+text[0]+'</span>&nbsp;&nbsp;<span  class="btn btn-info btn-sm" >'+text[1]+'</span>&nbsp;&nbsp;<span  class="btn btn-warning btn-sm" >'+text[2]+'</span>&nbsp;&nbsp;<span  class="btn btn-default btn-sm" >'+text[3]+'</span>';
    },
    language: "{{ app()->getLocale() }}",
    dir: ("{{ app()->getLocale() }}"=="ar")? "rtl" : "lte",

});


 
  
</script>
<script type="text/javascript">
    $(document).ready(function() {
        @if(old('type'))
            management({{old('type')}});
        @endif

        $(document).on('change', '#type', function() {
            //alert($('#type').val());
            var type = $('#type option:selected').val();
            management(type);
        });


    });
    
    function management(type) {
        if (type == 1) {
            //alert(type);
            $('#management_page_id').attr('disabled', 'disabled');
            $('#route').val('#'); 
            $('#route').trigger('change.select2'); 
            $('#permission').removeAttr('disabled');
            $('#div_permission').removeAttr('hidden');
            $('#route').attr("disabled", true); 

        } else if (type == 2) {
            $('#management_page_id').removeAttr('disabled');
            $('#route').val('#'); 
            $('#route').trigger('change.select2'); 
            $('#permission').removeAttr('disabled');
            $('#div_permission').removeAttr('hidden');
            $('#route').attr("disabled", true); 

        } else if (type == 3) {
            $('#management_page_id').removeAttr('disabled');
            $('#route').val("{{old('route')}}"); 
            $('#route').trigger('change.select2'); 
            $('#permission').attr('disabled', 'disabled');
            $('#div_permission').attr('hidden','hidden');
            $('#route').removeAttr("disabled"); 
        } else if (type == 4) {
            $('#management_page_id').attr('disabled', 'disabled');
            $('#route').val("{{old('route')}}"); 
            $('#route').trigger('change.select2'); 
            $('#permission').attr('disabled', 'disabled');
            $('#div_permission').attr('hidden','hidden');
            $('#route').removeAttr("disabled"); 
        }
    }

</script>
@endpush