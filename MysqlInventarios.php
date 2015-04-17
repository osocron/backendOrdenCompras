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
die(json_encode($response));
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
die(json_encode($response));
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
if($mclaveRapida == null){
$mclaveRapida = "--";
}
$Descripcion1 = mysql_result($result,$i,"descrgruma");
$Descripcion2 = mysql_result($result,$i,"descripcio");
$Json_Array = array("gravado" => $mgrabado,"clave" => $mclave, "claverapid" => $mclaveRapida, "barras1" => $mbarras1, "barras2" => $mbarras2, "barras3" => $mbarras3, "descrgruma" =>$Descripcion1,"descripcio" => $Descripcion2);
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
if(empty($mclaveRapida)){
$mclaveRapida = "--";
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
$Json_Array = array("gravado" => $mgrabado,"clave" => $mclave,"subclave" => $msubclave,"claverapid" => $claverapida, "barras1" => $mbarras1, "barras2" => $mbarras2, "barras3" => $mbarras3, "descrgruma" => $Descripcion1,"descripcio" => $Descripcion2,"descripciodeta" => $mdescripciondeta);
print(json_encode($Json_Array));
print(",");
}//18

$query =  "SELECT * FROM {$mprecios} where empresa={$mempresa} and clave={$mclave} and subclave='  '";
$result = mysql_query($query);

$precantivamen = mysql_result($result,$i,"precio1");
$precantivamay = mysql_result($result,$i,"precio2");

$precantivamen = floatval($precantivamen);
$precantivamay = floatval($precantivamay);
$mgrabado = floatval($mgrabado);

$menudeo = strval(round($precantivamen * (1 + ($mgrabado / 100)),2));
$mayoreo = strval(round($precantivamay * (1 + ($mgrabado / 100)),2));
$Json_Array = array("menudeo" => $menudeo,"mayoreo" => $mayoreo);
print(json_encode($Json_Array));
print(",");

$query =  "SELECT * FROM existenc where empresa={$mempresa} and clave={$mclave} and subclave={$msubclave}";
$result = mysql_query($query);
$existencias = strval(round(floatval(mysql_result($result,$i,"existenact")),2));
$Json_Array = array("existenact" => $existencias);
print(json_encode($Json_Array));
//print(",");

$query =  "SELECT * FROM historic where empresa={$mempresa} and clave={$mclave} and subclave={$msubclave}";
$result = mysql_query($query);
$month = date(m);

$menero = mysql_result($result,$i,"eneroventa");
$menero = floatval($menero);

switch($month)
{//19
case 01:
$mminimo = strval(round(floatval(mysql_result($result,$i,"enerominim")),3));
$mmaximo = strval(round(floatval(mysql_result($result,$i,"eneromaxim")),3));
$mventas = strval(round(floatval(mysql_result($result,$i,"eneroventa")),3));
$Json_Array = array("mminimo" => $mminimo,"mmaximo" => $mmaximo,"mventas" => $mventas);
print(json_encode($Json_Array));
print(",");
break;
case 02:
$mminimo = strval(round(floatval(mysql_result($result,$i,"febreminim")),3));
$mmaximo = strval(round(floatval(mysql_result($result,$i,"febremaxim")),3));
$mventas = strval(round(floatval(mysql_result($result,$i,"febreventa")),3));
$Json_Array = array("mminimo" => $mminimo,"mmaximo" => $mmaximo,"mventas" => $mventas);
print(json_encode($Json_Array));
print(",");
break;
case 03:
$mminimo = strval(round(floatval(mysql_result($result,$i,"marzominim")),3));
$mmaximo = strval(round(floatval(mysql_result($result,$i,"marzomaxim")),3));
$mventas = strval(round(floatval(mysql_result($result,$i,"marzoventa")),3));
$Json_Array = array("mminimo" => $mminimo,"mmaximo" => $mmaximo,"mventas" => $mventas);
print(json_encode($Json_Array));
print(",");
break;
case 04:
$mminimo = strval(round(floatval(mysql_result($result,$i,"abrilminim")),3));
$mmaximo = strval(round(floatval(mysql_result($result,$i,"abrilmaxim")),3));
$mventas = strval(round(floatval(mysql_result($result,$i,"abrilventa")),3));
$Json_Array = array("mminimo" => $mminimo,"mmaximo" => $mmaximo,"mventas" => $mventas);
print(json_encode($Json_Array));
print(",");
break;
case 05:
$mminimo = strval(round(floatval(mysql_result($result,$i,"mayominim")),3));
$mmaximo = strval(round(floatval(mysql_result($result,$i,"mayomaxim")),3));
$mventas = strval(round(floatval(mysql_result($result,$i,"mayoventa")),3));
$Json_Array = array("mminimo" => $mminimo,"mmaximo" => $mmaximo,"mventas" => $mventas);
print(json_encode($Json_Array));
print(",");
break;
case 06:
$mminimo = strval(round(floatval(mysql_result($result,$i,"juniominim")),3));
$mmaximo = strval(round(floatval(mysql_result($result,$i,"juniomaxim")),3));
$mventas = strval(round(floatval(mysql_result($result,$i,"junioventa")),3));
$Json_Array = array("mminimo" => $mminimo,"mmaximo" => $mmaximo,"mventas" => $mventas);
print(json_encode($Json_Array));
print(",");
break;
case 07:
$mminimo = strval(round(floatval(mysql_result($result,$i,"juliominim")),3));
$mmaximo = strval(round(floatval(mysql_result($result,$i,"juliomaxim")),3));
$mventas = strval(round(floatval(mysql_result($result,$i,"julioventa")),3));
$Json_Array = array("mminimo" => $mminimo,"mmaximo" => $mmaximo,"mventas" => $mventas);
print(json_encode($Json_Array));
print(",");
break;
case 08:
$mminimo = strval(round(floatval(mysql_result($result,$i,"agostminim")),3));
$mmaximo = strval(round(floatval(mysql_result($result,$i,"agostmaxim")),3));
$mventas = strval(round(floatval(mysql_result($result,$i,"agostventa")),3));
$Json_Array = array("mminimo" => $mminimo,"mmaximo" => $mmaximo,"mventas" => $mventas);
print(json_encode($Json_Array));
print(",");
break;
case 09:
$mminimo = strval(round(floatval(mysql_result($result,$i,"septiminim")),3));
$mmaximo = strval(round(floatval(mysql_result($result,$i,"septimaxim")),3));
$mventas = strval(round(floatval(mysql_result($result,$i,"septiventa")),3));
$Json_Array = array("mminimo" => $mminimo,"mmaximo" => $mmaximo,"mventas" => $mventas);
print(json_encode($Json_Array));
print(",");
break;
case 10:
$mminimo = strval(round(floatval(mysql_result($result,$i,"octubminim")),3));
$mmaximo = strval(round(floatval(mysql_result($result,$i,"octubmaxim")),3));
$mventas = strval(round(floatval(mysql_result($result,$i,"octubventa")),3));
$Json_Array = array("mminimo" => $mminimo,"mmaximo" => $mmaximo,"mventas" => $mventas);
print(json_encode($Json_Array));
print(",");
break;
case 11:
$mminimo = strval(round(floatval(mysql_result($result,$i,"novieminim")),3));
$mmaximo = strval(round(floatval(mysql_result($result,$i,"noviemaxim")),3));
$mventas = strval(round(floatval(mysql_result($result,$i,"novieventa")),3));
$Json_Array = array("mminimo" => $mminimo,"mmaximo" => $mmaximo,"mventas" => $mventas);
print(json_encode($Json_Array));
print(",");
break;
case 12:
$mminimo = strval(round(floatval(mysql_result($result,$i,"dicieminim")),3));
$mmaximo = strval(round(floatval(mysql_result($result,$i,"diciemaxim")),3));
$mventas = strval(round(floatval(mysql_result($result,$i,"dicieventa")),3));
$Json_Array = array("mminimo" => $mminimo,"mmaximo" => $mmaximo,"mventas" => $mventas);
print(json_encode($Json_Array));
print(",");
break;
default:
break;
}//19

mysql_select_db($dbant,$con);

$query =  "SELECT * FROM historic where empresa={$mempresa} and clave={$mclave} and subclave={$msubclave}";
$result = mysql_query($query);
$mfilas = mysql_numrows($result);

if($mfilas !== 0)
{//20
$month = date(m);
switch($month)
{//21
case 01:
$ventant = "--";
$ventact = strval(round(floatval(mysql_result($result,$i,"eneroventa")),3));
$ventpost = strval(round(floatval(mysql_result($result,$i,"febreventa")),3));
$Json_Array = array("ventant" => $ventant,"ventact" => $ventact, "ventpost" => $ventpost);
print(json_encode($Json_Array));
break;
case 02:
$ventant = strval(round(floatval(mysql_result($result,$i,"eneroventa")),3));
$ventact = strval(round(floatval(mysql_result($result,$i,"febreventa")),3));
$ventpost = strval(round(floatval(mysql_result($result,$i,"marzoventa")),3));
$Json_Array = array("ventant" => $ventant,"ventact" => $ventact, "ventpost" => $ventpost);
print(json_encode($Json_Array));
break;
case 03:
$ventant = strval(round(floatval(mysql_result($result,$i,"febreventa")),3));
$ventact = strval(round(floatval(mysql_result($result,$i,"marzoventa")),3));
$ventpost = strval(round(floatval(mysql_result($result,$i,"abrilventa")),3));
$Json_Array = array("ventant" => $ventant,"ventact" => $ventact, "ventpost" => $ventpost);
print(json_encode($Json_Array));
break;
case 04:
$ventant = strval(round(floatval(mysql_result($result,$i,"marzoventa")),3));
$ventact = strval(round(floatval(mysql_result($result,$i,"abrilventa")),3));
$ventpost = strval(round(floatval(mysql_result($result,$i,"mayoventa")),3));
$Json_Array = array("ventant" => $ventant,"ventact" => $ventact, "ventpost" => $ventpost);
print(json_encode($Json_Array));
break;
case 05:
$ventant = strval(round(floatval(mysql_result($result,$i,"abrilventa")),3));
$ventact = strval(round(floatval(mysql_result($result,$i,"mayoventa")),3));
$ventpost = strval(round(floatval(mysql_result($result,$i,"junioventa")),3));
$Json_Array = array("ventant" => $ventant,"ventact" => $ventact, "ventpost" => $ventpost);
print(json_encode($Json_Array));
break;
case 06:
$ventant = strval(round(floatval(mysql_result($result,$i,"mayoventa")),3));
$ventact = strval(round(floatval(mysql_result($result,$i,"junioventa")),3));
$ventpost = strval(round(floatval(mysql_result($result,$i,"julioventa")),3));
$Json_Array = array("ventant" => $ventant,"ventact" => $ventact, "ventpost" => $ventpost);
print(json_encode($Json_Array));
break;
case 07:
$ventant = strval(round(floatval(mysql_result($result,$i,"junioventa")),3));
$ventact = strval(round(floatval(mysql_result($result,$i,"julioventa")),3));
$ventpost = strval(round(floatval(mysql_result($result,$i,"agostventa")),3));
$Json_Array = array("ventant" => $ventant,"ventact" => $ventact, "ventpost" => $ventpost);
print(json_encode($Json_Array));
break;
case 08:
$ventant = strval(round(floatval(mysql_result($result,$i,"julioventa")),3));
$ventact = strval(round(floatval(mysql_result($result,$i,"agostventa")),3));
$ventpost = strval(round(floatval(mysql_result($result,$i,"septiventa")),3));
$Json_Array = array("ventant" => $ventant,"ventact" => $ventact, "ventpost" => $ventpost);
print(json_encode($Json_Array));
break;
case 09:
$ventant = strval(round(floatval(mysql_result($result,$i,"agostventa")),3));
$ventact = strval(round(floatval(mysql_result($result,$i,"septiventa")),3));
$ventpost = strval(round(floatval(mysql_result($result,$i,"octubventa")),3));
$Json_Array = array("ventant" => $ventant,"ventact" => $ventact, "ventpost" => $ventpost);
print(json_encode($Json_Array));
break;
case 10:
$ventant = strval(round(floatval(mysql_result($result,$i,"septiventa")),3));
$ventact = strval(round(floatval(mysql_result($result,$i,"octubventa")),3));
$ventpost = strval(round(floatval(mysql_result($result,$i,"novieventa")),3));
$Json_Array = array("ventant" => $ventant,"ventact" => $ventact, "ventpost" => $ventpost);
print(json_encode($Json_Array));
break;
case 11:
$ventant = strval(round(floatval(mysql_result($result,$i,"octubventa")),3));
$ventact = strval(round(floatval(mysql_result($result,$i,"novieventa")),3));
$ventpost = strval(round(floatval(mysql_result($result,$i,"dicieventa")),3));
$Json_Array = array("ventant" => $ventant,"ventact" => $ventact, "ventpost" => $ventpost);
print(json_encode($Json_Array));
break;
case 12:
$ventant = strval(round(floatval(mysql_result($result,$i,"novieventa")),3));
$ventact = strval(round(floatval(mysql_result($result,$i,"dicieventa")),3));
$ventpost = strval(round($menero,3));
$Json_Array = array("ventant" => $ventant,"ventact" => $ventact, "ventpost" => $ventpost);
print(json_encode($Json_Array));
break;

default:
break;
}//21

}//20
else
{//22
$Json_Array = array("ventant" => "--","ventact" => "--", "ventpost" => "--");
print(json_encode($Json_Array));
}//22
print(",");
mysql_select_db($dbname,$con);

$datefinal = new DateTime(date("Y-m-d"));
$dateinicial = new DateTime(date("Y-m-d"));

$dateinicial7 = new DateTime(date("Y-m-d"));
date_sub($dateinicial7, date_interval_create_from_date_string('21 days'));
date_sub($dateinicial7, date_interval_create_from_date_string('1 years'));
$dateinicial7 = $dateinicial7->format("Ymd");

$dateinicial14 = new DateTime(date("Y-m-d"));
date_sub($dateinicial14, date_interval_create_from_date_string('14 days'));
date_sub($dateinicial14, date_interval_create_from_date_string('1 years'));
$dateinicial14 = $dateinicial14->format("Ymd");

$dateinicial21 = new DateTime(date("Y-m-d"));
date_sub($dateinicial21, date_interval_create_from_date_string('7 days'));
date_sub($dateinicial21, date_interval_create_from_date_string('1 years'));
$dateinicial21 = $dateinicial21->format("Ymd");

date_sub($dateinicial, date_interval_create_from_date_string('28 days'));
date_sub($dateinicial, date_interval_create_from_date_string('1 years'));
$dateinicial = $dateinicial->format("Ymd");

date_sub($datefinal, date_interval_create_from_date_string('1 days'));
date_sub($datefinal, date_interval_create_from_date_string('1 years'));
$datefinal=$datefinal->format("Ymd");

$msemana1 = 0;
$msemana2 = 0;
$msemana3 = 0;
$msemana4 = 0;

$query =  "SELECT * FROM rtickets where empresa={$mempresa} and clave={$mclave} and subclave={$msubclave} and fecha >='{$dateinicial}' and fecha <='{$datefinal}'";
$result = mysql_query($query);
$resultArray = array();

while( $row = mysql_fetch_array($result)){//23
	array_push($resultArray,$row);
}//23

foreach($resultArray as $current){//24

$fecha = $current['fecha'];
$mfechaventa = new DateTime($fecha);
$mfechaventa=$mfechaventa->format("Ymd");

if($mfechaventa >= $dateinicial)
{//25
if($mfechaventa < $dateinicial7)
{//26
$mcantidad = intval($current['cantidad']);
$msemana1 = $msemana1 + $mcantidad;
}//26
else if ($mfechaventa < $dateinicial14)
{//27
$mcantidad = intval($current['cantidad']);
$msemana2 = $msemana2 + $mcantidad;
}//27
else if ($mfechaventa < $dateinicial21)
{//28
$mcantidad = intval($current['cantidad']);
$msemana3 = $msemana3 + $mcantidad;
}//28
else if ($mfechaventa < $datefinal)
{//29
$mcantidad = intval($current['cantidad']);
$msemana3 = $msemana3 + $mcantidad;
}//29
}//25

}//24

$msemana1 = strval($msemana1);
$msemana2 = strval($msemana2);
$msemana3 = strval($msemana3);
$msemana4 = strval($msemana4);

$Json_Array = array("semana1" => $msemana1,"semana2" => $msemana2, "semana3" => $msemana3, "semana4" => $msemana4);
print(json_encode($Json_Array));
print("]");

/////////////////////////////////////////////////////////////////////////////////
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

<form action="MysqlInventarios.php" method="post">
Codigo: <input type="text" name="codigo"><br>
<input type="Submit">
</form>
<?php

}//23
?>
