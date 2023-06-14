<?php
if(isset($_GET['code'])){

    $code = $_GET['code'];
    $uses = $_GET['uses'];

    $Server = "127.0.0.1";
    $UID = "root";
    $Password = "root";
    $Database = "vouchercodes";

    $Port = "3306";

    $connection = mysqli_connect($Server , $UID , $Password ,  $Database , $Port);
    $tblData = mysqli_query($connection , 'Insert into voucher(Code, uses) values ("' .$code. '",' .$uses. ')') or die(mysqli_error($connection));
    echo 'Success';
}else{
    echo 'Failed';    
}
?>