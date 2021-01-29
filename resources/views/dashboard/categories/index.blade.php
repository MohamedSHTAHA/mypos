
@extends('layouts.dashboard.app')

@section('title', __('site.categories'))

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <h1>
                @lang('site.categories')
            </h1>

            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('dashboard.index') }}"> <i class="fa fa-dashboard"></i> @lang('site.dashboard') </a>
                </li>

                <li class="active">
                    @lang('site.categories')
                </li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border" style="padding: 15px">
                    <h3 class="box-title" style="padding-bottom: 20px"> @lang('site.categories')  <small class="panel panel-info pl-5">{{ $categories->total() }}</small> </h3>

                    <!-- Form of search -->
                    <form action="{{ route('dashboard.categories.index') }}" method="get">
                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"> <i class="fa fa-search"></i>  @lang('site.search')</button>

                                @if (auth()->user()->can('create_categories'))
                                    <a href="{{route('dashboard.categories.create')}}" class="btn btn-primary"> <i class="fa fa-plus"></i>  @lang('site.add')</a>
                                @else
                                    <button class="btn btn-primary disabled">@lang('site.add')</button>
                                @endif
                            </div>

                        </div>{{-- end of row --}}
                    </form> <!-- End form of search -->

                </div><!-- end of box header -->

                <div class="box-body">

                    {{-- Check count of categories --}}
                   @if($categories->count() > 0)

                        <table class="table table-bordered">

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('site.name')</th>
                                    <th>@lang('site.products_count')</th>
                                    <th>@lang('site.related_products')</th>
                                    <th>@lang('site.action')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->products->count() }}</td>
                                        <td><a href="{{ route('dashboard.products.index', ['category_id' => $category->id]) }}" class="btn btn-info"> @lang('site.related_products') </a> </td>
                                        <td>
                                            {{-- Check Perimssion edit --}}
                                            @if (auth()->user()->can('update_categories'))
                                                <a href="{{ route('dashboard.categories.edit', $category->id) }}" class="btn btn-info btn-sm"> <i class="fa fa-edit"></i> @lang('site.edit')</a>
                                            @else
                                                <a href="#" class="btn btn-info btn-sm disabled"> <i class="fa fa-edit"></i> @lang('site.edit')</a>
                                            @endif

                                            {{-- Check Perimssion delet --}}
                                            @if (auth()->user()->can('delete_categories'))

                                                <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="post" style="display: inline-block">
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

                       {{ $categories->appends(request()->query())->links() }}

                   @else
                       <h2>@lang('site.no_data_found')</h2>
                   @endif

                </div><!-- End of box-body -->

            </div><!-- End of box -->

        </section><!-- End of content -->

    </div>

@endsection

