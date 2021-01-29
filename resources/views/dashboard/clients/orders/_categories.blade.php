       
    @foreach ($categories as $category)
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

                    <table  class="table table-hover ex ">
                        <thead>
                        <tr>
                            <th>@lang('site.name')</th>
                            <th>@lang('site.stock')</th>
                            <th>@lang('site.sale_price')</th>
                            <th>@lang('site.add')</th>
                        </tr>
                        </thead>
                        <tbody >
                        @foreach ($category->products as $product)
                        <tr>

                            <td>{{ $product->name }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ number_format($product->sale_price) }}</td>
                            <td>

                                <a  id='product-{{ $product->id }}' data-name='{{ $product->name }}' data-stock='{{ $product->stock }}' data-id='{{ $product->id }}' data-price='{{ $product->sale_price }}' class="btn  btn-sm add-product-btn    {{ !empty($order) ? (in_array($product->id, $order->products->pluck('id')->toArray()) ? ' btn-default disabled ' : ' btn-success '):' btn-success ' }}">
                                    <i class="fa fa-plus"></i>

                                </a>

                            </td>

                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                    @else
                    <h3>@lang('site.no_data_found')</h3>
                    @endif

                </div>



            </div>

        </div>{{-- End of panel-info --}}

    </div>{{-- End of panel-group --}}
    @endforeach

<script>
$('.ex').DataTable( {
    //scrollY:        300,
    //scrollY:        true,
    //scrollCollapse: true,
    //paging:         false,
    dom: 'Bfrtip',
    lengthMenu: [
        [ 10, 25, 50,100, -1 ],
        [ '10', '25', '50', '100' ,'عرض الكل' ]
    ]
    , buttons: [

        {
            extend: 'print'
            ,text  : '<i class="fa fa-print" style="font-size:18px;color:blue"></i>'
            , exportOptions: {
                columns: ':visible'
            },

        },
        {
            extend: 'colvis'
            ,'text':'<i class="fa fa-eye-slash" style="font-size:18px;color:red"></i> '
            , footer: false
        },
        {
            extend: 'pageLength'
            , footer: false
        },
        


    ],




    language: {
        buttons: {
            pageLength: {
                _: " عرض %d  صفوف",
                '-1': "الكل"
            }
        },
        url:  "//cdn.datatables.net/plug-ins/1.10.20/i18n/{{ LaravelLocalization::getCurrentLocaleName() }}.json"
    }
} );
</script>