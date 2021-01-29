@extends('layouts.dashboard.app')

@section('title', __('site.create'))

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <h1> @lang('site.products') </h1>
        <ol class="breadcrumb">
            <li>
                <a class="active" href="{{ route('dashboard.index') }}"> <i class="fa fa-dashboard"></i>
                    @lang('site.dashboard') </a>
            </li>

            <li>
                <a href="{{ route('dashboard.products.index') }}"> <i class="fa fa-dashboard"></i> @lang('site.products') </a>
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
                <form action="{{route('dashboard.products.store')}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('post')}}

                    <div class="form-group">
                        <label>@lang('site.categories')</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">@lang('site.all_categories')</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    @foreach (config('translatable.locales') as $locale)
                    <div class="form-group">
                        <label>@lang('site.' . $locale . '.name')</label>
                        <input type="text" name="{{ $locale }}[name]" class="form-control" value="{{ old($locale . '.name') }}" required>
                    </div>

                    <div class="form-group">
                        <label>@lang('site.' . $locale . '.description')</label>
                        <textarea name="{{ $locale }}[description]" class="form-control ckeditor" required>{{ old($locale . '.description') }}</textarea>
                    </div>
                    @endforeach


                    <div class="form-group">
                        <label>@lang('site.image')</label>
                        <input type="file" name="image" class="form-control image  " />
                    </div>
                    <div class="form-group">
                        <img src="{{ asset('uploads/product_images/default.png')}}" style="width: 100px;" class="img-thumbnail  image-preview" alt="">
                    </div>

                    <div class="form-group">
                        <label>@lang('site.purchase_price')</label>
                        <input type="number" name="purchase_price" class="form-control  " value="{{old('purchase_price')}}" required />
                    </div>

                    <div class="form-group">
                        <label>@lang('site.sale_price')</label>
                        <input type="number" name="sale_price" step="0.01" class="form-control" value="{{ old('sale_price') }}" required />
                    </div>

                    <div class="form-group">
                        <label>@lang('site.stock')</label>
                        <input type="number" name="stock" class="form-control" value="{{ old('stock') }}" required />
                    </div>


                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('site.add')</button>
                    </div>
                </form>

            </div><!-- End box-body -->

        </div><!-- End of box -->

    </section>

</div>

@endsection
