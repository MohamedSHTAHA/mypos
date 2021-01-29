@extends('layouts.dashboard.app')

@section('title', __('site.create'))

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <h1> @lang('site.add_order') </h1>
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
                   

                    </div><!-- End box-body -->

                </div><!-- End of box -->

            </div> <!-- End of col-md-6 -->


            <div class="col-md-6">

                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title">@lang('site.orders')</h3>
                    </div><!-- end of box header -->

                    <div class="box-body">

                        <form id="formstoreorder" action="{{ route('dashboard.clients.orders.store',1) }}" method="post">

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
                                <label>اختر العميل</label>
                                
                                <input type="text" onclick="getClient()" class="form-control" readonly name="client_name" id="client_name" value="عميل جارى"/>
                                <input type="hidden"  name="client_id" id="client_id" value=""/>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary disabled" id="add-order-form-btn"> @lang('site.add_order') </button>
                            </div>

                        </form>


                    </div><!-- End box-body -->

                </div><!-- End of box -->
              
            </div><!-- End of col-md-6 -->


        </div>
    </section>

</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">@lang('site.clients')</h4>
      </div>
      <div class="modal-body">
                <div class="table-responsive">
                    <table id="example" class="table table-bordered ">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>اختر</th>
                            </tr>
                        </thead>
                    </table>
                </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('site.close')</button>
      </div>
    </div>

  </div>
</div>

@endsection

@push('scripts')

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


<script>
function setClient(th){
   var id = th.data("id");
   var name = th.val();
   $('#client_name').val(name);
   $('#client_id').val(id);
    $('#myModal').modal('toggle');
    

   //$('#formstoreorder').attr('action', "{{ url('').'/'.LaravelLocalization::getCurrentLocale() }}/dashboard/clients/"+id+"/orders");
   $('#formstoreorder').attr('action', "{{ url('').'/'.LaravelLocalization::getCurrentLocale() }}/dashboard/clients/"+id+"/orders");


}

function getClient(){
    var table  = $('#example').DataTable({
            destroy: true,
            processing: true,
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
                    ,'text':'<i class="fa fa-eye-slash" style="font-size:18px;color:red"></i>اخفاء عمود'
                    , footer: false
                }, {
                    extend: 'pageLength'
                    , footer: false
                }


            ],




            language: {
                buttons: {
                    pageLength: {
                        _: " عرض %d  صفوف",
                        '-1': "الكل"
                    }
                },
                url:  "//cdn.datatables.net/plug-ins/1.10.20/i18n/{{ LaravelLocalization::getCurrentLocaleName() }}.json"
            },
            ajax: '{{ route('dashboard.get-clients') }}'
            , columns: [
                {data: 'test', name: 'test','searchable': false,'orderable': false},
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'phone', name: 'phone'},
                {data: 'setClient', name: 'setClient'}
            ]
        });



        // Handle click on "Select all" control
        $('#example-select-all').on('click', function(){
            // Get all rows with search applied
            var rows = table.rows({ 'search': 'applied' }).nodes();
            // Check/uncheck checkboxes for all rows in the table
            $('input[type="checkbox"]', rows).prop('checked', this.checked);
        });

        // Handle click on checkbox to set state of "Select all" control
        $('#example tbody').on('change', 'input[type="checkbox"]', function(){
            // If checkbox is not checked
            if(!this.checked){
                var el = $('#example-select-all').get(0);
                // If "Select all" control is checked and has 'indeterminate' property
                if(el && el.checked && ('indeterminate' in el)){
                    // Set visual state of "Select all" control
                    // as 'indeterminate'
                    el.indeterminate = true;
                }
            }
        });

        // Handle form submission event
        $('#frm-example').on('submit', function(e){
            var form = this;

            // Iterate over all checkboxes in the table
            table.$('input[type="checkbox"]').each(function(){
                // If checkbox doesn't exist in DOM
                if(!$.contains(document, this)){
                    // If checkbox is checked
                    if(this.checked){
                    // Create a hidden element
                    $(form).append(
                        $('<input>')
                            .attr('type', 'hidden')
                            .attr('name', this.name)
                            .val(this.value)
                    );
                    }
                }
            });
        });
        $('#myModal').modal('toggle');

}
</script>    
@endpush