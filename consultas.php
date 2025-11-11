<?php

$cont=mysqli_connect('localhost','chris','Admin123','app_movil');

$sql="select * from usuarios";
$result=mysqli_query($cont,$sql);
$arr = array();
while($datos=mysqli_fetch_array($result))
{
$arr[] = $datos;
}
echo json_encode($arr);
?>
