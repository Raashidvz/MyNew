<?php
    session_start();
    $dbcon=mysqli_connect("localhost","root","","AMS");
    if($_SERVER['REQUEST_METHOD']=='GET'){
        //error_reporting(0);
        
        $_SESSION["NOTE_ID"]=$_GET['id'];
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
        
        td a{
            color:#0d7aa7;
            text-decoration:none;
        }
        td a:hover{
            color:blue;
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
        }

        .back-button:hover {
            background-color: #0a6b91;
        }

        .back-button-container {
            text-align: left;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="back-button-container">
            <form action="" method="post">
            <button type="submit" name="back" class="back-button" >Back</button>
            </form>
        </div>
        
        <h1>Assignments submitted</h1>
        <table>
            <thead>
                <tr>
                    <th>SI NO</th>
                    <th>Roll NO</th>
                    <th>Full Name</th>
                    <th>File</th>
                </tr>
            </thead>
            <tbody>
                <?php
                        
                        $sql="SELECT * FROM `assign_works` WHERE NOTE_ID='$_SESSION[NOTE_ID]'";
                        $data=mysqli_query($dbcon,$sql);
                        if($data){
                        
                                $work_count=mysqli_num_rows($data);
                                for($i=0;$i<$work_count;$i++){
                                    
                                    $work_row=mysqli_fetch_array($data);
                                    $rollno=$work_row['ROLLNO'];
                                    $name=$work_row['NAMEE'];
                                    $file_path=$work_row['FILE_PATH'];
                                    
                                             echo"  <tr>
                                                        <td>".($i+1)."</td>
                                                        <td>".$rollno."</td>
                                                        <td>".$name."</td>
                                                        <td><a href='$file_path' target='_blank'>View file</a></td>
                                                    </tr>";
                                                
                                        
                                    
                                }
                            
                        }
                    



                    
                ?>
                <!-- Add more student rows as needed -->
            </tbody>
        </table>
    </div>
    <?php
        if(isset($_POST['back'])){
            header('Location: moduleList.php?id=' . $_SESSION['SUBJECT_ID'] . '&subject=' . $_SESSION['SUBJECT_NAME'] . '&tag=' . $_SESSION['TAG'] . '&tab=AssignGrades');
        }
    ?>

</body>
</html>
