<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <form action="login.php" method="POST">
            <p>
                <label for="login">Логин</label>
                <input name="login" type="text">
            </p>
            
            <p>
                <label for="password">Пароль</label>
                <input name="password" type="password">
            </p>           
            

            <input type="submit">
        </form>

        <br>

       
        <?php
            $params = array(
                'client_id'     => '',// можно найти в настройках приложения в вк, после создания 
                'redirect_uri'  => 'http://lab1/login_vk.php',
                'scope'         => 'email',
                'response_type' => 'code',
                'state'         => 'http://lab1'
            );



        $url = 'https://oauth.vk.com/authorize?' . urldecode(http_build_query($params));
        echo $url."<br>";
        echo '<p><a href="' . $url . '">Войти через ВКонтакте</a><p>';

        ?>
      
    </div>
    
</body>
</html>