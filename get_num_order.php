<?php

$con = mysql_connect("localhost:3306","PDA","123456");

if (!$con)
{//1
die('Could not connect ' . mysql_error());
}//1
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

print("[");

$codigo = $_POST['codigo'];
$mquery = "SELECT numero FROM rpedido_mobile order by numero desc limit 1";
$result = mysql_query($mquery);

$num = intval(mysql_result($result,$i,"numero"))+1;
$numero = str_pad($num , 6,' ', STR_PAD_LEFT);
$Json_Array = array("numero" => $numero);

print(json_encode($Json_Array));

print("]");

}//3
catch(Exception $ex){//19
                $response["success"] = 0;
                $response["message"] = "Error al recuperar numero de orden";
                die(json_encode($response));
}//19

mysql_close($con);

}//1
else{//23

?>

<form action="get_num_order.php" method="post">
Codigo: <input type="text" name="codigo"><br>
<input type="Submit">
</form>
<?php

}//23
?>



