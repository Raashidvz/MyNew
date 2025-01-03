<?php
    error_reporting(0);
    use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    require_once('vendor/autoload.php');
    $dbcon=mysqli_connect("localhost","root","","AMS");
    $allowed_ext=['xls','cvs','xlsx'];
    $tab=$_GET['tab'];
    //GET ALL SUBJECTS
    $sql="SELECT SUBJECT_NAME FROM subjects";
    $subjects=mysqli_query($dbcon,$sql);
    if($subjects){
        $count=mysqli_num_rows($subjects);
        $allowed_sub=array($count);
        for($i=0;$i<$count;$i++){
            $row=mysqli_fetch_array($subjects);
            $allowed_sub[$i]=$row[0];
        }
    }

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

        <h2>Upload a New PDF</h2>
        <h3>Table Format :</h3>
        <table border="1">
            <tr>
                
                    <td>Roll No</td>
                    <td>Email</td>
                    <td>Name</td>
                    <td>Department</td>
                    <td>Joining Date</td>
            </tr>
            <tr>
                    <td>Phone No</td>
                    <td>SUB1</td>
                    <td>SUB2</td>
                    <td>SUB3</td>
                    <td>SUB4</td>
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

                    for($row=1;$row<=$sheetcount;$row++){
                        
                        $username=$spreadsheetAry[$row][0];
                        $email=$spreadsheetAry[$row][1];
                        $teacherName=$spreadsheetAry[$row][2];
                        $department=$spreadsheetAry[$row][3];
                        $joiningDate=$spreadsheetAry[$row][4];
                        $sub1=$spreadsheetAry[$row][5];
                        $sub2=$spreadsheetAry[$row][6];
                        $sub3=$spreadsheetAry[$row][7];
                        $sub4=$spreadsheetAry[$row][8];

                        // echo $username."<BR>";
                        // echo $email."<BR>";
                        // echo $teacherName."<BR>";
                        // echo $department."<BR>";
                        // echo $joiningDate."<BR>";
                        // echo $sub1."<BR>";
                        // echo $sub2."<BR>";
                        
                        //converting data to upper case for more accuracy
                        $teacherName=strtoupper($teacherName);
                        $department=strtoupper($department);
                        $joiningDate=strtoupper($joiningDate);
                        $SUB1=strtoupper($sub1);
                        $SUB2=strtoupper($sub2);
                        $SUB3=strtoupper($sub3);
                        $SUB4=strtoupper($sub4);
                        
                        if($username){

                            //check whether the data already exist or not
                            $sqlx="SELECT * FROM users where USER_NAME=$username";
                            $check=mysqli_query($dbcon,$sqlx);
                            $deciscion=mysqli_fetch_array($check);

                            if($deciscion[1]==$username){

                                //user already exist so update teacher
                                $sql2="UPDATE users SET EMAIL='$email' WHERE USER_ID='$deciscion[0]'";
                                $data2=mysqli_query($dbcon,$sql2);
                                if($data2){
                                    $sql21="UPDATE teachers SET NAMEE='$teacherName',DEPARTMENT='$department',JOINING_DATE='$joiningDate' WHERE USER_ID='$deciscion[0]'";
                                    $data21=mysqli_query($dbcon,$sql21);
                                    if($data21){
                                        //echo "DATA UPDATED SUCCESSFULLY";
                                    }

                                    //first delete subjects allotted and add new
                                    $sql="SELECT TEACHER_ID FROM teachers WHERE USER_ID=$deciscion[0]";
                                    $data=mysqli_query($dbcon,$sql);
                                    if($data){
                                        $teacherID=mysqli_fetch_array($data);
                                        $sql="UPDATE subjects SET TEACHER_ID=null WHERE TEACHER_ID=$teacherID[0]";
                                        $data=mysqli_query($dbcon,$sql);
                                        if($data){
                                            
                                            //now add subjects
                                            if(in_array($SUB1,$allowed_sub)){
                                                    $sql5="UPDATE subjects SET TEACHER_ID='$teacherID[0]' WHERE SUBJECT_NAME='$SUB1'";
                                                    $data5=mysqli_query($dbcon,$sql5);
                                            }
                                            if(in_array($SUB2,$allowed_sub)){
                                                $sql5="UPDATE subjects SET TEACHER_ID='$teacherID[0]' WHERE SUBJECT_NAME='$SUB2'";
                                                $data5=mysqli_query($dbcon,$sql5);
                                            }
                                        }
                                    }

                                }
                                   
                            }else{

                                //user doesnt exist so add teacher
                                $sql = "INSERT INTO users (USER_NAME, PASSWORDD, EMAIL,ROLEE) VALUES ('$username', '$username', '$email','2')";
                                $data=mysqli_query($dbcon,$sql);
                                if($data){
                                    
                                    //echo "Data inserted successfully";
                                    $sql2="SELECT USER_ID FROM users WHERE USER_NAME=$username";
                                    $data2=mysqli_query($dbcon,$sql2);
                                    if($data2){
                                        $key=mysqli_fetch_array($data2);
                                        $sql3="INSERT INTO teachers (USER_ID, NAMEE, DEPARTMENT, JOINING_DATE) VALUES ('$key[0]','$teacherName','$department','$joiningDate')";
                                        $data3=mysqli_query($dbcon,$sql3);
                                    }
                                }

                                if(in_array($SUB1,$allowed_sub)){
                                    $sql4="SELECT TEACHER_ID FROM teachers WHERE USER_ID=$key[0]";
                                    $data4=mysqli_query($dbcon,$sql4);
                                    if($data4){
                                        $teacherkey=mysqli_fetch_array($data4);
                                        $sql5="UPDATE subjects SET TEACHER_ID='$teacherkey[0]' WHERE SUBJECT_NAME='$SUB1'";
                                        $data5=mysqli_query($dbcon,$sql5);
                                    }
                                }
                            
                                if(in_array($SUB2,$allowed_sub)){
                                    $sql4="SELECT TEACHER_ID FROM teachers WHERE USER_ID=$key[0]";
                                    $data4=mysqli_query($dbcon,$sql4);
                                    if($data4){
                                        $teacherkey=mysqli_fetch_array($data4);
                                        $sql5="UPDATE subjects SET TEACHER_ID='$teacherkey[0]' WHERE SUBJECT_NAME='$SUB2'";
                                        $data5=mysqli_query($dbcon,$sql5);
                                    }
                                }

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
