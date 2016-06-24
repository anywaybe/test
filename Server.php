<?php  
  $serv = new swoole_server("0.0.0.0", 9501);  
  
  $serv->set(array(
            'worker_num' => 8,
            'daemonize' => false,
            'max_request' => 10000,
            'dispatch_mode' => 2,
            'debug_mode'=> 1 ,
        ));
  #$serv->on('WorkerStart', 'onWorkerStart');
  #$serv->on('Timer', 'onTimer');

  function onWorkerStart( $serv , $worker_id) {
		// 在Worker进程开启时绑定定时器
        echo "onWorkerStart\n";
        // 只有当worker_id为0时才添加定时器,避免重复添加
        if( $worker_id == 0 ) {
        	$serv->addtimer(1);
	        $serv->addtimer(5);
            $serv->addtimer(10);
        }
  }

  function onTimer($serv, $interval) {
    	switch( $interval ) {
    		case 500: {	// 
    			echo "Do Thing A at interval 500\n";
    			break;
    		}
    		case 1000:{
    			echo "Do Thing B at interval 1000\n";
    			break;
    		}
    		case 100:{
    			echo "Do Thing C at interval 100\n";
    			break;
    		}
    	}
    }
  
  $serv->on('connect', function ($serv, $fd){  
    echo "Client: ".$fd." Connect.\n";  
  });  
  $serv->on('receive', function ($serv, $fd, $from_id, $data) {  
    echo $from_id.": ".$data;
    $serv->send($fd, $fd. ': '.$data);  
  });  
  $serv->on('close', function ($serv, $fd) {  
    echo "Client: ".$fd." Close.\n";  
  });  
  $serv->start();  
?> 
