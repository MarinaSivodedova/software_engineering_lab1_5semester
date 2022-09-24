<?php
   class DataBase
   {
     private $host_name;
     private $db_name;
     private $db_login;
     private $db_password;
     
     public function __construct($host_name, $db_name, $db_login, $db_password)
     {
       $this->host_name = $host_name;
       $this->db_name = $db_name;
       $this->db_login = $db_login;
       $this->db_password = $db_password;
     }
       
     public function connect(){
       $db = new PDO('mysql:host='.$this->host_name.';dbname='.$this->db_name, $this->db_login, $this->db_password);
       session_start();
       return $db;
     }
   }

    class User{
        
        public $login;
        private $password;
      
        public function setLogin($login){
            $this->login = $login;
        }
        public function getLogin(){
            return $this->login;
        }
        public function setPassword($password){
            $this->password = $password;
        }
        public function getPassword(){
            return $this->password;
        }
    
    }

    abstract class Builder{
        protected $user;

        final public function getUser(){
            return $this->user;
        }

        public function buildUser(){
            $this->user = new User();
        }
    }

    class FormBuilder extends Builder{
        public function buildUser(){
            parent::buildUser();
            
            $this->user->setLogin($_POST["login"]);
            $this->user->setPassword($_POST["password"]);
      
    }
}


    class BdBuilder extends Builder{
        public function buildUser(){
            parent::buildUser();

            $sql = "SELECT name, password FROM users";
    
            $data_base = new DataBase('localhost','users_bd', "root", "");
            $db = $data_base->connect();
            
            $chk_login = $db->prepare($sql);
            
            $chk_login->execute();
            $row = $chk_login->fetchAll(PDO::FETCH_ASSOC);
            $control = 0;

            foreach ($row as $i){
                if  ($i["name"] == $_POST["login"] and $i["password"] == $_POST["password"]) {
                    echo $_POST["login"].", вы успешно авторизовались через базу данных";
                    $control = 1;
                }
            }

            if ($control == 0) {
                echo "Пользователь не найден";
            }

            $this->user->setLogin($row["name"]);
            $this->user->setPassword($row["password"]);
        }

    }

 
    $user = new FormBuilder();
    $user->buildUser();
    echo $user->getUser()->{login}.", вы успешно авторизовались через форму";
    echo "<br>";
    $user = new BdBuilder();
    $user->buildUser();
    


?>