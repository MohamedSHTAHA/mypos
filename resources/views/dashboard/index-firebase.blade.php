@extends('layouts.dashboard.app')

@section('title', __('site.dashboard'))

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <h1>
                @lang('site.dashboard')
            </h1>

            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i> @lang('site.dashboard')
                </li>
            </ol>
        </section>


        <section class="content">


            <div class="row">
                {{-- categories--}}
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>{{ $categories_count }}</h3>

                            <p>@lang('site.categories')</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('dashboard.categories.index') }}" class="small-box-footer">@lang('site.read') <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                {{--products--}}
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>{{ $products_count }}</h3>

                            <p>@lang('site.products')</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('dashboard.products.index') }}" class="small-box-footer">@lang('site.read') <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                {{--clients--}}
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>{{ $clients_count }}</h3>

                            <p>@lang('site.clients')</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-user"></i>
                        </div>
                        <a href="{{ route('dashboard.clients.index') }}" class="small-box-footer">@lang('site.read') <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                {{--users--}}
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{ $users_count }}</h3>

                            <p>@lang('site.users')</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <a href="{{ route('dashboard.users.index') }}" class="small-box-footer">@lang('site.read') <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div><!-- end of row -->

            <div class="box box-solid">

                <div class="box-header">
                    <h3 class="box-title">Sales Graph</h3>
                </div>
                <div class="box-body border-radius-none">
                    <div class="chart" id="line-chart" style="height: 250px;"></div>
                </div>
                <!-- /.box-body -->
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!-- DIRECT CHAT -->
                    <div class="box-msg-users">
                        
                    </div>
                    <!--/.direct-chat -->
                </div>
                <!-- /.col -->

                <div class="col-md-6">
                    <!-- USERS LIST -->
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">Latest Members</h3>

                            <div class="box-tools pull-right">
                                <span class="label label-danger">8 New Members</span>
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                            <ul class="users-list clearfix">
                                @foreach ($users as $user)
                                    <li>
                                        <img src="{{ $user->image_path }}" alt="User Image">
                                        <a class="users-list-name" onclick="getUserMessages({{ $user->id }})"
                                            href="javascript:void(0)">{{ $user->last_name }}</a>
                                        <span class="users-list-date">Today</span>
                                    </li>
                                @endforeach

                            </ul>
                            <!-- /.users-list -->
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer text-center">
                            <a href="javascript:void(0)" class="uppercase">View All Users</a>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <!--/.box -->
                </div>
                <!-- /.col -->
            </div>


        </section>

    </div>

@endsection

@push('scripts')
    <script>
        //line chart
        var line = new Morris.Line({
            element: 'line-chart',
            resize: true,
            data: [
                @foreach ($sales_data as $data)
                {
                    ymd: "{{ $data->year }}-{{ $data->month }}-{{ $data->day }}",
                    sum: "{{ $data->sum }}"

                },
                @endforeach
            ],
            xkey: 'ymd',
            ykeys: ['sum'],
            labels: ['@lang('site.total ')'],
            lineWidth: 2,
            hideHover: 'auto',
            gridStrokeWidth: 0.4,
            pointSize: 4,
            gridTextFamily: 'Open Sans',
            gridTextSize: 10
        });

    </script>

    <script>
        // Retrieve Firebase Messaging object.
        const messaging = firebase.messaging();
        // Add the public key generated from the console here.
        messaging.usePublicVapidKey(
            "BERsidbH2V6oGEfyVKBc7-73kQj4i9H3wWFohnHkqd_m3F8R47DbR3NQuOU4k2yUUjeqyCYwdx2BFoLTVSGox1Q");



        // Get Instance ID token. Initially this makes a network call, once retrieved
        // subsequent calls to getToken will return from cache.
        /*messaging.getToken().then((currentToken) => {
            if (currentToken) {
                sendTokenToServer(currentToken);
                //updateUIForPushEnabled(currentToken);
            } else {
                // Show permission request.
                alert('allow notification');
                console.log('No Instance ID token available. Request permission to generate one.');
                // Show permission UI.
                //updateUIForPushPermissionRequired();
                //setTokenSentToServer(false);
            }
        }).catch((err) => {
            console.log('An error occurred while retrieving tokennn. ', err);
            //showToken('Error retrieving Instance ID token. ', err);
            //setTokenSentToServer(false);
        });*/

        function retrieveToken() {
            messaging.getToken().then((currentToken) => {
                if (currentToken) {
                    console.log(currentToken);
                    sendTokenToServer(currentToken);
                    //updateUIForPushEnabled(currentToken);
                } else {
                    // Show permission request.
                    alert('allow notification');
                    console.log('No Instance ID token available. Request permission to generate one.');
                    // Show permission UI.
                    //updateUIForPushPermissionRequired();
                    //setTokenSentToServer(false);
                }
            }).catch((err) => {
                console.log('An error occurred while retrieving tokennn. ', err);
                //showToken('Error retrieving Instance ID token. ', err);
                //setTokenSentToServer(false);
            });
        }

        retrieveToken();

        // Callback fired if Instance ID token is updated.
        messaging.onTokenRefresh(() => {
            retrieveToken();
        });

        messaging.onMessage((payload) => {
            console.log('Message received. ', payload);
            //alert();
            // ...
            //location.reload();
            //$('.direct-chat-messages').append('test');
            var notification = new Notification(payload.data.sender_name, {
                icon: 'http://cdn.sstatic.net/stackexchange/img/logos/so/so-icon.png',
                body: payload.data.message,
            });
            notification.onclick = function() {
                window.open('{{ route('dashboard.index') }}');
            };
            $('#direct-chat-messages-'+payload.data.sender_id).append(`<div class="direct-chat-msg right">
                                                                            <div class="direct-chat-info clearfix">
                                                                                <span class="direct-chat-name pull-right">${payload.data.sender_name}</span>
                                                                                <span class="direct-chat-timestamp pull-left">${payload.data.created_at}</span>
                                                                            </div>
                                                                            <!-- /.direct-chat-info -->
                                                                            <img class="direct-chat-img" src="{{ asset('dashboard') }}/dist/img/user3-128x128.jpg" alt="message user image">
                                                                            <!-- /.direct-chat-img -->
                                                                            <div class="direct-chat-text">
                                                                                    ${payload.data.message}
                                                                            </div>
                                                                            <!-- /.direct-chat-text -->
                                                                        </div>`);

        });





        function sendMessageToServer() {
            axios.post('{{ route('dashboard.createChat') }}', {
                        message: $('#message').val(),
                        to_id: $('#to_id').val(),
                    })
                .then(function(response) {
                    //console.log(response);
                    /*console.log(response.data);
                    console.log(response.status);
                    console.log(response.statusText);
                    console.log(response.headers);
                    console.log(response.config);*/
                    if (response.status == 200) {
                        $('#message').val('');
                        $('#direct-chat-messages-'+response.data.to_id).append(`<div class="direct-chat-msg">
                                                                                    <div class="direct-chat-info clearfix">
                                                                                        <span class="direct-chat-name pull-left">${response.data.sender_name}</span>
                                                                                        <span class="direct-chat-timestamp pull-right">${response.data.created_at}</span>
                                                                                    </div>
                                                                                    <!-- /.direct-chat-info -->
                                                                                    <img class="direct-chat-img" src="{{ Auth::user()->image_path }}" alt="message user image">
                                                                                    <!-- /.direct-chat-img -->
                                                                                    <div class="direct-chat-text">
                                                                                        ${response.data.message}
                                                                                    </div>
                                                                                    <!-- /.direct-chat-text -->
                                                                                </div>`);
                    } else {
                        alert('error');
                    }


                })
                .catch(function(error) {
                    console.log(error);
                });
        }

        function sendTokenToServer(fcm_token) {
            const user_id = "{{ Auth::user()->id }}";
            //console.log('user_id: ',user_id);

            //console.log('token received: ',fcm_token);
            axios.post('{{ route('dashboard.save-token') }}', {
                        fcm_token,
                        user_id
                    })
                .then(function(response) {
                    //console.log(response);
                })
                .catch(function(error) {
                    console.log(error);
                });
        }


        function getUserMessages(to_id) {
            axios.post('{{ route('dashboard.getUserMessages') }}', {
                        to_id
                    })
                .then(function(response) {
                    //console.log(response);
                    //alert();
                    $('.box-msg-users').empty();
                    $('.box-msg-users').append(response.data);


                })
                .catch(function(error) {
                    console.log(error);
                });
        }

    </script>
@endpush
