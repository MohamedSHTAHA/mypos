    <!-- DIRECT CHAT -->
    <div class="box box-warning direct-chat direct-chat-warning">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $to->first_name . ' ' . $to->last_name }}</h3>

            <div class="box-tools pull-right">
                <span data-toggle="tooltip" title="" class="badge bg-yellow"
                    data-original-title="3 New Messages">-</span>
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
                            </div>
                            <!-- /.direct-chat-text -->
                        </div>
                    @else
                        <div class="direct-chat-msg right">
                            <div class="direct-chat-info clearfix">
                                <span
                                    class="direct-chat-name pull-right">{{ $to->first_name . ' ' . $to->last_name }}</span>
                                <span class="direct-chat-timestamp pull-left">{{ $chat->created_at }}</span>
                            </div>
                            <!-- /.direct-chat-info -->
                            <img class="direct-chat-img" src="{{ $to->image_path }}" alt="message user image">
                            <!-- /.direct-chat-img -->
                            <div class="direct-chat-text">
                                {{ $chat->message }}
                            </div>
                            <!-- /.direct-chat-text -->
                        </div>
                    @endif
                @endforeach

                <!--/.direct-chat-messages-->

            </div>
            <!-- /.box-body -->
            <div class="box-footer" style="">
                <form>
                    <div class="input-group">
                        <input type="text" name="message" id="message" placeholder="Type Message ..."
                            class="form-control">
                        <input type="hidden" id="to_id" name="to_id" value="{{ $to->id }}">
                        <span class="input-group-btn">
                            <button onclick="sendMessageToServer()" type="button"
                                class="btn btn-warning btn-flat">Send</button>
                        </span>
                    </div>
                </form>
            </div>
            <!-- /.box-footer-->
        </div>
        <!--/.direct-chat -->
