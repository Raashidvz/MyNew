<?php
    session_start();
    $dbcon=mysqli_connect("localhost","root","","AMS");
    
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
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            line-height: 1.6;
        }

        .container {
            max-width: 500px;
            width: 100%;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            transition: transform 0.3s ease;
        }

        .container:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            color: #0d7aa7;
            font-size: 24px;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"],
        input[type="file"],
        textarea,
        select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        textarea:focus,
        select:focus,
        input[type="file"]:focus {
            border-color: #0d7aa7;
            outline: none;
            box-shadow: 0 0 5px rgba(13, 122, 167, 0.3);
        }

        textarea {
            resize: vertical;
        }

        input[type="submit"] {
            background-color: #0d7aa7;
            color: white;
            padding: 15px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        input[type="submit"]:hover {
            background-color: #0a6b91;
            transform: translateY(-2px);
        }

        input[type="submit"]:active {
            transform: translateY(0);
        }

        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }

        .file-input-label {
            background-color: #0d7aa7;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: inline-block;
        }

        /* .file-input-label:hover {
            background-color: #4d6f66;
        } */

        .file-input-wrapper input[type="file"] {
            font-size: 100px;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
        }

        .file-chosen {
            margin-top: 10px;
            font-style: italic;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Upload Question Paper</h1>
        <form action="" method="post" enctype="multipart/form-data">
           
            <input type='text' id='year' name='year' placeholder='Enter Year' required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" placeholder="Enter a description of the file" required></textarea>

            <div class="file-input-wrapper">
                <label class="file-input-label" for="file">Choose PDF File</label>
                <input type="file" id="file" name="fileUpload" accept=".pdf" required>
                <span class="file-chosen">No file chosen</span>
            </div>

            <input type="submit" name="addNew" value="Upload PDF">
        </form>
    </div>
    <script>
        const fileInput = document.getElementById('file');
        const fileChosen = document.querySelector('.file-chosen');

        fileInput.addEventListener('change', function () {
            fileChosen.textContent = this.files[0].name;
        });
    </script>

    <?php
        if(isset($_POST['addNew'])){
           
            $year=$_POST['year'];
            $description=$_POST['description'];
            $date = date('Y-m-d');  // Current date
            $time=date("h:i:s A");
            $time = str_replace(':', '-', date("h-i-s A"));


            
            
            
            
                $file_extension = pathinfo($_FILES['fileUpload']['name'], PATHINFO_EXTENSION);
                $new_file_name = $_SESSION["SUBJECT_NAME"] . '_' . $title . '_' . $_SESSION["MODULE"] . '_PAPER_' . $time . '.' . $file_extension;

                if (!file_exists(__DIR__ . "\\..\\notesAndAssignments\\PAPERPATHWAY\\")) {
                    mkdir(__DIR__ . "\\..\\notesAndAssignments\\PAPERPATHWAY\\", 0777, true);
                }
            
                // Use absolute path
                $upload_path = __DIR__ . "\\..\\notesAndAssignments\\PAPERPATHWAY\\" . $new_file_name;
                $path_for_db ="../notesAndAssignments/PAPERPATHWAY/" . $new_file_name;

                move_uploaded_file($_FILES['fileUpload']['tmp_name'], $upload_path);
            
            
            // echo $upload_path;

            //Now lets add this to database
            // echo "<br>".$_SESSION["USER_ID"];
            // echo "<br>".$_SESSION["TEACHER_ID"];
            // echo "<br>".$_SESSION["SUBJECT_ID"];
            // echo "<br>".$_SESSION["SUBJECT_NAME"];
            // echo "<br>".$_SESSION["MODULE"];
            // echo "<br>".$_SESSION["MODULE_NAME"];
            // print_r($_SESSION);

            $sql="INSERT INTO notes(SUBJECT_ID, TEACHER_ID, MODULE_NAME, DESCRIPTIONN, CATEGORY, FILE_NAME) VALUES ('$_SESSION[SUBJECT_ID]','$_SESSION[TEACHER_ID]','$year','$description','PAPERPATHWAY','$path_for_db')";
            $data=mysqli_query($dbcon,$sql);
            if($data){
                echo "<script>alert('Question paper uploaded successfully!'); window.location.href='moduleList.php?id=".$_SESSION['SUBJECT_ID']."&subject=".$_SESSION['SUBJECT_NAME']."&tab=PaperPathway';</script>";
                
            }
            
            
        }
    ?>
</body>

</html>
