<?php
$server = new swoole_websocket_server("0.0.0.0", 9502);

$server->on('open', function($server, $req) {
    echo "connection open: {$req->fd}\n";
});

$server->on('message', function($server, $frame) {
//    echo "received message:{$frame->data}";
    echo "<pre>";print_r($frame);echo "</pre>";
//    $server->push($frame->fd, $frame->data);
    //检查当前的连接信息 广播信息
    foreach($server->connections as $fds){
        //判断是否正确的websocket链接
        if($server->isEstablished($fds)){
            $server->push($fds, $frame->data);
        }
    }

});

$server->on('close', function($server, $fd) {
    echo "connection close: {$fd}\n";
});

$server->start();