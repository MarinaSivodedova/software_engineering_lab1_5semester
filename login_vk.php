<?php
include 'login.php';

class VkBuilder extends Builder{
        public function buildUser(){
            parent::buildUser();
            
            if (!empty($_GET['code'])) {

                $params = array(
            
                    'client_id'     => '',// можно найти в настройках приложения в вк, после создания 
            
                    'client_secret' => '',// Защищённый ключ
            
                    'redirect_uri'  => 'http://lab1/login_vk.php',
            
                    'code'          => $_GET['code']
            
                );
            
                
            
                // Получение access_token
            
                $data = file_get_contents('https://oauth.vk.com/access_token?' . urldecode(http_build_query($params)));
                // echo $data;
                $data = json_decode($data, true);
            
                if (!empty($data['access_token'])) {
            
                    $email = $data['email'];
                    $params = array(
                        'v'            => '5.81',
                        'uids'         => $data['user_id'],
                        'access_token' => $data['access_token'],
                        'fields'       => 'photo_big',
                    );

                    $info = file_get_contents('https://api.vk.com/method/users.get?' . urldecode(http_build_query($params)));
                    $info = json_decode($info, true);	
                    $this->user->setLogin($info["response"]["0"]["first_name"]);
                    $this->user->setPassword(md5($info["response"]["0"]["first_name"]));
                }
            
            }
        }
    }
    $user = new VkBuilder();
    $user->buildUser();
    echo $user->getUser()->{login}.", вы успешно авторизовались через VK";
    echo "<br>";
?>