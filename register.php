
<?php

        require ("info.php");
        if(!empty($_POST)){
                if (empty($_POST['clave'])) {
                        $response["success"] = 0;
                        $response["message"] = "Favor de ingresar una clave o código de barras.";
                        die(json_encode($response));
                }
                $query = " SELECT * FROM articulo where clave= :clave";
                $query_params = array(':clave' => $_POST['clave']);

                try{

                        $stmt   = $db->prepare($query);
                        $result = $stmt->execute($query_params);
                }
                catch(PDOException $ex) {
                        $response["success"] = 0;
                        $response["message"] = "Database Error1. Please Try Again!";
                        die(json_encode($response));
                }

		$row = $stmt->fetch();
                if ($row) {
                        $response["success"] = 0;
                        $response["message"] = "Lo sentimos,la clave no esta en catálogo";
                        die(json_encode($response));
                }
        }else{
?>

<h1>Inventarios</h1>
<form action="register.php" method="post">
        Búsqueda: <br />
        <input type="text" name="clave" placeholder="clave o código"><br />
        <input type="submit" value="Búsqueda de producto" />

</form>
<?php

}
?>
<?php

$con = $con = mysql_connect("localhost:3306","PDA","123456");

if (!$con)
{
die('Could not connect ' . mysql_error());
}
mysql_select_db("iris",$con);

$result = mysql_query("select clave from articulo limit 1");

while($row = mysql_fetch_assoc($result))
{
$output[]=$row;
}

print(json_encode($output));

mysql_close($con);

?>

