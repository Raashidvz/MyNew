<?php
    session_start();
    $dbcon=mysqli_connect("localhost","root","","AMS");
    $tab=$_GET['tab'];
    //if($_SERVER["REQUEST_METHOD"] == "GET"){

        $sub_id=$_GET['id'];
        $sql="SELECT * FROM subjects WHERE SUBJECT_ID='$sub_id'";
        $data=mysqli_query($dbcon,$sql);
        if($data){
            $subject=mysqli_fetch_array($data);
        }
    
    //}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User Details</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 500px;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"], input[type="email"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
            outline: none;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus, input[type="email"]:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
        }

        button {
            padding: 12px;
            background-color: #0d7aa7;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0a6b91;
        }

        .form-group {
            margin-bottom: 15px;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        .form-message {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #28a745;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Update User Details</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="subject_name"><?php ?></label>
                <input type="text" id="subject_name" name="subject_name" placeholder="<?php echo $subject['SUBJECT_NAME']; ?>" value="" readonly='readonly'>
                <input type="text"name="subject_name" value="<?php echo $subject['SUBJECT_NAME']; ?>" hidden>
                <input type="text"name="subject_id" value="<?php echo $sub_id; ?>" hidden>

            </div>

            <div class="form-group">
                <label for="class"></label>
                <input type="text" id="class" name="class" placeholder=" Department - <?php echo $subject['CLASS_NAME']; ?>" readonly='readonly'>
                <input type="text" name="class" value="<?php echo $subject['CLASS_NAME']; ?>" hidden>
            </div>

            <div class="form-group">
                <label for="sem"></label>
                <input type="text" id="sem" name="sem"  placeholder="Semester - <?php echo $subject['SEMESTER']; ?>" readonly='readonly'>
            </div>

            <div class="form-group">
                <label for="modules"></label>
                <input type="text" id="modules" name="modules" placeholder="Total Modules - <?php echo $subject['TOTAL_MODULES']; ?>" readonly='readonly'>
            </div>

            <div class="form-group">
                <label for="teacher1">Teacher-1</label>
                <select id="teacher1" name="teacher1">
                    <?php
                        if($subject['TEACHER_ID']!=null){
                            $sql="SELECT * FROM teachers WHERE TEACHER_ID='$subject[TEACHER_ID]'";
                            $teacher=mysqli_query($dbcon,$sql);
                            $teacher1=mysqli_fetch_array($teacher);
                            echo "<option value='none'>".$teacher1['NAMEE']."</option>";
                        }else{
                            echo "<option value='none'>Select teacher</option>";
                        }
                        $sql="SELECT * FROM users WHERE ROLEE='TEACHERS' AND STATUSS='ACTIVE'";
                        $userTable=mysqli_query($dbcon,$sql);
                        if($userTable){
                            $count=mysqli_num_rows($userTable);
                            for($i=0;$i<$count;$i++){
                                $row=mysqli_fetch_array($userTable);
                                $sql="SELECT * FROM teachers WHERE USER_ID='$row[USER_ID]'";
                                $teacher=mysqli_query($dbcon,$sql);
                                $teacher_row=mysqli_fetch_array($teacher);
                                if($teacher_row['TEACHER_ID']==$subject['TEACHER_ID']){
                                    continue;
                                }
                                echo "<option value='$teacher_row[TEACHER_ID]'>".$teacher_row['NAMEE']."</option>";
                            }
                        }
                    ?>
                    
                    <!-- <option value="reset">Reset</option> -->
                </select>
            </div>

            <div class="form-group">
                <label for="teacher2">Teacher-2</label>
                <select id="teacher2" name="teacher2">
                    <?php
                        if($subject['TEACHER_ID2']!=null){
                            $sql="SELECT * FROM teachers WHERE TEACHER_ID='$subject[TEACHER_ID2]'";
                            $teacher=mysqli_query($dbcon,$sql);
                            $teacher2=mysqli_fetch_array($teacher);
                            echo "<option value='none'>".$teacher2['NAMEE']."</option>";
                        }else{
                            echo "<option value='none'>Select teacher</option>";
                        }
                        $sql="SELECT * FROM users WHERE ROLEE='TEACHERS' AND STATUSS='ACTIVE'";
                        $userTable=mysqli_query($dbcon,$sql);
                        if($userTable){
                            $count=mysqli_num_rows($userTable);
                            for($i=0;$i<$count;$i++){
                                $row=mysqli_fetch_array($userTable);
                                $sql="SELECT * FROM teachers WHERE USER_ID='$row[USER_ID]'";
                                $teacher=mysqli_query($dbcon,$sql);
                                $teacher_row=mysqli_fetch_array($teacher);
                                if($teacher_row['TEACHER_ID']==$subject['TEACHER_ID2']){
                                    continue;
                                }
                                echo "<option value='$teacher_row[TEACHER_ID]'>".$teacher_row['NAMEE']."</option>";
                            }
                        }
                    ?>
                    
                    <!-- <option value="reset">Reset</option> -->
                </select>
            </div>

            <button type="submit" name="update">Update</button>
        </form>
        <?php
            if(isset($_POST['update'])){
                $subject_name=$_POST['subject_name'];
                $subject_id=$_POST['subject_id'];
                $class=$_POST['class'];
        
                $t1=$_POST['teacher1'];
                $t2=$_POST['teacher2'];

                $yr=date('Y');
                $month=date('m');
                if($month<4){
                    $yr=$yr-1;
                }

                if($subject['SEMESTER']==1 || $subject['SEMESTER']==2){
                    $yr=$yr;
                }else if($subject['SEMESTER']==3 || $subject['SEMESTER']==4){
                    $yr=$yr-1;
                }else if($subject['SEMESTER']==5 || $subject['SEMESTER']==6){
                    $yr=$yr-2;
                }else {
                    $yr=$yr-3;
                }
                
                
                if($t1=='none' && $t2=='none'){
                    // echo "<script>alert('No changes updated!'); window.location.href='adminDashboard.php?tab=". $tab."'</script>";
                }else if($t1!='none' && $t2=='none'){
                    //subject table update query
                    $sql="UPDATE subjects SET TEACHER_ID='$t1' WHERE SUBJECT_ID='$subject_id'";

                    //routemap setup
                    $sqlx="SELECT * FROM routemap WHERE SUBJECT_NAME='$subject_name' AND CLASS='$class' AND YEARR='$yr' AND TEACHER_ID='$t1'";
                    $routeCheck=mysqli_query($dbcon,$sqlx);
                    if($routeCheck){
                        $checkRow=mysqli_fetch_array($routeCheck);
                        if($checkRow['YEARR']!=$yr){
                            $sqlx="INSERT INTO routemap(TEACHER_ID, SUBJECT_NAME, CLASS, YEARR) VALUES ('$t1','$subject_name','$class','$yr')";
                            $routemap=mysqli_query($dbcon,$sqlx);
                        }
                    }
                }else if($t1=='none' && $t2!='none'){
                    //subject table update query
                    $sql="UPDATE subjects SET TEACHER_ID2='$t2' WHERE SUBJECT_ID='$subject_id'";

                    //routemap setup
                    $sqlx="SELECT * FROM routemap WHERE SUBJECT_NAME='$subject_name' AND CLASS='$class' AND YEARR='$yr' AND TEACHER_ID='$t2'";
                    $routeCheck=mysqli_query($dbcon,$sqlx);
                    if($routeCheck){
                        $checkRow=mysqli_fetch_array($routeCheck);
                        if($checkRow['YEARR']!=$yr){
                            $sqlx="INSERT INTO routemap(TEACHER_ID, SUBJECT_NAME, CLASS, YEARR) VALUES ('$t2','$subject_name','$class','$yr')";
                            $routemap=mysqli_query($dbcon,$sqlx);
                        }
                    }
                }else{
                    //subject table update query
                    $sql="UPDATE subjects SET TEACHER_ID='$t1',TEACHER_ID2='$t2' WHERE SUBJECT_ID='$subject_id'";

                    //routemap setup
                    $sql1="SELECT * FROM routemap WHERE SUBJECT_NAME='$subject_name' AND CLASS='$class' AND YEARR='$yr' AND TEACHER_ID='$t1'";
                    $sql2="SELECT * FROM routemap WHERE SUBJECT_NAME='$subject_name' AND CLASS='$class' AND YEARR='$yr' AND TEACHER_ID='$t2'";
                    $routeCheck1=mysqli_query($dbcon,$sql1);
                    $routeCheck2=mysqli_query($dbcon,$sql2);
                    if($routeCheck1 && $routeCheck2){
                        $checkRow1=mysqli_fetch_array($routeCheck1);
                        $checkRow2=mysqli_fetch_array($routeCheck2);
                        if($checkRow1['YEARR']!=$yr){
                            $sqlx="INSERT INTO routemap(TEACHER_ID, SUBJECT_NAME, CLASS, YEARR) VALUES ('$t1','$subject_name','$class','$yr')";
                            $routemap1=mysqli_query($dbcon,$sqlx);
                        }
                        if($checkRow2['YEARR']!=$yr){
                            $sqlx="INSERT INTO routemap(TEACHER_ID, SUBJECT_NAME, CLASS, YEARR) VALUES ('$t2','$subject_name','$class','$yr')";
                            $routemap2=mysqli_query($dbcon,$sqlx);
                        }
                    }
                }
                
                $data=mysqli_query($dbcon,$sql);
                if($data){

                    echo "<script>alert('Subject data updated successfully!'); window.location.href='adminDashboard.php?tab=". $tab."'</script>";
                }

            }
        ?>
    </div>

</body>
</html>
