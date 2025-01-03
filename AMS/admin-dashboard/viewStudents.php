<?php
    session_start();
    if($_SERVER['REQUEST_METHOD']=='GET'){
        error_reporting(0);
        $dbcon=mysqli_connect("localhost","root","","AMS");
        $BATCH_ID=$_GET['id'];
        $sql="SELECT * FROM batches WHERE BATCH_ID='$BATCH_ID'";
        $batch=mysqli_query($dbcon,$sql);
        if($batch){
            $batch_row=mysqli_fetch_array($batch);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .container h1 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #0d7aa7;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #0d7aa7;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* .actions a {
            text-decoration: none;
            color: white;
            background-color: #0d7aa7;
            padding: 8px 12px;
            border-radius: 5px;
            margin-right: 5px;
            display: inline-block;
            transition: background-color 0.3s;
        } */

        /* .actions a:hover {
            background-color: #0a6b91;
        } */

        .back-button {
            background-color: #0d7aa7;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            display: inline-block;
            text-decoration:none;
        }

        .back-button:hover {
            background-color: #0a6b91;
        }

        .back-button-container {
            text-align: left;
            margin-bottom: 20px;
        }
        .update-btn, .delete-btn, .accessAllow-btn, .accessDeny-btn {
            display: inline-block;
            padding: 5px 10px;
            background-color: #0d7aa7; /* Blue for update and access buttons */
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-size: 12px;
            transition: background-color 0.3s ease;
        }

        .update-btn:hover {
            background-color: #0a6b91; /* Darker blue on hover */
        }

        .delete-btn {
            background-color: #f44336; /* Red for delete */
        }

        .delete-btn:hover {
            background-color: #d32f2f; /* Darker red on hover */
        }
        td.action-btn {
            display: flex;
            justify-content: space-around;
        }

    </style>
</head>
<body>

    <div class="container">
        <div class="back-button-container">
            <?php
                echo "<a href='adminDashboard.php?tab=manage-students' class='back-button'>Back</a>";
            ?>
            <!-- <button class="back-button" onclick="history.back()">Back</button> -->
        </div>
        
        <h1>Student List</h1>
        <table>
            <thead>
                <tr>
                    <th>SI NO</th>
                    <th>Roll NO</th>
                    <th>Full Name</th>
                    <th>Batch</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php                
                    $sql="SELECT * FROM students WHERE BATCH_ID='$BATCH_ID' order by NAMEE";
                    $data3=mysqli_query($dbcon,$sql);
                    if($data3){
                        $student_count=mysqli_num_rows($data3);
                        for($j=0,$i=1;$j<$student_count;$j++){
                            
                            $student=mysqli_fetch_array($data3);
                            $key=$student['USER_ID'];
                            $sql="SELECT * FROM users WHERE USER_ID='$student[USER_ID]'";
                            $data4=mysqli_query($dbcon,$sql);
                            $user=mysqli_fetch_array($data4);
                            if($user['STATUSS']=='INACTIVE'){
                                continue;
                            }
                                echo"  <tr>
                                        <td>".$i++."</td>
                                        <td>".$user['USER_NAME']."</td>
                                        <td>".$student['NAMEE']."</td>
                                    
                                        <td>".$batch_row['YEARR']."</td>
                                        <td>".$user['EMAIL']."</td>
                                        <td>".$student['PARENT_CONTACT']."</td>
                                        <td class='action-btn'><a href='update_student.php?id=".$key."&tab=manage-students' class='update-btn'>Update</a>
                                                                <a href='delete.php?id=".$key."&rolee=student&tab=manage-students' class='delete-btn' onclick='return confirmDelete()'>Delete</a>
                                        </td>
                                    </tr>";
                                
                        }
                    }
                    
                ?>
            </tbody>
        </table>
    </div>

</body>
<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this student?");
    }
</script>
</html>
