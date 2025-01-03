<?php
        if(isset($_POST['change-password'])){
            $dbcon=mysqli_connect("localhost","root","","AMS");
            $username=$_POST['username'];
            $old_pswd=$_POST['old-password'];
            $new_pswd=$_POST['new-password'];
            $confirm_pswd=$_POST['confirm-password'];
            
            $sql="SELECT * FROM users WHERE USER_NAME='$username'";
            $data=mysqli_query($dbcon,$sql);
            if($data){
                $user=mysqli_fetch_array($data);
                if($user['USER_NAME']==$username && $user['PASSWORDD']==$old_pswd){
                    
                    if($new_pswd==$confirm_pswd){
                        //changing password
                        $sql="UPDATE users SET PASSWORDD='$new_pswd' WHERE USER_ID='$user[USER_ID]'";
                        $result=mysqli_query($dbcon,$sql);
                        if($result){
                            // echo "<script>alert('Password succesfully changed')</script>";
                            // header("location:login.php");
                            echo "<script>alert('Password changed succesfully'); window.location.href='home.php';</script>";
                        }

                    }else{
                        // echo "<script>alert('New password doesnt match')</script>";
                        echo "<script>alert('New password doesnt match'); window.location.href='home.php';</script>";
                    }


                }else{
                    // echo "<script>alert('USERNAME OR PASSWORD DOES NOT MATCH')</script>";
                    echo "<script>alert('USERNAME OR PASSWORD DOES NOT MATCH'); window.location.href='home.php';</script>";
                }
            }else{
                echo "<script>alert('FALSE: connection Error'); window.location.href='home.php';</script>";
                // echo "FALSE: connection Error";
            }
        }
    ?>