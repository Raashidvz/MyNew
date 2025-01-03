<?php
    session_start();
    if($_SERVER['REQUEST_METHOD']=='GET'){
        $id=$_GET['id'];

        $tab=$_GET['tab'];
        $dbcon=mysqli_connect("localhost","root","","AMS");

      
            $sql="DELETE FROM notes WHERE NOTE_ID='$id'";
            $result=mysqli_query($dbcon,$sql);
            if($result){
               
                echo "<script>alert('File deleted successfully !'); window.location.href='moduleList.php?id=".$_SESSION["SUBJECT_ID"]."&subject=".$_SESSION["SUBJECT_NAME"]."&tag=".$_SESSION["TAG"]."&tab=" . $tab."'</script>";
                
            }else{
                echo "<script>alert('Error: failed to delete file !'); window.location.href='moduleList.php?tab=" . $tab."'</script>";
            }

    }
    exit;
?>