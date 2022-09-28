<?php

    class Factory{
        public function create_post($type, $message){
            if ($type == "vk"){
                $vk = new Mes_vk();
                $vk->message = $message;
                $vk->send();    
            }
            if ($type =="telegram"){
                $t= new Mes_telegram();
                $t->message = $message;
                $t->send();
            }
        
    }
}

    abstract class Message{
        public $message;
        public function send(){

        } 
    }

    class Mes_vk extends Message{
        
        public function send(){ 

            $access_token = ""; 
            $group_id     = '-';
            $message      = $this->message;
           
            $params = array(
                'v'            => '5.81',
                'access_token' => $access_token,
                'owner_id'     =>  $group_id, 
                'from_group'   => '1',  
                'message'      => $message,
                
            );
            
            $r = file_get_contents('https://api.vk.com/method/wall.post?' . http_build_query($params));
            echo $r;
            echo 'https://api.vk.com/method/wall.post?' . http_build_query($params);
        }
    }

    class Mes_telegram extends Message{
        public function send(){

            define('TELEGRAM_TOKEN', '');
            define('TELEGRAM_CHATID', '');

            $request = curl_init();
                curl_setopt_array(
                    $request,
                    array(
                        CURLOPT_URL => 'https://api.telegram.org/bot' . TELEGRAM_TOKEN . '/sendMessage',
                        CURLOPT_POST => TRUE,
                        CURLOPT_RETURNTRANSFER => TRUE,
                        CURLOPT_TIMEOUT => 10,
                        CURLOPT_POSTFIELDS => array(
                            'chat_id' => TELEGRAM_CHATID,
                            'text' => $this->message,
                        ),
                    )
                );
            curl_exec($request);

            

            
    }
}

    $factory = new Factory();
    $factory->create_post("vk", "vk проверка");

    $factory->create_post("telegram", "telegram проверка");
?>