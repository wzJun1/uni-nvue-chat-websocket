<?php
//declare(ticks=1);

/**
 * 聊天主逻辑
 * 主要是处理 onMessage onClose 
 */
use \GatewayWorker\Lib\Gateway;

class Events
{
   
   /**
    * 有消息时
    * @param int $client_id
    * @param mixed $message
    */
   public static function onMessage($client_id, $message)
   {
        // debug
//        echo "client:{$_SERVER['REMOTE_ADDR']}:{$_SERVER['REMOTE_PORT']} gateway:{$_SERVER['GATEWAY_ADDR']}:{$_SERVER['GATEWAY_PORT']}  client_id:$client_id session:".json_encode($_SESSION)." onMessage:".$message."\n";
        
        // 客户端传递的是json数据
        $message_data = json_decode($message, true);
        if(!$message_data)
        {
            return ;
        }
        switch($message_data['type'])
        {

            case 'pong':
                return;
            case 'login':
                $_SESSION['uid'] = $message_data['uid'];

                if(Gateway::isUidOnline($message_data['uid'])){
                    $clients = Gateway::getClientIdByUid($message_data['uid']);
                    $callback['type'] = 'kickout';
                    $callback['uid'] = $message_data['uid'];
                    foreach ($clients as $val){
                        Gateway::sendToClient($val, json_encode($callback));
                    }
                }

                Gateway::bindUid($client_id, $message_data['uid']);
                $msg['status'] = "login success";

                if($message_data['groupIds']){
                    foreach ($message_data['groupIds'] as $v){
                        Gateway::joinGroup($client_id, $v);
                    }
                }
                Gateway::sendToCurrentClient(json_encode($msg));
                return;
            case 'joinGroup':
                $to_client_id = Gateway::getClientIdByUid($message_data['uid']);
                if(!empty($to_client_id[0])){
                    Gateway::joinGroup($to_client_id[0], $message_data['groupId']);
                }
                return;
            case 'outGroup':
                $to_client_id = Gateway::getClientIdByUid($message_data['uid']);
                if(!empty($to_client_id[0])){
                    Gateway::leaveGroup($to_client_id[0],  $message_data['groupId']);
                }
                return;
            case 'say': case 'addfriend':

                $uid = $_SESSION['uid'];
                $to_client_id = Gateway::getClientIdByUid($message_data['to_uid']);
                if($message_data['chat_type'] == "user"){
                    $callback['type'] = 'sendCallback';
                    $callback['chat_type'] = 'user';
                    $callback['messageId'] = $message_data['_id'];
                    if(!empty($to_client_id[0])){
                        $to_client_id = $to_client_id[0];
                        Gateway::sendToClient($to_client_id, json_encode($message_data));
                        $callback['sendStatus'] = 'success';
                    }else{
                        $callback['sendStatus'] = 'pending';
                    }
                    return Gateway::sendToCurrentClient(json_encode($callback));
                }else{

                    Gateway::sendToGroup($message_data['to_uid'], json_encode($message_data));
                    $callback['onlineUserId'] = [];
                    if(!empty($message_data['group']['users'])){
                        foreach ($message_data['group']['users'] as $v){
                            $online_client_id = Gateway::getClientIdByUid($v['_id']);
                            if(!empty($online_client_id[0])){
                                array_push($callback['onlineUserId'],$v['_id']);
                            }
                        }
                    }
                    $callback['type'] = 'sendCallback';
                    $callback['chat_type'] = 'group';
                    $callback['messageId'] = $message_data['_id'];
                    $callback['sendStatus'] = 'success';
                    return Gateway::sendToCurrentClient(json_encode($callback));
                }
            case 'getHistory':
                $uid = $_SESSION['uid'];
        }
   }
   /**
    * 当客户端断开连接时
    * @param integer $client_id 客户端id
    */
   public static function onClose($client_id)
   {
       // debug
//       echo "client:{$_SERVER['REMOTE_ADDR']}:{$_SERVER['REMOTE_PORT']} gateway:{$_SERVER['GATEWAY_ADDR']}:{$_SERVER['GATEWAY_PORT']}  client_id:$client_id onClose:''\n";
//
   }
  
}
