<?php

$con = $con = mysql_connect("localhost:3306","PDA","123456");

if (!$con)
{
die('Could not connect ' . mysql_error());
}
mysql_select_db("iris",$con);

$result = mysql_query("select clave from articulo limit 10");

while($row = mysql_fetch_assoc($result))
{
$output[]=$row;
}

print(json_encode($output));

mysql_close($con);

?>
