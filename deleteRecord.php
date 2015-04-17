<?php

$con = mysql_connect("localhost:3306","PDA","123456");

if (!$con)
{//1
die('Could not connect ' . mysql_error());
}//1
$dbname = "iris";
$mempresa = "0014";
mysql_select_db($dbname,$con);

try
{//3
$data = $_POST['json'];
$json = json_decode($data,true);

foreach($json as $item){
$numero = $item['numero'];
$serie = $item['serie'];
}

$mquery1 = "DELETE FROM rpedido_mobile WHERE numero='{$numero}' and serie='{$serie}'";
if (!mysql_query($mquery1)) {//6
  die('Error: ' . mysql_error($con));
}//6


$mquery2 = "DELETE FROM dpedido_mobile WHERE numero='{$numero}' and serie='{$serie}'";
if (!mysql_query($mquery2)) {//6
  die('Error: ' . mysql_error($con));
}//6

print("Pedido borrado con exito!");
}//3
catch(Exception $ex){//19
                $response["success"] = 0;
                $response["message"] = "No se pudo borrar el pedido!";
                die(json_encode($response));
}//19

mysql_close($con);

?>

