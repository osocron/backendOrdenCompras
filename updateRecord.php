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


$fecha = date("Ymd");
$orden = 1;

foreach($json as $item) { //4 foreach element in $arr

$empresa = $item['empresa'];
$serie = $item['serie'];
$cliente = $item['cliente'];
$vendedor = $item['vendedor'];
$clave = $item['clave'];
$subclave = $item['subclave'];
$uMedida = $item['uMedida'];
$nivel = $item['nivel'];
$precio = $item['precio'];
$precio = floatval($precio);
$cantidad = $item['cantidad'];
$cantidad = floatval($cantidad);
$descuento1 = $item['descuento1'];
$descuento1 = floatval($descuento1);
$importe = $item['importe'];
$importe = floatval($importe);
$nombre = $item['nombre'];
$direccion = $item['direccion'];
$telefono1 = $item['telefono1'];
$telefono2 = $item['telefono2'];

$query = "INSERT INTO rpedido_mobile (empresa,serie,numero,cliente,vendedor,fecha,clave,subclave,umedida,nivel,precio,cantidad,descuento1,importe,orden) VALUES ('{$empresa}','{$serie}','{$numero}','{$cliente}','{$vendedor}','{$fecha}','{$clave}','{$subclave}','{$uMedida}','{$nivel}',{$precio},{$cantidad},{$descuento1},{$importe},{$orden})";
if (!mysql_query($query)) {//5
  die('Error: ' . mysql_error($con));
}//5

$orden = $orden + 1;

}//4

$query2 = "INSERT INTO dpedido_mobile (empresa,serie,numero,cliente,vendedor,fecha,nombre,direccion,telefono1,telefono2) VALUES ('{$empresa}','{$serie}','{$numero}','{$cliente}','{$vendedor}','{$fecha}','{$nombre}','{$direccion}','{$telefono1}','{$telefono2}')";
if (!mysql_query($query2)) {//6
  die('Error: ' . mysql_error($con));
}//6

print("Pedido actualizado con exito!");
}//3
catch(Exception $ex){//19
                $response["success"] = 0;
                $response["message"] = "No se pudo actualizar el pedido!";
                die(json_encode($response));
}//19

mysql_close($con);

?>
