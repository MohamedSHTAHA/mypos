    <!-- DIRECT CHAT -->
    <div class="box box-warning direct-chat direct-chat-warning">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $to->first_name . ' ' . $to->last_name }}</h3>

            <div class="box-tools pull-right">
                <span data-toggle="tooltip" title="" class="badge bg-yellow chatsof_{{ $to->id }}"
                    data-original-title="{{$to->chats_resevied_total_count}} New Messages">{{$to->chats_resevied_total_count}}</span>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title=""
                    data-widget="chat-pane-toggle" data-original-title="Contacts">
                    <i class="fa fa-comments"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                </button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="">
            <!-- Conversations are loaded here -->
            <div class="direct-chat-messages" id="direct-chat-messages-{{ $to->id }}">
                @foreach ($chats as $chat)
                    @if ($chat->sender_id == Auth::user()->id)
                        <div class="direct-chat-msg">
                            <div class="direct-chat-info clearfix">
                                <span
                                    class="direct-chat-name pull-left">{{ Auth::user()->first_name }}{{ Auth::user()->last_name }}</span>
                                <span class="direct-chat-timestamp pull-right">{{ $chat->created_at }}</span>
                            </div>
                            <!-- /.direct-chat-info -->
                            <img class="direct-chat-img" src="{{ Auth::user()->image_path }}" alt="message user image">
                            <!-- /.direct-chat-img -->
                            <div class="direct-chat-text">
                                {{ $chat->message }}
                                <div>
                                @foreach ($chat->images_path as $file)
                                    {!! $file !!}
                                @endforeach
                                </div>
                            </div>
                            <!-- /.direct-chat-text -->
                        </div>
                    @elseif ($chat->receiver_id == Auth::user()->id)
                        <div class="direct-chat-msg right">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name pull-right">{{ $to->first_name . ' ' . $to->last_name }}</span>
                                <span class="direct-chat-timestamp pull-left">{{ $chat->created_at }}</span>
                            </div>
                            <!-- /.direct-chat-info -->
                            <img class="direct-chat-img" src="{{ $to->image_path }}" alt="message user image">
                            <!-- /.direct-chat-img -->
                            <div class="direct-chat-text">
                                {{ $chat->message }}
                                <div>
                                @foreach ($chat->images_path as $file)
                                    {!! $file !!}
                                @endforeach
                                </div>
                            </div>
                            <!-- /.direct-chat-text -->
                        </div>
                    @endif
                @endforeach

                <!--/.direct-chat-messages-->

            </div>
            <!-- /.box-body -->
            <div class="box-footer" style="">
                <form >
                    <div style="display: none; flex-direction: column; align-items: center;" id="loading">
                        <div class="loader"></div>
                        <p style="margin-top: 10px">جارى الارسال</p>
                    </div>
                    <div class="input-group">
                        
                        <input type="text" name="message" id="message" onblur="" onkeyup="typingChatoff()" onkeydown="typingChaton()" onfocus="readChat()" placeholder="Type Message ..."
                            class="form-control">
                        <input type="hidden" id="receiver_id" name="receiver_id" value="{{ $to->id }}">
                        
                      
                        <span class="input-group-btn">
                            <label style="cursor: pointer;" for="imgs" class="btn btn-primary btn-flat"><i class="fa fa-upload"></i></label>
                            <input onchange="previewImgs(this)" type="file" name="imgs[]" id="imgs" multiple style="opacity: 0;position: absolute;z-index: -1;"/>

                        </span>
                        <span class="input-group-btn">
                            <a id="send" onclick="sendMessageToServer()" type="button"
                                class="btn btn-warning btn-flat">Send</a>
                        </span>
                    </div>
                </form>
                <div id="previewImgs"></div>
            </div>
            <!-- /.box-footer-->
        </div>
        <!--/.direct-chat -->
