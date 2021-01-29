
@extends('layouts.dashboard.app')

@section('title', __('site.products'))

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <h1>
                @lang('site.products')
            </h1>

            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('dashboard.index') }}"> <i class="fa fa-dashboard"></i> @lang('site.dashboard') </a>
                </li>

                <li class="active">
                    @lang('site.products')
                </li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border" style="padding: 15px">
                    <h3 class="box-title" style="padding-bottom: 20px"> @lang('site.products')  <small class="panel panel-info pl-5">{{ $products->total() }}</small> </h3>

                    <!-- Form of search -->
                    <form action="{{ route('dashboard.products.index') }}" method="get">
                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">
                            </div>
                            <div class="col-md-4">
                                <select name="category_id" class="form-control">
                                    <option value="">@lang('site.all_categories')</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ request()->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"> <i class="fa fa-search"></i>  @lang('site.search')</button>

                                @if (auth()->user()->can('create_products'))
                                    <a href="{{route('dashboard.products.create')}}" class="btn btn-primary"> <i class="fa fa-plus"></i>  @lang('site.add')</a>
                                @else
                                    <button class="btn btn-primary disabled">@lang('site.add')</button>
                                @endif
                            </div>

                        </div>{{-- end of row --}}
                    </form> <!-- End form of search -->

                </div><!-- end of box header -->

                <div class="box-body">

                    {{-- Check count of products --}}
                   @if($products->count() > 0)

                        <table class="table table-bordered">

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('site.name')</th>
                                    <th>@lang('site.barcode')</th>
                                    <th>@lang('site.qrcode')</th>
                                    <th>@lang('site.description')</th>
                                    <th>@lang('site.image')</th>
                                    <th>@lang('site.category')</th>
                                    <th>@lang('site.purchase_price')</th>
                                    <th>@lang('site.sale_price')</th>
                                    <th>@lang('site.profit_percent')</th>
                                    <th>@lang('site.stock')</th>

                                    <th>@lang('site.action')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{!! '<img width="100px" src="data:image/png;base64,'. barcode($product->code) .'" />' !!}</td>
                                        <td>{!! '<img src="data:'.qrCode($product->code)->getContentType().';base64,'.qrCode($product->code)->generate().'" />' !!}</td>
                                        <td>{!! $product->description !!}</td>
                                        <td><img src="{{ $product->image_path }}" style="height:150px; width: 1500px;" class="img-thumbnail" alt=""></td>
                                        <td>{{ $product->category->name }}</td>
                                        <td>{{ $product->purchase_price }}</td>
                                        <td>{{ $product->sale_price }}</td>
                                        <td>{{ $product->profit_percent }} %</td>
                                        <td>{{ $product->stock }}</td>

                                        <td>
                                            {{-- Check Perimssion edit --}}
                                            @if (auth()->user()->can('update_products'))
                                                <a href="{{ route('dashboard.products.edit', $product->id) }}" class="btn btn-info btn-sm"> <i class="fa fa-edit"></i> @lang('site.edit')</a>
                                            @else
                                                <a href="#" class="btn btn-info btn-sm disabled"> <i class="fa fa-edit"></i> @lang('site.edit')</a>
                                            @endif

                                            {{-- Check Perimssion delet --}}
                                            @if (auth()->user()->can('delete_products'))

                                                <form action="{{ route('dashboard.products.destroy', $product->id) }}" method="post" style="display: inline-block">
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

                       {{ $products->appends(request()->query())->links() }}

                   @else
                       <h2>@lang('site.no_data_found')</h2>
                   @endif

                </div><!-- End of box-body -->

            </div><!-- End of box -->

        </section><!-- End of content -->

    </div>

@endsection

