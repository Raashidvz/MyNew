<?php
    session_start();
    $dbcon=mysqli_connect("localhost","root","","AMS");

    if($_SERVER['REQUEST_METHOD']=='GET'){
        // error_reporting(0);
        

        $sql="SELECT * FROM routemap WHERE SUBJECT_NAME = '$_SESSION[SUBJECT_NAME]' AND TEACHER_ID = '$_SESSION[TEACHER_ID]' AND YEARR = (SELECT MAX(YEARR) FROM routemap WHERE SUBJECT_NAME = '$_SESSION[SUBJECT_NAME]' AND TEACHER_ID = '$_SESSION[TEACHER_ID]')";
        $routemap=mysqli_query($dbcon,$sql);
        if($routemap){
            $routemap_row=mysqli_fetch_array($routemap);
            $_SESSION["current_batch"]=$routemap_row['YEARR'];
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
        <h1>Upload Assignment</h1>
        <form action="" method="post" enctype="multipart/form-data">
           
            <input type='text' id='title' name='title' placeholder='Enter title' required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" placeholder="Enter a description of the file" required></textarea>

            
                <select id="module" name="module">
                    <option value="0" >General Assignment</option>
                    <option value="1">Module-1</option>
                    <option value="2">Module-2</option>
                    <option value="3">Module-3</option>
                    <option value="4">Module-4</option>
                    <option value="5">Module-5</option>
                </select>


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
           
            $title=$_POST['title'];
            $description=$_POST['description'];
            $module=$_POST['module'];
            $date = date('Y-m-d');  // Current date
            $time=date("h:i:s A");
            $time = str_replace(':', '-', date("h-i-s A"));


            
            
            
            
                $file_extension = pathinfo($_FILES['fileUpload']['name'], PATHINFO_EXTENSION);
                $new_file_name = $_SESSION["SUBJECT_NAME"] . '_' . $title . '_' . $_SESSION["MODULE"] . '_assignment_' . $time . '.' . $file_extension;

                if (!file_exists(__DIR__ . "\\..\\notesAndAssignments\\ASSIGNMENTS\\")) {
                    mkdir(__DIR__ . "\\..\\notesAndAssignments\\ASSIGNMENTS\\", 0777, true);
                }
            
                // Use absolute path
                $upload_path = __DIR__ . "\\..\\notesAndAssignments\\ASSIGNMENTS\\" . $new_file_name;
                $path_for_db ="../notesAndAssignments/ASSIGNMENTS/" . $new_file_name;

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

            $sql="INSERT INTO notes(SUBJECT_ID, TEACHER_ID, MODULE, MODULE_NAME, DESCRIPTIONN, CATEGORY, BATCH , FILE_NAME) VALUES ('$_SESSION[SUBJECT_ID]','$_SESSION[TEACHER_ID]','$module','$title','$description','ASSIGNMENT', '$_SESSION[current_batch]' , '$path_for_db')";
            $data=mysqli_query($dbcon,$sql);
            if($data){
                echo "<script>alert('Assignment uploaded successfully!'); window.location.href='moduleList.php?id=".$_SESSION['SUBJECT_ID']."&subject=".$_SESSION['SUBJECT_NAME']."&tab=AssignGrades';</script>";
                
            }
            
            
        }
    ?>
</body>

</html>
