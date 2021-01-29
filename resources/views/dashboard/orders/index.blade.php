
@extends('layouts.dashboard.app')

@section('title', __('site.orders'))

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <h1>
                @lang('site.orders')
            </h1>

            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('dashboard.index') }}"> <i class="fa fa-dashboard"></i> @lang('site.dashboard') </a>
                </li>

                <li class="active">
                    @lang('site.orders')
                </li>
            </ol>
        </section>{{-- end con content-header --}}

        <section class="content">
            <div class="row">
                <div class="col-md-8">

                    <div class="box box-primary">

                        <div class="box-header with-border" style="padding: 15px">

                            <h3 class="box-title" style="padding-bottom: 20px"> @lang('site.orders')<small class="panel panel-info pl-5">{{ $orders->total() }}</small> </h3>

                            <form action="{{ route('dashboard.orders.index') }}" method="get">

                                <div class="row">

                                    <div class="col-md-8">
                                        <input type="text" name="search" class="form-control" placeholder="search">
                                    </div>

                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary"> <i class="fa fa-search"> @lang('site.search')</i> </button>
                                        @if (auth()->user()->can('create_orders'))
                                            <a href="{{route('dashboard.orders.create')}}" class="btn btn-primary"> <i class="fa fa-plus"></i> @lang('site.add')</a>
                                        @else
                                            <button class="btn btn-primary disabled">@lang('site.add')</button>
                                        @endif
                                    </div>

                                </div>{{-- end of row --}}

                            </form>{{-- end of form --}}

                        </div><!-- end of box header -->

                        @if ($orders->count() > 0)

                            <div class="box-body table-responsive">

                                <table class="table table-hover">

                                    <tr>
                                        <th>@lang('site.client_name')</th>
                                        <th>المدفوع</th>
                                        <th>@lang('site.price')</th>
                                        {{--<th>@lang('site.status')</th>--}}
                                        <th>@lang('site.created_at')</th>
                                        <th>@lang('site.action')</th>

                                    </tr>

                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $order->client->name  }}</td>
                                            <td>
                                                @if($order->checkout_type == 'monetary')
                                                   {{ number_format($order->total_price,2)  }}
                                                @elseif($order->checkout_type == 'online')
                                                    {{ number_format($order->payments->sum('total_price'),2)  }}
                                                @endif
                                                
                                            </td>
                                            <td>{{number_format($order->total_price,2)  }}</td>
                                            {{--<td>

                                                <button

                                                    data-status = "@lang('site.' .$order->status)"
                                                    data-url = "{{ route('dashboard.orders.update_status') }}"
                                                    data-method="put"
                                                    data-available-status=' ["@lang('site.processing')"], "" '
                                                    class="order-status-btn btn {{ $order->status == 'processing' }}"
                                                    >

                                                    @lang('site.' .$order->status)

                                                </button>
                                            </td>--}}

                                            <td>{{ $order->created_at->toFormattedDateString() }}</td>

                                            <td>

                                                @if (auth()->user()->can('read_orders'))

                                                    <button class="btn btn-primary btn-sm order-products"

                                                            data-url = "{{ route('dashboard.orders.show', $order->id) }}"
                                                            data-method = 'get'
                                                            data-order-id= {{ $order->id }}
                                                    >
                                                        <i class="fa fa-list"></i>
                                                        @lang('site.show')

                                                    </button>
                                                @endif

                                                @if (auth()->user()->can('update_orders'))

                                                    <a href="{{ route('dashboard.clients.orders.edit', ['client' => $order->client->id, 'order' => $order->id]) }}" class="btn btn-warning btn-sm"> <i class="fa fa-edit"></i> @lang('site.update')</a>
                                                @else
                                                        <a href="#" class="btn btn-warning btn-sm">@lang('site.update')</a>
                                                @endif

                                                @if (auth()->user()->can('delete_orders'))

                                                    <form action="{{ route('dashboard.orders.destroy', $order->id) }}" method="post" style="display: inline-block">
                                                        @csrf
                                                        @method('delete')

                                                        <button type="submit" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> @lang('site.delete')</button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-danger btn-sm disabled"> <i class="fa fa-trash"></i> @lang('site.delete')</button>
                                                @endif
                                                @if($order->checkout_type == 'monetary')
                                                   <button class="btn btn-success btn-sm ">
                                                        <i style="color: red;" class="fa fa-money"></i>
                                                        تم الدفع نقدى
                                                    </button> 
                                                @elseif($order->checkout_type == 'online')
                                                    @if($order->total_price > $order->payments->sum('total_price'))
                                                        <button class="btn btn-success btn-sm order-checkout"

                                                                data-url = "{{ route('dashboard.orders.checkout', $order->id) }}"
                                                                data-method = 'get'
                                                                data-order-id= {{ $order->id }}>
                                                            <i style="color: red;" class="fa fa-cc-amex"></i>
                                                           دفع اون لاين
                                                        </button>
                                                    @else
                                                        <button class="btn btn-success btn-sm">
                                                            <i style="color: red;" class="fa fa-cc-amex"></i>
                                                            تم الدفع اونلاين
                                                        </button>
                                                    
                                                    @endif
                                                @endif

                                            </td>


                                        </tr>
                                    @endforeach

                                </table>{{-- end of table --}}
                                    {{ $orders->links() }}
                            </div><!-- End of box-body -->

                        @else

                            <div class="box-body">
                                <h3>@lang('site.no_records')</h3>
                            </div>

                        @endif

                    </div><!-- End of box-primary -->

                </div>{{-- end of col-md-8 --}}



                <div class="col-md-4">

                    <div class="box box-primary">

                        <div class="box-header with-border" style="padding: 15px">

                            <h3 class="box-title" style="padding-bottom: 20px"> @lang('site.products') </h3>

                            <div class="box-body table-responsive">
                                <div style="display: none; flex-direction: column; align-items: center;" id="loading">
                                    <div class="loader"></div>
                                    <p style="margin-top: 10px">@lang('site.loading')</p>
                                </div>
                                <div id="order-product-list">


                                </div>

                            </div>{{-- e    nd of box-body --}}

                        </div>{{-- end of box-header   --}}

                    </div>{{-- end of box-primary --}}

                </div>{{-- end of col-md-4 --}}

                <div class="col-md-12"></div>
                <div class="col-md-8"></div>

                <div class="col-md-4" hidden>

                    <div class="box box-primary">

                        <div class="box-header with-border" style="padding: 15px">

                            <h3 class="box-title" style="padding-bottom: 20px"> الدفع </h3>

                            <div class="box-body table-responsive">
                    
                                <!--<div style="display: none; flex-direction: column; align-items: center;" id="loading2">
                                    <div class="loader"></div>
                                    <p style="margin-top: 10px">@lang('site.loading')</p>
                                </div>-->
                                <div id="checkout2">


                                </div>

                            </div>{{-- e    nd of box-body --}}

                        </div>{{-- end of box-header   --}}

                    </div>{{-- end of box-primary --}}

                </div>{{-- end of col-md-4 --}}
            </div>{{-- end of row --}}

        </section><!-- End of content -->

    </div><!-- End of content-wrapper -->



    <!-- Modal -->
  <div class="modal fade" id="myModalInfo_checkout" role="dialog">
    <div class="modal-dialog" style="width:50%;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">الدفع</h4>
        </div>
        <div class="modal-body">
         
            <div style="display: none; flex-direction: column; align-items: center;" id="loading2">
                <div class="loader"></div>
                <p style="margin-top: 10px">@lang('site.loading')</p>
            </div>
            <div id="checkout">


            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

