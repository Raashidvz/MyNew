<?php
    session_start();
    $dbcon=mysqli_connect("localhost","root","","AMS");
    $tab=$_GET['tab'];
    //if($_SERVER["REQUEST_METHOD"] == "GET"){

        $user_id=$_GET['id'];
        $sql="SELECT * FROM users WHERE USER_ID='$user_id'";
        $data=mysqli_query($dbcon,$sql);
        if($data){
            $user=mysqli_fetch_array($data);
            
            $sql="SELECT * FROM teachers WHERE USER_ID='$user_id'";
            $data2=mysqli_query($dbcon,$sql);
            if($data2){
                $teacher=mysqli_fetch_array($data2);
            }
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
                <label for="username"><?php ?></label>
                <input type="text" id="username" name="username" placeholder="<?php echo $user['USER_NAME']; ?>" value="" readonly='readonly'>
                <input type="text"name="user_name" value="<?php echo $user['USER_NAME']; ?>" hidden>
                <input type="text"name="user_id" value="<?php echo $user_id; ?>" hidden>

            </div>

            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="<?php echo $teacher['NAMEE']; ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email"  value="<?php echo $user['EMAIL']; ?>" required>
            </div>

            <div class="form-group">
                <label for="department">Department</label>
                <input type="text" id="department" name="department" value="<?php echo $teacher['DEPARTMENT']; ?>" required>
            </div>

            <div class="form-group">
                <label for="jdate">Joining Date</label>
                <input type="text" id="jdate" name="jdate" value="<?php echo $teacher['JOINING_DATE']; ?>" required>
            </div>
            <div class="form-group">
                <label for="ph">Phone No.</label>
                <input type="text" id="ph" name="ph" value="<?php echo $teacher['PHONE_NO']; ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Reset Password</label>
                <select id="password" name="password">
                    <option value="none">None</option>
                    <option value="reset">Reset</option>
                </select>
            </div>

            <button type="submit" name="update">Update</button>
        </form>
        <?php
            if(isset($_POST['update'])){
                $user_name=$_POST['user_name'];
                $user_id=$_POST['user_id'];
                $name=$_POST['name'];
                $email=$_POST['email'];
                $department=$_POST['department'];
                $jdate=$_POST['jdate'];
                $ph=$_POST['ph'];
                $pswd=$_POST['password'];

                $name=strtoupper($name);
                $department=strtoupper($department);
                

                if($pswd=='reset'){
                    $sql="UPDATE users SET PASSWORDD='$user_name',EMAIL='$email' WHERE USER_ID='$user_id'";
                }else{
                    $sql="UPDATE users SET EMAIL='$email' WHERE USER_ID='$user_id'";
                }

                $sql2="UPDATE teachers SET NAMEE='$name',DEPARTMENT='$department',JOINING_DATE='$jdate' ,PHONE_NO='$ph' WHERE USER_ID='$user_id'";

                $data1=mysqli_query($dbcon,$sql);
                if($data1){
                    $data2=mysqli_query($dbcon,$sql2);
                    if($data2){
                        echo "<script>alert('Teacher updated successfully!'); window.location.href='adminDashboard.php?tab=". $tab."'</script>";
                    }
                }

            }
        ?>
    </div>

</body>
</html>
