<?php
    // 监听端口，与客户端一直才行
    $ws = new Swoole\WebSocket\Server("0.0.0.0", 9502);
    $ws->on('open', function ($ws, $request) {
//        $ws->push($request->fd, "hello,your id is $request->fd,welcome\n");
    });
    //监听WebSocket消息事件
    $ws->on('message', function ($ws, $frame) {
//        echo "recive from $frame->fd ,$frame->data";
//        $ws->push($frame->fd, "{$frame->data}");
        global $ws;
        foreach($ws->connections as $fd){
            if($ws->isEstablished($fd)){
                $ws->push($fd,"{$frame->data}");
            }
        }
    });

    //监听WebSocket连接关闭事件
    $ws->on('close', function ($ws, $fd) {
        echo "client-{$fd} is closed\n";
    });
    $ws->start();