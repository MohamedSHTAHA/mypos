@extends('layouts.dashboard.app')

@section('title', __('site.create'))

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <h1> @lang('site.clients') </h1>
        <ol class="breadcrumb">
            <li><a class="active" href="{{ route('dashboard.index') }}"> <i class="fa fa-dashboard"></i>@lang('site.dashboard') </a></li>

            <li><a href="{{ route('dashboard.clients.index') }}"> @lang('site.clients') </a></li>
            {{--<li><a href="{{ route('dashboard.orders') }}"> @lang('site.orders') </a></li>--}}

            <li class="active">@lang('site.add')</li>
        </ol>
    </section>


    <section class="content">

        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title">@lang('site.categories')</h3>
                    </div><!-- end of box header -->

                    <div class="box-body">

                        <div style="display: none; flex-direction: column; align-items: center;" id="loading">
                            <div class="loader"></div>
                            <p style="margin-top: 10px">@lang('site.loading')</p>
                        </div>
                        <div id="categories-list">


                        </div>
                    <!--    @foreach ($categories as $category)
                        <div class="panel-group">

                            <div class="panel panel-info">

                                <div class="panel-heading" data-toggle="collapse" href="#{{ str_replace(' ', '-', $category->name)  }}">

                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#{{ str_replace(' ', '-', $category->name)  }}">{{ str_replace(' ', '-', $category->name)   }}</a>
                                    </h4>

                                </div>{{-- End of panel heading --}}


                                <div id="{{ str_replace(' ', '-', $category->name) }}" class="panel-collapse collapse">

                                    <div class="panel-body">

                                        @if ($category->products()->count() > 0)

                                        <table class="table table-hover">
                                            <tr>
                                                <th>@lang('site.name')</th>
                                                <th>@lang('site.stock')</th>
                                                <th>@lang('site.sale_price')</th>
                                                <th>@lang('site.add')</th>
                                            </tr>

                                            @foreach ($category->products as $product)
                                            <tr>

                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->stock }}</td>
                                                <td>{{ number_format($product->sale_price) }}</td>
                                                <td>

                                                    <a  id='product-{{ $product->id }}' data-name='{{ $product->name }}' data-stock='{{ $product->stock }}' data-id='{{ $product->id }}' data-price='{{ $product->sale_price }}' class="btn btn-success btn-sm add-product-btn">
                                                        <i class="fa fa-plus"></i>

                                                    </a>

                                                </td>

                                            </tr>
                                            @endforeach

                                        </table>

                                        @else
                                        <h3>@lang('site.no_data_found')</h3>
                                        @endif

                                    </div>



                                </div>

                            </div>{{-- End of panel-info --}}

                        </div>{{-- End of panel-group --}}

                        @endforeach
                    -->

                    </div><!-- End box-body -->

                </div><!-- End of box -->

            </div> <!-- End of col-md-6 -->


            <div class="col-md-6">

                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title">@lang('site.orders')</h3>
                    </div><!-- end of box header -->

                    <div class="box-body">

                        <form action="{{ route('dashboard.clients.orders.store', $client->id) }}" method="post">

                            @csrf

                            <table class="table table-hover">

                                <thead>
                                    <tr>
                                        <th>@lang('site.product')</th>
                                        <th>@lang('site.quantity')</th>
                                        <th>@lang('site.sale_price')</th>
                                        <th>@lang('site.price')</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody class="order-list">

                                    {{-- append from js --}}
                                </tbody>

                            </table>

                            <h4>
                                @lang('site.total') :
                                <span class="total-price">0</span>
                            </h4>
                            <div class="form-group">
                                <label>طريقة الدفع</label>
                                <select name="checkout_type" id="checkout_type" class="form-control" required>
                                    <option value="monetary">نقدى</option>
                                    <option value="online">اونلاين</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary disabled" id="add-order-form-btn"> @lang('site.add_order') </button>
                            </div>

                        </form>


                    </div><!-- End box-body -->

                </div><!-- End of box -->
                @if ($client->orders->count() > 0)

                        <div class="box box-primary">

                            <div class="box-header">

                                <h3 class="box-title" style="margin-bottom: 10px">@lang('site.previous_orders')
                                    <small>{{ $orders->total() }}</small>
                                </h3>

                            </div><!-- end of box header -->

                            <div class="box-body">

                                @foreach ($orders as $order)

                                    <div class="panel-group">

                                        <div class="panel panel-success">

                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" href="#{{ $order->created_at->format('d-m-Y-s') }}">{{ $order->created_at->toFormattedDateString() }}</a>
                                                </h4>
                                            </div>

                                            <div id="{{ $order->created_at->format('d-m-Y-s') }}" class="panel-collapse collapse">

                                                <div class="panel-body">

                                                    <ul class="list-group">
                                                        @foreach ($order->products as $product)
                                                            <li class="list-group-item">{{ $product->name }}</li>
                                                        @endforeach
                                                    </ul>

                                                </div><!-- end of panel body -->

                                            </div><!-- end of panel collapse -->

                                        </div><!-- end of panel primary -->

                                    </div><!-- end of panel group -->

                                @endforeach

                                {{ $orders->links() }}

                            </div><!-- end of box body -->

                        </div><!-- end of box -->

                    @endif
            </div><!-- End of col-md-6 -->


        </div>
    </section>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
$(document).ready(function(){
    categories();
});

function categories() {
    $("#categories-list").empty();
    $('#loading').css('display', 'flex');

    let url = "<?= route('dashboard.orders.categories') ?>";
    let method = "get";
    $.ajax({
        url: url,
        method: method,
        success: function (data) {
            $('#loading').css('display', 'none');
            $("#categories-list").empty();
            $("#categories-list").append(data);
        },
    });
}
</script>
@endsection
