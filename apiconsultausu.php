<?php
$cont=mysqli_connect('localhost','chris','Admin123','app_movil');
$sql="select * from usuarios where email='".$_GET['email']."' and password='".$_GET['password']."'";
$result=mysqli_query($cont,$sql);
$num=mysqli_num_rows($result);
$val=array('estado'=>$num==null?'0':$num);
echo json_encode($val);
?>
