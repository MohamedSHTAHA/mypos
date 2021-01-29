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
                

                {{--<div class="col-md-6">
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
                        <div class="box-body no-padding" style="overflow: scroll;height: 300px;">
                            <ul class="users-list clearfix" >
                                @foreach ($users as $user)
                                    <li>
                                        <img src="{{ $user->image_path }}" alt="User Image">
                                        <span data-toggle="tooltip" title="" class="badge bg-yellow chatsof_{{ $user->id }}" data-original-title="{{$user->chats_resevied_total_count}} New Messages">{{$user->chats_resevied_total_count}}</span>
                                        <a class="users-list-name" onclick="getUserchats({{ $user->id }})"
                                            href="javascript:void(0)">{{ $user->first_name }}</a>

                                        <span class="users-list-date typing_{{ $user->id }}"></span>
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
                </div>--}}
                <div class="col-md-6">
                    <div class="box box-solid" >
                        <div class="box-header with-border">
                        <h3 class="box-title" >الاصدقاء</h3>
                        <input class=" btn-block margin-bottom" type="text" id="myInput" onkeyup="myFunctionSearch()" placeholder="الاسم" title="">
                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                        </div>
                        <div class="box-body no-padding" style="overflow: scroll;height: 500px;">
                            <ul class="nav nav-pills nav-stacked" id="myUL">
                                @foreach ($users as $user)
                                    <li class="active">
                                        <a onclick="getUserchats({{ $user->id }})" href="javascript:void(0)">
                                            <img width="20px" height="20px" src="{{ $user->image_path }}" alt="User Image"> {{ $user->first_name }}
                                            <span class="badge bg-yellow  pull-right chatsof_{{ $user->id }}">{{$user->chats_resevied_total_count}}</span>
                                            <span class="users-list-date typing_{{ $user->id }}"></span>
                                        </a>
                                    </li>
                                @endforeach
                                
                            </ul>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /. box -->
        
                </div>
                <!-- /.col -->
                <div class="col-md-6">
                    <!-- DIRECT CHAT -->
                    <div class="box-msg-users">
                        
                    </div>
                    <!--/.direct-chat -->
                </div>
                <!-- /.col -->
            </div>
            {{--<div  class="row">
                <h2>Chat Messages</h2>

                <div  id="boradcast">
                
                </div>
                <div  id="chat">
                
                
                </div>
                <hr /> 
                Username: <input  class="container" type="text" id="username"> <br>
                <textarea class="container" id="message" placeholder="message"></textarea>
                <button id="send">Send </button>
            </div>--}}

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

   <script type="text/javascript" >

        var socket = io.connect('http://localhost:5000', {
            query: "user_id={{auth()->user()->id}}&myfriends={{auth()->user()->friends}}"
        });

        function sendMessageToServer() {  
            $('#send').attr('disabled', 'disabled');
            $('#loading').css('display', 'flex');
            var data = new FormData();
            jQuery.each(jQuery('#imgs')[0].files, function(i, file) {
                data.append('file[]', file);
            });        
            //data.append("_token", "{{ csrf_token() }}");
            data.append("message", $('#message').val());
            data.append("receiver_id", $('#receiver_id').val());
   
            axios.post('{{ route('dashboard.saveChat') }}',data,
                    {headers: {'Content-Type': 'multipart/form-data'}})
                .then(function(response){
                    console.log(response);
                    //console.log(response.data);
                    
                    if (response.status == 200) {
                        $('#loading').css('display', 'none');
                        $('#message').val('');
                        $('#imgs').val('');
                        $("#previewImgs").html("");
                        $('#send').removeAttr("disabled");

                        socket.emit('message', {
                            data: response.data
                        });
                    } else {
                        alert('error not send');
                        $('#loading').css('display', 'none');
                        $('#message').val('');
                        $('#imgs').val('');
                        $("#previewImgs").html("");
                        $('#send').removeAttr("disabled");
                    }
                }).catch(function(error){
                    console.log('FAILURE!!',error);
                    $('#message').val('');
                    $('#imgs').val('');
                    $("#previewImgs").html("");
                    $('#send').removeAttr("disabled");
            });    
            /*axios.post('{{ route('dashboard.saveChat') }}', {
                        message: $('#message').val(),
                        receiver_id: $('#receiver_id').val(),
                    })
                .then(function(response) {
                    //console.log(response);
                    //console.log(response.data);
                    
                    if (response.status == 200) {
                        $('#message').val('');
                        socket.emit('message', {
                            data: response.data
                        });
                    } else {
                        alert('error not send');
                    }


                })
                .catch(function(error) {
                    console.log(error);
                });*/
        }
        function readChat() {            
            axios.post('{{ route('dashboard.readChat') }}', {
                    read_chat_of_id: $('#receiver_id').val(),
                })
            .then(function(response) {
                //console.log(response);
                //console.log(response.data);
                
                if (response.status == 200) {
                    $('.chatsof_'+$('#receiver_id').val()).text('0');

                } else {
                    alert('error not send');
                }


            })
            .catch(function(error) {
                console.log(error);
            });
        }


        function typingChaton() {            
            socket.emit('typingChaton', {
                receiver_id : $('#receiver_id').val(),
                sender_id   : "{{auth()->user()->id}}"
            });
        }
        function typingChatoff() {            
            socket.emit('typingChatoff', {
                receiver_id : $('#receiver_id').val(),
                sender_id   : "{{auth()->user()->id}}"

            });
        }


        socket.on('new_msg', function (response) {
            console.log('data msg : ', response);
            //alert(response.data.receiver_id );
            //alert();
            socket.emit('readChat', {
                receiver_id: response.data.receiver_id ,
                sender_id: response.data.sender_id 
            });
            if(response.data.sender_id == {{Auth::user()->id}}){
                //alert(response.data.sender_id);
                /*var notification = new Notification("{{Auth::user()->first_name}}", {
                    icon: "{{ Auth::user()->image_path }}",
                    body: response.data.message,
                });
                notification.onclick = function() {
                    window.open('{{ route('dashboard.index') }}');
                };*/
                $('#direct-chat-messages-'+response.data.receiver_id).append(`<div class="direct-chat-msg">
                                                                                        <div class="direct-chat-info clearfix">
                                                                                            <span class="direct-chat-name pull-left">{{ Auth::user()->first_name }}</span>
                                                                                            <span class="direct-chat-timestamp pull-right">${response.data.created_at}</span>
                                                                                        </div>
                                                                                        <!-- /.direct-chat-info -->
                                                                                        <img class="direct-chat-img" src="{{ Auth::user()->image_path }}" alt="message user image">
                                                                                        <!-- /.direct-chat-img -->
                                                                                        <div class="direct-chat-text">
                                                                                            
                                                                                            ${response.data.message}
                                                                                            <div>${response.data.images_path}</div>
                                                                                        </div>
                                                                                        <!-- /.direct-chat-text -->
                                                                                    </div>`);
            }
            if(response.data.receiver_id == {{Auth::user()->id}}) {
                //alert(response.data.receiver_id);
                var notification = new Notification(response.data.sender.first_name, {
                    icon: response.data.sender.image_path,
                    body: response.data.message,
                });
                notification.onclick = function() {
                    window.open('{{ route('dashboard.index') }}');
                };
                $('#direct-chat-messages-'+response.data.sender_id).append(`<div class="direct-chat-msg right">
                                                                                        <div class="direct-chat-info clearfix">
                                                                                            <span class="direct-chat-name pull-left">${response.data.sender.first_name}</span>
                                                                                            <span class="direct-chat-timestamp pull-right">${response.data.created_at}</span>
                                                                                        </div>
                                                                                        <!-- /.direct-chat-info -->
                                                                                        <img class="direct-chat-img" src="${response.data.sender.image_path}" alt="message user image">
                                                                                        <!-- /.direct-chat-img -->
                                                                                        <div class="direct-chat-text">
                                                                                            ${response.data.message}
                                                                                            <div>${response.data.images_path}</div>
                                                                                        </div>
                                                                                        <!-- /.direct-chat-text -->
                                                                                    </div>`);
            }
            //$(".direct-chat-messages").scrollTop($(".direct-chat-messages")[0].scrollHeight);

        });


        socket.on('readChat', function (data) {
            //console.log('data readChat : ', data);
            axios.post('{{ route('dashboard.chatsReseviedTotal') }}', {
                    receiver_id: data.receiver_id,
                    sender_id: data.sender_id
                })
            .then(function(response) {
                //console.log(response);
                console.log(response.data);
                
                if (response.status == 200) {
                    $('.chatsof_'+response.data.sender_id).text(response.data.chats_resevied_total_count);
                } else {
                    alert('error not send');
                }


            })
            .catch(function(error) {
                console.log(error);
            });
        });

        socket.on('typingChaton', function (response) {
            console.log('data typingChaton : ', response);
            $('.typing_'+response.sender_id).text('Typing.....');

        });
        socket.on('typingChatoff', function (response) {
            console.log('data typingChatoff : ', response);
            $('.typing_'+response.sender_id).text('');

        });

        socket.on('login', function (data) {
            console.log('data login : ', data);
            axios.post('{{ route('dashboard.myFriend') }}', {
                    myfrind: data,
                })
            .then(function(response) {
                //console.log(response);
                //console.log(response.data);
                
                if (response.status == 200) {
                   if (response.data.status) {
                        var notification = new Notification(`${ response.data.myFriend.first_name } Online`, {
                            icon: `${ response.data.myFriend.image_path }`,
                            body: `${ response.data.myFriend.first_name }`,
                        });
                        notification.onclick = function() {
                            window.open('{{ route('dashboard.index') }}');
                        };
                    } 
                } else {
                    alert('error not send');
                }


            })
            .catch(function(error) {
                console.log(error);
            });
            
        });


        socket.on('isActive', function (id) {
            //console.log('data myfriend onlines : ', id);
            $('.chatsof_'+id).removeClass('bg-yellow').addClass('bg-light-blue');
            
        });
        socket.on('areActive', function (ids) {
            for (var index in ids) {
                console.log('data myfriend onlines : ', ids[index]);
                $('.chatsof_'+ids[index]).removeClass('bg-yellow').addClass ('bg-light-blue');
            }
            //
            
        });

        /*socket.on('logout', function (data) {
            console.log('data logout : ', data);
            axios.post('{{ route('dashboard.myFriend') }}', {
                    myfrind: data,
                })
            .then(function(response) {
                //console.log(response);
                //console.log(response.data);
                
                if (response.status == 200) {
                   if (response.data.status) {
                        $('.chatsof_'+id).addClass('bg-yellow').removeClass('bg-light-blue');

                        var notification = new Notification(`${ response.data.myFriend.first_name } logout`, {
                            icon: `${ response.data.myFriend.image_path }`,
                            body: `${ response.data.myFriend.first_name }`,
                        });
                        notification.onclick = function() {
                            window.open('{{ route('dashboard.index') }}');
                        };
                    } 
                } else {
                    alert('error not send');
                }


            })
            .catch(function(error) {
                console.log(error);
            });
            
        });*/
        socket.on('logout', function (data) {
            console.log('data logout : ', data);
            axios.post('{{ route('dashboard.myFriend') }}', {
                    myfrind: data,
                })
            .then(function(response) {
                //console.log(response);
                //console.log(response.data);
                
                if (response.status == 200) {
                   if (response.data.status) {
                        $('.chatsof_'+response.data.myFriend.id).addClass('bg-yellow'). removeClass('bg-light-blue');

                        var notification = new Notification(`${ response.data.myFriend.first_name } Offline`, {
                            icon: `${ response.data.myFriend.image_path }`,
                            body: `${ response.data.myFriend.first_name }`,
                        });
                        notification.onclick = function() {
                            window.open('{{ route('dashboard.index') }}');
                        };
                    } 
                } else {
                    alert('error not send');
                }


            })
            .catch(function(error) {
                console.log(error);
            });
            
        });
      

        function new_logout(){
            socket.emit('logout');
        }

    </script>



    <script>
        function getUserchats(receiver_id) {
            axios.post('{{ route('dashboard.getUserchats') }}', {
                        receiver_id
                    })
                .then(function(response) {
                    console.log(response);
                    //alert();
                    var classes =  $('.chatsof_'+receiver_id).attr("class").split(/\s+/);
                    $('.box-msg-users').empty();
                    $('.box-msg-users').append(response.data);
                    $(".direct-chat-messages").scrollTop($(".direct-chat-messages")[0].scrollHeight);
                    $('.chatsof_'+receiver_id).removeClass('bg-yellow').removeClass('bg-light-blue').addClass(classes);

                })
                .catch(function(error) {
                    console.log(error);
                });
            }

            function previewImgs(input){
                if (input.files) {
                    $("#previewImgs").html("");

                    var filesAmount = input.files.length;
                    for (const file of input.files) {
                        console.log(file);
                        var reader = new FileReader();
                        reader.onload = function(event) {
                            if(file.type.match('image')){
                                $($.parseHTML('<img width="100px" height="70px">')).attr('src', event.target.result).appendTo('div#previewImgs');
                            }else{
                                $("<a><i class='fa fa-file' style='font-size:30px;color:red'></i>"+file.name+"</a>").appendTo('div#previewImgs');
                            }
                        }
                        reader.readAsDataURL(file);


                    }
                  
                }
            }
    </script>
    <script>
        function myFunctionSearch() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            ul = document.getElementById("myUL");
            li = ul.getElementsByTagName("li");
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName("a")[0];
                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        }
    </script>

@endpush
