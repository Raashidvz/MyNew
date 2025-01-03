<?php
    if($_SERVER['REQUEST_METHOD']=='GET'){
        $id=$_GET['id'];
        $access=$_GET['access'];
        $semester=$_GET['semester'];
        $tab=$_GET['tab'];
        $dbcon=mysqli_connect("localhost","root","","AMS");
        if($access==1){

            //echo "Give access<br>";
            $sql="UPDATE batches SET $semester='1' WHERE BATCH_ID='$id'";
            $data=mysqli_query($dbcon,$sql);
            if($data){
                echo "UPDATED SUCCESSFULLY";
            }


        }else{

            //echo "Deny access";
            $sql="UPDATE batches SET $semester='0' WHERE BATCH_ID='$id'";
            $data=mysqli_query($dbcon,$sql);
            if($data){
                echo "UPDATED SUCCESSFULLY";
            }



        }
    }
    header("Location: adminDashboard.php?tab=" . $tab);
    exit;
?>