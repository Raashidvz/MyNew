<?php
    if($_SERVER['REQUEST_METHOD']=='GET'){
        $id=$_GET['id'];
        $role=$_GET['rolee'];
        $tab=$_GET['tab'];
        $dbcon=mysqli_connect("localhost","root","","AMS");

        if($role=='teacher'){

            //first we have to get teacher id
            //echo $id;

            $sql="SELECT * FROM teachers WHERE USER_ID='$id'";
            $data=mysqli_query($dbcon,$sql);
            if($data){
                $row=mysqli_fetch_array($data);//here we have that teacher details
                //echo $row[0];
                $sql="SELECT * FROM subjects WHERE TEACHER_ID='$row[0]'OR TEACHER_ID2='$row[0]'";
                $data2=mysqli_query($dbcon,$sql);
                if($data2){
                    $count=mysqli_num_rows($data2);
                    for($i=0;$i<$count;$i++){
                        $sub=mysqli_fetch_array($data2);
                        // echo $sub[0];
                        if($sub['TEACHER_ID']==$row[0]){
                            $sql="UPDATE subjects SET TEACHER_ID=null WHERE SUBJECT_ID='$sub[0]'";
                            $data3=mysqli_query($dbcon,$sql);
                        }else if($sub['TEACHER_ID2']==$row[0]){
                            $sql="UPDATE subjects SET TEACHER_ID2=null WHERE SUBJECT_ID='$sub[0]'";
                            $data3=mysqli_query($dbcon,$sql);
                        }
                    }
                }
                //so we successfully deleted teacher from subject table
            }
      
            $sql="UPDATE users SET STATUSS='INACTIVE' WHERE USER_ID='$id'";
            $result=mysqli_query($dbcon,$sql);
            header("Location: adminDashboard.php?tab=" . $tab);
            echo "<script>alert('Teacher deleted successfully!'); window.location.href='adminDashboard.php?tab=" . $tab."'</script>";




        }else if($role=='student'){
            $sql="SELECT * FROM students WHERE USER_ID='$id'";
            $student=mysqli_query($dbcon,$sql);
            if($student){
                $student_row=mysqli_fetch_array($student);
                $sql="UPDATE users SET STATUSS='INACTIVE' WHERE USER_ID='$id'";
                $result=mysqli_query($dbcon,$sql);
                if($result){
                    echo "<script>alert('Student deleted successfully!'); window.location.href='viewStudents.php?id=". $student_row['BATCH_ID']."'</script>";
                }
            }
            // header("Location: adminDashboard.php?tab=" . $tab);






        }else if($role=='subject1'){
            $sql="UPDATE subjects SET TEACHER_ID=NULL WHERE SUBJECT_ID='$id'";
            $result=mysqli_query($dbcon,$sql);
            if($result){
           
            }
            header("Location: adminDashboard.php?tab=" . $tab);



        }else if($role=='subject2'){
            $sql="UPDATE subjects SET TEACHER_ID2=NULL WHERE SUBJECT_ID='$id'";
            $result=mysqli_query($dbcon,$sql);
            if($result){
           
            }
            header("Location: adminDashboard.php?tab=" . $tab);



        }else if($role=='batch'){
            $sql="SELECT * FROM students WHERE BATCH_ID='$id'";
            $students=mysqli_query($dbcon,$sql);
            if($students){
                $rowcount=mysqli_num_rows($students);
                for($i=0;$i<$rowcount;$i++){
                    $row=mysqli_fetch_array($students);
                    $sql="DELETE FROM students WHERE STUDENT_ID='$row[STUDENT_ID]'";
                    $del=mysqli_query($dbcon,$sql);
                    if($del){
                        $sql="DELETE FROM USERS WHERE USER_ID='$row[USER_ID]'";
                        $del=mysqli_query($dbcon,$sql);
                    }
                }
                $sql="DELETE FROM batches WHERE BATCH_ID='$id'";
                $del=mysqli_query($dbcon,$sql);
                if($del){
                    echo "<script>alert('Batch Deleted successfully')</script>";
                }
           
            }
            header("Location: adminDashboard.php?tab=" . $tab);
        }
    }
    //header("location:adminDashboard.php?section=manage-teachers");
    exit;
?>