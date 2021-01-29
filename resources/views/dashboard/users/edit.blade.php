@extends('layouts.dashboard.app')

@section('title',$title)

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <h1> @lang('site.users') </h1>
        <ol class="breadcrumb">
            <li>
                <a class="active" href="{{ route('dashboard.index') }}"> <i class="fa fa-dashboard"></i>
                    @lang('site.dashboard') </a>
            </li>

            <li>
                <a href="{{ route('dashboard.users.index') }}"> <i class="fa fa-dashboard"></i> @lang('site.users') </a>
            </li>

            <li class="active">
                @lang('site.edit')
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
                <form action="{{route('dashboard.users.update',$user->id)}}" method="POST"  enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('put')}}
                    <div class="form-group">
                        <label>@lang('site.first_name')</label>
                        <input type="text" name="first_name" class="form-control" value="{{$user->first_name}}" required />
                    </div>
                    <div class="form-group">
                        <label>@lang('site.last_name')</label>
                        <input type="text" name="last_name" class="form-control" value="{{$user->last_name}}" required />
                    </div>
                    <div class="form-group">
                        <label>@lang('site.email')</label>
                        <input type="text" name="email" class="form-control" value="{{$user->email}}" required />
                    </div>
                    <div class="form-group">
                        <label>@lang('site.image')</label>
                        <input type="file" name="image" class="form-control image  "  />
                    </div>
                    <div class="form-group">
                        <img src="{{$user->image_path}}" style="width: 100px;" class="img-thumbnail  image-preview" alt="">
                    </div>


                    <div class="form-group">
                        <label>@lang('site.password')</label>
                        <input type="password" name="password" class="form-control" value=""  />
                    </div>
                    <div class="form-group">
                        <label>@lang('site.password_confirmation')</label>
                        <input type="password" name="password_confirmation" class="form-control" value=""  />
                    </div>

                    <div class="form-group">
                        <label>@lang('site.permissions')</label>
                        <!-- Custom Tabs -->
                        <div class="nav-tabs-custom">
                            @php
                            $models = ['users','categories','products','clients','orders'];
                            $maps = ['create','read','update','delete'];
                            @endphp
                            <ul class="nav nav-tabs">
                                @foreach($models as $index => $model)
                                <li class="{{$index == 0 ?'active':'' }}"><a href="#{{$model}}" data-toggle="tab">@lang('site.'.$model)</a></li>
                                @endforeach
                                <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                @foreach($models as $index => $model)

                                <div class="tab-pane {{$index == 0 ?'active':'' }}" id="{{$model}}">
                                    @foreach($maps as $map)
                                    <label><input type="checkbox" name="permissions[]" {{ ($user->hasPermission($map.'_'.$model)) ? 'checked':'' }} value="{{$map}}_{{$model}}" />
                                        @lang('site.'.$map)</label>
                                    @endforeach

                                </div>
                                @endforeach

                            </div>
                        </div>
                        <!-- nav-tabs-custom -->
                    </div>




                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i>@lang('site.edit')</button>
                    </div>
                </form>

            </div><!-- End box-body -->

        </div><!-- End of box -->

    </section>

</div>

@endsection
