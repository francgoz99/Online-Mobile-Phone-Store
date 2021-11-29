<?php
$con=mysqli_fetch_array("Localhost", "root", "mobilephonestoredb");
if (mysqli_connect_errno()){
    echo "Connection Fail".mysqli_connect_error();
}
?>
