@extends('layouts.dashboard.app')

@section('title', __('site.clients'))

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <h1>
            @lang('site.clients')
        </h1>

        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard.index') }}"> <i class="fa fa-dashboard"></i> @lang('site.dashboard') </a>
            </li>

            <li class="active">
                @lang('site.clients')
            </li>
        </ol>
    </section>

    <section class="content">

        <div class="box box-primary">

            <div class="box-header with-border" style="padding: 15px">
                <h3 class="box-title" style="padding-bottom: 20px"> @lang('site.clients') <small class="panel panel-info pl-5">{{ $clients->total() }}</small> </h3>

                <!-- Form of search -->
                <form action="{{ route('dashboard.clients.index') }}" method="get">
                    <div class="row">

                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">
                        </div>

                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary"> <i class="fa fa-search"></i> @lang('site.search')</button>

                            @if (auth()->user()->can('create_clients'))
                            <a href="{{route('dashboard.clients.create')}}" class="btn btn-primary"> <i class="fa fa-plus"></i> @lang('site.add')</a>
                            @else
                            <button class="btn btn-primary disabled">@lang('site.add')</button>
                            @endif
                        </div>

                    </div>{{-- end of row --}}
                </form> <!-- End form of search -->

            </div><!-- end of box header -->

            <div class="box-body">

                {{-- Check count of clients --}}
                @if($clients->count() > 0)

                <table class="table table-bordered">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('site.name')</th>
                            <th>@lang('site.phone')</th>
                            <th>@lang('site.address')</th>
                            <th>@lang('site.add_order')</th>
                            <th>@lang('site.action')</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($clients as $client)
                        <tr>
                            <td>{{ $client->id }}</td>
                            <td>{{ $client->name }}</td>
                            <td>{{is_array($client->phone) ? implode($client->phone,'-') : $client->phone}}</td>
                            <td>{!! $client->address !!}</td>
                            @if(auth()->user()->can('create_orders'))
                                <td><a href="{{route('dashboard.clients.orders.create',$client->id)}}" class="btn btn-sm btn-info">@lang('site.add_order')</a></td>
                            @else
                                <td><a href="#" class="btn btn-sm btn-info disabled "> @lang('site.add_order')</a></td>
                            @endif
                            <td>
                                {{-- Check Perimssion edit --}}
                                @if (auth()->user()->can('update_clients'))
                                <a href="{{ route('dashboard.clients.edit', $client->id) }}" class="btn btn-info btn-sm"> <i class="fa fa-edit"></i> @lang('site.edit')</a>
                                @else
                                <a href="#" class="btn btn-info btn-sm disabled"> <i class="fa fa-edit"></i> @lang('site.edit')</a>
                                @endif

                                {{-- Check Perimssion delet --}}
                                @if (auth()->user()->can('delete_clients'))

                                <form action="{{ route('dashboard.clients.destroy', $client->id) }}" method="post" style="display: inline-block">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger delete btn-sm "> <i class="fa fa-trash"></i> @lang('site.delete')</button>
                                </form><!-- End of form -->

                                @else
                                <button class="btn btn-danger btn-sm disabled"> <i class="fa fa-trash"></i> @lang('site.delete')</button>
                                @endif

                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table><!-- End of Table -->

                {{ $clients->appends(request()->query())->links() }}

                @else
                <h2>@lang('site.no_data_found')</h2>
                @endif

            </div><!-- End of box-body -->

        </div><!-- End of box -->

    </section><!-- End of content -->

</div>

@endsection
