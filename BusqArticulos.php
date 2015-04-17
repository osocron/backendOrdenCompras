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
$subCodigo="";
$mflag="S";
$simaestro="S";
$mLongitud=strlen($codigo);
print("[");
if ($mLongitud === 10)
{//4
        $subCodigo = substr($codigo,8,2);
        $codigo = substr($codigo,0,8);
}//4


$query =  "SELECT * FROM articulo where barras1={$codigo} or barras2={$codigo} or barras3={$codigo}";
$result = mysql_query($query);
$mfilas = mysql_numrows($result);

if($mfilas == 0)
{//5

$query =  "SELECT * FROM articulo where clave={$codigo}";
$result = mysql_query($query);
$mfilas = mysql_numrows($result);

if($mfilas == 0)
{//6
$query =  "SELECT * FROM articulo where claverapid='{$codigo}'";
$result = mysql_query($query);
$mfilas = mysql_numrows($result);

if($mfilas == 0)
{//7
$simaestro="N";
$query =  "SELECT * FROM detallad where barras1={$codigo} or barras2={$codigo} or barras3={$codigo}";
$result = mysql_query($query);
$mfilas = mysql_numrows($result);

if($mfilas == 0)
{//8
$query =  "SELECT * FROM detallad where claverapid={$codigo}";
$result = mysql_query($query);
$mfilas = mysql_numrows($result);

if($mfilas == 0)
{//9
$response["success"] = "0";
$response["message"] = "Codigo no en catalogo!";
die(json_encode($response));
$mflag="N";
}//9
}//8
}//Aqui el 7
}//Aqui el 6
else
{//10
if(strlen($subCodigo)>0)
{//11
$simaestro="N";
$query =  "SELECT * FROM detallad where clave={$codigo} and subclave={$subCodigo}";
$result = mysql_query($query);
$mfilas = mysql_numrows($result);

if($mfilas == 0)
{//12
$mflag="N";
$response["success"] = "0";
$response["message"] = "Codigo no en catalogo!";
print(json_encode($response));
print("]");
die();
}//12
}//11
else
{//13
$query =  "SELECT * FROM detallad where clave={$codigo}";
$result = mysql_query($query);
$mfilas = mysql_numrows($result);

if($mfilas > 0)
{//14
$mflag="N";
$response["success"] = "0";
$response["message"] = "Este articulo tiene detallados";
print(json_encode($response));
print("]");
die();
}//14
else
{//15
$query =  "SELECT * FROM articulo where clave={$codigo}";
$result = mysql_query($query);
$mfilas = mysql_numrows($result);
}//15
}//13
}//10
}//5

//-----------------------------------------------------------------------
if($mflag == "S")
{//16
if($simaestro == "S")
{//17
$response["success"] = "1";
$response["message"] = "Codigo encontrado en catalogo!";
print(json_encode($response));
print(",");
$mgrabado = mysql_result($result,$i,"gravado");
$mclave = mysql_result($result,$i,"clave");
$mbarras1 = mysql_result($result,$i,"barras1");
if($mbarras1 == ""){
$mbarras1 = "--";
}
$mbarras2 = mysql_result($result,$i,"barras2");
if($mbarras2 == ""){
$mbarras2 = "--";
}
$mbarras3 = mysql_result($result,$i,"barras3");
if($mbarras3 == ""){
$mbarras3 = "--";
}
$mclaveRapida = mysql_result($result,$i,"claverapid");
if(is_null($mclaveRapida)){
$mclaveRapida = "--";
}
$Descripcion1 = mysql_result($result,$i,"descrgruma");
$Descripcion2 = mysql_result($result,$i,"descripcio");
$UnidMedida = mysql_result($result,$i,"umedida");
$Piezas = mysql_result($result,$i,"piezas");
$Json_Array = array("gravado" => $mgrabado,"clave" => $mclave, "claverapid" => $mclaveRapida, "barras1" => $mbarras1, "barras2" => $mbarras2, "barras3" => $mbarras3, "descrgruma" => $Descripcion1, "descripcio" => $Descripcion2, "umedida" => $UnidMedida, "piezas" => $Piezas);
print(json_encode($Json_Array));
print(",");
}//17
else
{//18
$response["success"] = "1";
$response["message"] = "Codigo encontrado en catalogo!";
print(json_encode($response));
print(",");
$mclave = mysql_result($result,$i,"clave");
$msubclave = mysql_result($result,$i,"subclave");
$mclaverapida = mysql_result($result,$i,"claverapid");
if($mclaverapida == ""){
$mclaverapida = "--";
}
$mbarras1 = mysql_result($result,$i,"barras1");
if($mbarras1 == ""){
$mbarras1 = "--";
}
$mbarras2 = mysql_result($result,$i,"barras2");
if($mbarras2 == ""){
$mbarras2 = "--";
}
$mbarras3 = mysql_result($result,$i,"barras3");
if($mbarras3 == ""){
$mbarras3 = "--";
}
$mdescripciondeta = mysql_result($result,$i,"descripcio");
$query =  "SELECT * FROM articulo where clave={$mclave}";
$result = mysql_query($query);
$mgrabado = mysql_result($result,$i,"gravado");
$Descripcion1 = mysql_result($result,$i,"descrgruma");
$Descripcion2 = mysql_result($result,$i,"descripcio");
$UnidMedida = mysql_result($result,$i,"umedida");
$Piezas = mysql_result($result,$i,"piezas");
$Json_Array = array("gravado" => $mgrabado,"clave" => $mclave,"subclave" => $msubclave, "claverapid" => $mclaverapida, "barras1" => $mbarras1, "barras2" => $mbarras2, "barras3" => $mbarras3, "descrgruma" => $Descripcion1, "descripcio" => $Descripcion2, "descripciodeta" => $mdescripciondeta, "umedida" => $UnidMedida, "piezas" => $Piezas);
print(json_encode($Json_Array));
print(",");
}//18

$query = "SELECT * FROM {$mprecios} where empresa={$mempresa} and clave={$mclave} and subclave='  '";
$result = mysql_query($query);

$precantivamen = mysql_result($result,$i,"precio1");
$precantivamay = mysql_result($result,$i,"precio2");
$precantivaesp = mysql_result($result,$i,"precio3");
$cant1 = mysql_result($result,$i,"cantidad1");
$cant2 = mysql_result($result,$i,"cantidad2");
$cant3 = mysql_result($result,$i,"cantidad3");

$precantivamen = floatval($precantivamen);
$precantivamay = floatval($precantivamay);
$precantivaesp = floatval($precantivaesp);
$mgrabado = floatval($mgrabado);

$menudeo = strval(round($precantivamen * (1 + ($mgrabado / 100)),2));
$mayoreo = strval(round($precantivamay * (1 + ($mgrabado / 100)),2));
$especial = strval(round($precantivaesp * (1 + ($mgrabado / 100)),2));
$Json_Array = array("menudeo" => $menudeo,"mayoreo" => $mayoreo, "especial" => $especial, "cantidad1" => $cant1, "cantidad2" => $cant2, "cantidad3" => $cant3,);
print(json_encode($Json_Array));
print(",");

$query =  "SELECT * FROM existenc where empresa={$mempresa} and clave={$mclave} and subclave={$msubclave}";
$result = mysql_query($query);
$existencias = strval(round(floatval(mysql_result($result,$i,"existenact")),2));
$Json_Array = array("existenact" => $existencias);
print(json_encode($Json_Array));
print("]");


//////////////////////////////////////////////////////////////////////////
}//16
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

<form action="BusqArticulos.php" method="post">
Codigo: <input type="text" name="codigo"><br>
<input type="Submit">
</form>
<?php

}//23
?>

