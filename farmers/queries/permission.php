<?php
include '../includes/connect.php';
if(isset($_POST['approve'])){
    $q="update oc_farmer set oc_f_status=0 where oc_f_num='".$_POST['phnum']."'";
    mysqli_query($conn,$q);
}

if(isset($_POST['disapprove'])){
    $q="update oc_farmer set oc_f_status=1 where oc_f_num='".$_POST['phnum']."'";
    mysqli_query($conn,$q);
}

?>