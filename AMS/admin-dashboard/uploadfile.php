<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <h2>Select file</h2>
        <input type="file" name="excelfile[]" multiple required>
        <input type="submit" name="upload" value="Submit">
    </form>
    <?php
        if(isset($_POST['upload'])){
            $dbcon=mysqli_connect("localhost","root","","exam");
            $filename = [];
            for($i=0;$i<count($_FILES['excelfile']['name']);$i++){
                $filename[]= basename($_FILES['excelfile']['name'][$i]);
                $uploadfile=$_FILES['excelfile']['tmp_name'][$i];
                $targetpath="uploadedfiles/".$filename[$i];
                move_uploaded_file($uploadfile,$targetpath);
            }
            $files=implode(', ',$filename);
            $sql="INSERT INTO uploads (names) VALUES ('$files')";
            $data=mysqli_query($dbcon,$sql);
            if($data>0){
                echo "Files uploaded successfully";
            }

        }
    ?>
</body>
</html>
