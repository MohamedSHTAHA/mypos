@extends('layouts.dashboard.app')

@section('title', __('site.edit'))

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <h1> @lang('site.clients') </h1>
        <ol class="breadcrumb">
            <li>
                <a class="active" href="{{ route('dashboard.index') }}"> <i class="fa fa-dashboard"></i>
                    @lang('site.dashboard') </a>
            </li>

            <li>
                <a href="{{ route('dashboard.clients.index') }}"> <i class="fa fa-dashboard"></i> @lang('site.clients') </a>
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
                <form action="{{route('dashboard.clients.update',$client->id)}}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('put')}}


                    <div class="form-group">
                        <label>@lang('site.name')</label>
                        <input type="text" name="name" class="form-control" value="{{$client->name}}" required />
                    </div>
                    @for($i=0;$i<2;$i++)
                    <div class="form-group">
                        <label>@lang('site.phone')</label>
                        <input type="text" name="phone[]" value="{{$client->phone[$i] ?? '' }}" class="form-control"  />
                    </div>
                    @endfor
                    
                    <div class="form-group">
                        <label>@lang('site.address')</label>
                        <textarea name="address" class="form-control ckeditor" >{!! $client->address !!}</textarea>
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
