<?php

$con = mysql_connect("localhost:3306","PDA","123456");

if (!$con)
{
die('Could not connect ' . mysql_error());
}
$dbname = "iris";
$mempresa = "0014";
mysql_select_db($dbname,$con);

if(!empty($_POST)){//1
                if (empty($_POST['codigo'])) {//2
                        $response["success"] = "0";
                        $response["message"] = "Favor de ingresar una clave o codigo";
                        die(json_encode($response));
                }//2


try
{//3

$codigo = $_POST['codigo'];
$query = "SELECT nombre,cliente,numero,serie,fecha,direccion,telefono1,telefono2 FROM dpedido_mobile where nombre LIKE '{$codigo}%' limit 0,5";
$result = mysql_query($query);
$mfilas = mysql_numrows($result);
$Json_array = array();
if($mfilas > 0){//4
while($row=mysql_fetch_array($result, MYSQL_ASSOC))
        {//5
                $Json_Array[]=$row;
        }//5
print(json_encode($Json_Array));
}//4
else{//6
$response["success"] = "0";
$response["message"] = "Cliente no existe en la base de datos!";
die(json_encode($response));
}//6

}//3
catch(Exception $ex){//19
                $response["success"] = 0;
                $response["message"] = "Usuario o contrasena no valida!";
                die(json_encode($response));
}//19
mysql_close($con);


}//1
else{//23

?>
<form action="search_order.php" method="post">
Codigo: <input type="text" name="codigo"><br>
<input type="Submit">
</form>
<?php

}//23
?>

