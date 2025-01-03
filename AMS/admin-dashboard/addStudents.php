<?php
    error_reporting(0);
    // ini_set('max_execution_time', '600'); // Increase execution time to 600 seconds (10 minutes)
    // ini_set('memory_limit', '1G'); // Increase memory limit to 1GB
    use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    require_once('vendor/autoload.php');
    $dbcon=mysqli_connect("localhost","root","","AMS");
    $dbcon->autocommit(TRUE);
    $allowed_ext=['xls','cvs','xlsx'];
    $tab=$_GET['tab'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Excel</title>
    <link rel="stylesheet" href="uploadExcel.css">
</head>
<body>
    <div class="container">
        <h2>Upload Students</h2>
        <h3>Table Format :</h3>
        <table border="1">
            <tr>
                
                    <td>Roll No</td>
                    <td>Email</td>
                    <td>Name</td>
                    <td>Course</td>
                    <td>Phone No</td>
            </tr>
        </table>
        <form action="" method="post" enctype="multipart/form-data">
            <label>Select EXCEL file to upload:</label>
            <label for="file-input" id="file-label" class="custom-file-upload">Choose File</label>
            <input type="file" id="file-input" name="fileUpload[]" multiple required>
            <input type="submit" name="upload-file" id="upload-file" value="Upload File">
            <h5 id="prin"></h5>
        </form>
    </div>
    <script>
        document.getElementById('file-input').addEventListener('change', function() {
            var fileLabel = document.getElementById('file-label');
            var fileNames = Array.from(this.files).map(file => file.name).join(', ');
            fileLabel.textContent = fileNames || 'Choose Files';
        });
    </script>

    <?php
        if(isset($_POST['upload-file'])){

            for($i=0;$i<count($_FILES['fileUpload']['name']);$i++){
                $fileName= basename($_FILES['fileUpload']['name'][$i]);
                $uploadfile=$_FILES['fileUpload']['tmp_name'][$i];
                move_uploaded_file($uploadfile, $fileName);
                $file_extension=pathinfo($fileName, PATHINFO_EXTENSION);

                if(in_array($file_extension, $allowed_ext)){

                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                    $spreadsheet = $reader->load($fileName);
                    $sheet = $spreadsheet->getSheet(0);
                    $spreadsheetAry = $sheet->toArray();
                    $sheetcount = count($spreadsheetAry);
                
                    // Start from the second row (skip header)
                    for($row=1; $row<$sheetcount; $row++){
                        $rollNo = isset($spreadsheetAry[$row][0]) ? $spreadsheetAry[$row][0] : '';
                        $email = isset($spreadsheetAry[$row][1]) ? $spreadsheetAry[$row][1] : '';
                        $studentName = isset($spreadsheetAry[$row][2]) ? strtoupper($spreadsheetAry[$row][2]) : '';
                        $className = isset($spreadsheetAry[$row][3]) ? strtoupper($spreadsheetAry[$row][3]) : '';
                        $parentContact = isset($spreadsheetAry[$row][4]) ? $spreadsheetAry[$row][4] : '';
                        
                        if($rollNo){
                            // Check whether the student already exists
                            $sqlx="SELECT * FROM users WHERE USER_NAME='$rollNo'";
                            $check = mysqli_query($dbcon, $sqlx);
                            $decision = mysqli_fetch_array($check);

                            // if($decision['USER_NAME'] == $rollNo){
                            //     // Update existing student
                            //     $sql2="UPDATE users SET EMAIL='$email' WHERE USER_ID='$decision[USER_ID]'";
                            //     $data2 = mysqli_query($dbcon, $sql2);
                            //     if($data2){
                            //         $sql21 = "UPDATE students SET NAMEE='$studentName', CLASS_NAME='$className', PARENT_CONTACT='$parentContact' WHERE USER_ID='$decision[USER_ID]'";
                            //         $data21 = mysqli_query($dbcon, $sql21);
                            //     }
                            // } else {
                                // Insert new student
                                $yy = substr($rollNo, 0, 2);
                                $year = 2000 + (int)$yy;
                                $batch = $className.$year;

                                // Check for the batch and create if not exists
                                $sql5="SELECT * FROM batches WHERE BATCH='$batch'";
                                $data5 = mysqli_query($dbcon, $sql5);
                                if(mysqli_num_rows($data5) == 0){
                                    $sql4 = "INSERT INTO batches (BATCH, YEARR, CLASS) VALUES('$batch','$year','$className')";
                                    $data4 = mysqli_query($dbcon, $sql4);
                                }

                                // Get batch ID
                                $sqlx = "SELECT * FROM batches WHERE BATCH='$batch'";
                                $datax = mysqli_query($dbcon, $sqlx);
                                $batch_key = mysqli_fetch_array($datax);
                                
                                // Insert user into 'users' table
                                $sql = "INSERT INTO users (USER_NAME, PASSWORDD, EMAIL, ROLEE) VALUES ('$rollNo', '$rollNo', '$email', '3')";
                                $data = mysqli_query($dbcon, $sql);
                                if($data){
                                    $sql2 = "SELECT USER_ID FROM users WHERE USER_NAME='$rollNo'";
                                    $data2 = mysqli_query($dbcon, $sql2);
                                    $user_key = mysqli_fetch_array($data2);
                                    $sql3 = "INSERT INTO students (USER_ID, NAMEE, CLASS_NAME, PARENT_CONTACT, BATCH_ID) VALUES ('$user_key[USER_ID]', '$studentName', '$className', '$parentContact', '$batch_key[BATCH_ID]')";
                                    $data3 = mysqli_query($dbcon, $sql3);
                                }
                            // }
                        }
                    }
                }
                unlink($fileName); // Remove the uploaded file
            }
            header("Location: adminDashboard.php?tab=" . $tab);      
        }
    ?>
</body>
</html>
