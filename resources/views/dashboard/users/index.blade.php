@extends('layouts.dashboard.app')

@section('title', __('site.users'))

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <h1>
            @lang('site.users')
        </h1>

        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard.index') }}"> <i class="fa fa-dashboard"></i> @lang('site.dashboard') </a>
            </li>

            <li class="active">
                @lang('site.users')
            </li>
        </ol>
    </section>

    <section class="content">

        <div class="box box-primary">

            <div class="box-header with-border" style="padding: 15px">
                <h4 style="margin:10px ">@lang('site.users')<small>{{$users->total()}}</small></h4>

                <form action="{{ route('dashboard.users.index') }}" method="get">
                    <div class="row">

                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">

                        </div>

                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary"> <i class="fa fa-search"></i> @lang('site.search')</button>

                            @if (auth()->user()->can('create_users'))
                            <a href="{{route('dashboard.users.create')}}" class="btn btn-primary"> <i class="fa fa-plus"></i> @lang('site.add')</a>
                            @else
                            <button class="btn btn-primary disabled">@lang('site.add')</button>
                            @endif
                        </div>

                    </div>
                </form> <!-- End form of search -->

            </div>

            <div class="box-body">
                @if($users->count() >0)
                <table class="table table-bordered">
                    <thead>

                        <tr>
                            <th style="width: 10px">#</th>
                            <th>@lang('site.first_name')</th>
                            <th>@lang('site.last_name')</th>
                            <th>@lang('site.email')</th>
                            <th>@lang('site.image')</th>
                            <th>@lang('site.action')</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($users as $index => $user )
                        <tr>
                            <td>{{++$index}}</td>
                            <td>{{$user->first_name }}</td>
                            <td>{{$user->last_name }}</td>
                            <td>{{$user->email }}</td>
                            <td><img src="{{ $user->image_path }}" style="height:100px; width: 100px;" class="img-thumbnail" alt=""></td>
                            <td>
                                @if(auth()->user()->hasPermission('delete_users'))
                                <a class="btn btn-info btn-sm" href="{{route('dashboard.users.edit',$user->id)}}">@lang('site.edit')</a>
                                @else
                                <button class="btn btn-info  disabled btn-sm">@lang('site.edit')</button>
                                @endif


                                @if(auth()->user()->hasPermission('delete_users'))
                                <form action="{{route('dashboard.users.destroy',$user->id)}}" method="POST" style="display:  inline-block">
                                    {{ csrf_field() }}
                                    {{method_field('delete')}}
                                    <button type="submit" class="delete btn btn-danger  btn-sm">@lang('site.delete')</button>
                                </form>
                                @else
                                <button class="btn btn-danger disabled  btn-sm">@lang('site.delete')</button>
                                @endif
                            </td>
                        </tr>
                        @endforeach


                    </tbody>
                </table>
                {{$users->appends(request()->query())->links()}}
                @else
                <h2>@lang('site.no_data_found')</h2>
                @endif

            </div><!-- End of box-body -->

        </div><!-- End of box -->

    </section><!-- End of content -->

</div>
<script src="{{ asset('dashboard/toast/jquery.toast.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('dashboard/toast/jquery.toast.min.css') }}">

<script>
    $.toast({
        text: 'Triggers the events>>>>>>>',
        afterShown: function() {  
            window.setTimeout(function() {
                //alert('Toast has appeared.');
                //window.location='http://mypos.devel:8080/ar/dashboard/users';
            }, 100)
        },
    })
    $.toast({
        heading: 'Error'
        , text: 'An unexpected error occured while trying to show you the toast! ..Just kidding, it is just a message, toast is right in front of you.'
        , icon: 'error'
        , position: 'bottom-left'
        , hideAfter: false
    , });
    $.toast({
        heading: 'Can I add <em>icons</em>?'
        , text: 'Yes! check this <a href="https://github.com/kamranahmedse/jquery-toast-plugin/commits/master">update</a>.'
        , icon: 'success'
    })

</script>
<script>




</script>


@endsection



<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>
