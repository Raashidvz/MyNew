<?php
        if(isset($_POST['login'])){
            $dbcon=mysqli_connect("localhost","root","","AMS");
            $username=$_POST['username'];
            $pswd=$_POST['password'];
            
            $sql="SELECT * FROM users WHERE USER_NAME='$username' AND STATUSS='ACTIVE'";
            $data=mysqli_query($dbcon,$sql);
            if($data){
                $user=mysqli_fetch_array($data);
                if($user['USER_NAME']==$username && $user['PASSWORDD']==$pswd){
                    if($user['ROLEE']=='TEACHERS'){
                        //header("location:faculty-dashboard/faculty-dashboard.php?id=".$user['USER_ID']."");
                        // header("location:faculty-dashboard/facultyDashboard.php?id=".$user['USER_ID']."");
                        echo "<script>alert('Login successful!'); window.location.href='faculty-dashboard/facultyDashboard.php?id=".$user['USER_ID']."';</script>";
                        exit();
                    }else if($user['ROLEE']=='STUDENTS'){
                        // header("location:student-dashboard/student-dashboard.php?id=".$user['USER_ID']."");
                        echo "<script>alert('Login successful!'); window.location.href='student-dashboard/student-dashboard.php?id=".$user['USER_ID']."';</script>";
                        exit();
                    }
                    else if($user['ROLEE']=='ADMIN'){
                        // header("location:admin-dashboard/adminDashboard.php");
                        echo "<script>alert('Login successful!'); window.location.href='admin-dashboard/adminDashboard.php?id=".$user['USER_ID']."';</script>";
                        exit();
                    }

                }else{
                    echo "<script>alert('USERNAME OR PASSWORD DOES NOT MATCH!'); window.location.href='home.php';</script>";
                }
            }else{
                echo "<script>alert('FALSE: connection Error'); window.location.href='home.php';</script>";
                // echo "<script>alert('FALSE: connection Error')</script>";
                
            }
        }
    ?>