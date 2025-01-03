<?php
    //error_reporting(0);
    use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    require_once('vendor/autoload.php');
    $dbcon=mysqli_connect("localhost","root","","AMS");
    $allowed_ext=['xls','cvs','xlsx'];
    $tab=$_GET['tab'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload PDF</title>
    <link rel="stylesheet" href="uploadExcel.css">
 
</head>
<body>
    <div class="container">

        <h2>Upload Subjects</h2>
        <h3>Table Format :</h3>
        <table border="1">
            <tr>
                    <td>Subject Name</td>
                    <td>Department</td>
                    <td>Semester</td>
                    <td>Total modules</td>
            </tr>
        </table>
        
        <form action="" method="post" enctype="multipart/form-data">
            <label>Select EXCEL file to upload:</label>
            <label for="file-input" id="file-label" class="custom-file-upload">
                Choose File
            </label>
            <input  type="file" id="file-input" name="fileUpload[]" multiple required>
            <input type="submit" name="upload-file" id="upload-file" value="Upload File">
            <h5 id="prin"></h5>
        </form>
    </div>
    <script>
        document.getElementById('file-input').addEventListener('change', function() {
            var fileLabel = document.getElementById('file-label');
            var fileNames = Array.from(this.files).map(file => file.name).join(', ');
            fileLabel.textContent = fileNames || 'Choose Files';
            document.getElementById('prin').value.innerHTML=fileNames;
        });
    </script>

    <?php
        if(isset($_POST['upload-file'])){
                 
            for($i=0;$i<count($_FILES['fileUpload']['name']);$i++){
                
                $fileName= basename($_FILES['fileUpload']['name'][$i]);
                $uploadfile=$_FILES['fileUpload']['tmp_name'][$i];
                move_uploaded_file($uploadfile,$fileName);
                $file_extension=pathinfo($fileName,PATHINFO_EXTENSION);
                
                if(in_array($file_extension,$allowed_ext)){

                    $reader=new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                    $spreedsheet=$reader->load($fileName);
                    $excelsheet=$spreedsheet->getSheet(0);
                    $spreadsheetAry=$excelsheet->toArray();
                    $sheetcount=count($spreadsheetAry);
                    // echo '<pre>';
                    // print_r($spreadsheetAry);
                    // echo '</pre>';
                    for($row=1;$row<=$sheetcount;$row++){
                        
                        $subjectName = mysqli_real_escape_string($dbcon, $spreadsheetAry[$row][0]);
                        $className = mysqli_real_escape_string($dbcon, $spreadsheetAry[$row][1]);
                        $semester = mysqli_real_escape_string($dbcon, $spreadsheetAry[$row][2]);
                        $totalmodules = mysqli_real_escape_string($dbcon, $spreadsheetAry[$row][3]);

                        if($subjectName){
                            $sql = "INSERT INTO subjects (SUBJECT_NAME, CLASS_NAME, SEMESTER,TOTAL_MODULES) VALUES ('$subjectName', '$className', '$semester','$totalmodules')";
                            $data=mysqli_query($dbcon,$sql);
                            if($data){
                             //echo "data inserted<br>";
                            }
                            
                        }
                        


                    }

                }
                unlink($fileName);
            }
            header("Location: adminDashboard.php?tab=" . $tab);
            
                
        }

    ?>


</body>
</html>
