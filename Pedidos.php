<?php

$con = mysql_connect("localhost:3306","PDA","123456");

if (!$con)
{
die('Could not connect ' . mysql_error());
}
$dbname = "iris";
$anioant = date(Y)-1;
$dbant = $dbname.$anioant;

$mempresa = "0014";
$mprecios = "precios14";
$msubclave = "''";
mysql_select_db($dbname,$con);

if(!empty($_POST)){//1
                if (empty($_POST['producto'])) {//2
                        $response["success"] = "0";
                        $response["message"] = "Favor de ingresar una clave";
                        die(json_encode($response));
                }//2
		else if(empty($_POST['cantidad'])){//4
			$response["success"] = "0";
                        $response["message"] = "Favor de ingresar una cantidad!";
                        die(json_encode($response));
		}//4
//////////////////////////////////////////////////////////////////////////////////////




try
{//3
$mclave = $_POST['producto'];
$cantidad = $_POST['cantidad'];
$subCodigo="";
$mLongitud=strlen($codigo);
print("Pedido realizado ");
$query = "select numero from rvpedido where empresa={$mempresa} order by numero desc limit 1";
$result = mysql_query($query);
$mfilas = mysql_numrows($result);
if($mfilas > 0)
{
   $mnumero = intval(mysql_result($result,$i,"numero")) + 1;
}
else
{
   $mnumero = 1;
}

print($mnumero);
///////////////////////////////////////////////////////////////////////////////////////////////////////
}//3
catch(Exception $ex){//19
                $response["success"] = 0;
                $response["message"] = "Error al hacer el pedido";
                die(json_encode($response));
}//19



mysql_close($con);
}//1

else{//23

?>

<form action="Pedidos.php" method="post">
Producto: <input type="text" name="producto"><br>
Cantidad: <input type="text" name="cantidad"><br>
<input type="Submit">
</form>
<?php

}//23

?>
