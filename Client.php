<?php  
  $client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);  
  $client->on("connect", function($cli) {  
   # while(1){
      fwrite(STDOUT, "请输入消息：");
      $msg = trim(fgets(STDIN));
      if($msg){
        $cli->send($msg."\n");
      }  
   # } 
 });  
  $client->on("receive", function($cli, $data){  
    echo "Receive: $data\n";
    fwrite(STDOUT, "请输入消息：");
      $msg = trim(fgets(STDIN));
      if($msg){
        $cli->send($msg."\n");
      }
  });  
  $client->on("error", function($cli){  
    echo "connect fail\n";  
  });  
  $client->on("close", function($cli){  
    echo "close\n";  
  });  
  $client->connect('127.0.0.1', 9501, 0.5);  
?> 
