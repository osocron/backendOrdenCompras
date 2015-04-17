<?php
        $username = $_POST['usuario']; 
        $password = $_POST['password'];
        $host = "localhost:3306";
        $dbname = "iris";

	try
        {
                $con = mysql_connect($host,$username,$password); 
		echo "Conectado";
        }
        catch(Exception $ex)
        {
                $response["success"] = 0;
	        $response["message"] = "Usuario o contrasena no valida!";
        	die(json_encode($response));

        }

        session_start();

?>
<form action="MysqlInventarios.php" method="post">
Usuario: <input type="text" name="usuario"><br>
Contrasena: <input type="password" name="password"><br>
<input type="Submit">
</form>

