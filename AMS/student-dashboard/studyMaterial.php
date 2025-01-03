<?php
    session_start();
    if($_SERVER['REQUEST_METHOD']=='GET'){
        // session_start();
        error_reporting(0);
        $module=$_GET['module'];
        $dbcon=mysqli_connect("localhost","root","","AMS");
        $_SESSION["MODULE"] = $module;
        
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
            color: #0d7aa7;
            line-height: 1.6;
        }

        .header {
            background-color: #0d7aa7;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            color: 4b3e1c;
        }

        .navbar {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-left: 40px;
            height: 80px;
        }

        
        .back-button {
            background-color: #0d7aa7;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 24px;
            font-weight: bold;
            transition: background-color 0.3s;
            display: inline-block;
        }

        .back-button-container {
            text-align: left;
            margin-bottom: 20px;
        }

        .selection {
            width: 100%;
            display: flex;
            justify-content: space-around;
            padding: 0;
            margin: 0;
            background-color: #0d7aa7;
        }

        .selection ul {
            display: flex;
            width: 100%;
            padding: 0;
            margin: 0;
            list-style-type: none;
        }

        .selection ul li {
            flex: 1;
            text-align: center;
        }

        .selection ul li a {
            display: block;
            padding: 15px 0;
            color: white;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
            transition: color 0.3s;
        }

        .selection ul li a.active {
            color: #f4f4f9;
            /* background-color: #0073a7; */
            position: relative;
        }

        .selection ul li a.active::after {
            content: "";
            position: absolute;
            left: 20%;
            right: 20%;
            bottom: 0;
            height: 4px;
            background-color: white;
            border-radius: 2px;
        }

        /* .selection ul li a:hover {
            color: #f0f0f0;
        } */

        .container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* .container h1 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #0d7aa7;
            text-align: center;
        } */

        .pdf-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .pdf-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .pdf-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .pdf-details {
            flex: 1;
            margin-right: 20px;
        }

        .pdf-details h3 {
            margin: 0 0 10px;
            font-size: 14px;
            color: #0d7aa7;
        }

        .pdf-details p {
            margin: 0;
            color: #666;
        }

        .pdf-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .pdf-actions a {
            text-decoration: none;
            color: white;
            background-color: #0d7aa7;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s;
        }

        .pdf-actions a:hover {
            background-color: #0a6b91;
        }

        .section {
            display: none;
        }
        .new-btn{
            display: inline-block;
            padding: 10px 20px;
            background-color: #f9f9f9;
            color: #0a6b91;
            width: 70px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-family: Arial, sans-serif;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .new-btn:hover {
            color: white;
            background-color: #0a6b91;
        }
    </style>
</head>

<body>
    <!-- Header including Navbar and Selection -->
    <div class="header">
        <!-- Navigation bar -->
        <div class="navbar">
            <button class="back-button" onclick="history.back()">Module - <?php echo $_SESSION["MODULE"];?></button>
            
        </div>

        <!-- Selection Bar -->
        <div class="selection">
            <ul>
                <li><a id="notes-tab" class="active" onclick="showSection('notes')">Notes</a></li>
                <li><a id="assignments-tab" onclick="showSection('assignments')">Assignments</a></li>
            </ul>
        </div>
    </div>

    <!-- Notes Section -->
    <div class="container section" id="notes">
        <div class="pdf-list">
            <?php
                //echo "<a href='addfile.php?type=NOTE' class='new-btn'>Add New</a>";
                $sql="SELECT * FROM notes WHERE SUBJECT_ID='$_SESSION[SUBJECT_ID]' AND MODULE='$module' AND CATEGORY='NOTE'";
                $modules=mysqli_query($dbcon,$sql);
                if($modules){
                    $totalFiles=mysqli_num_rows($modules);
                    if($totalFiles==0){
                        echo "<div class='pdf-item'>
                                    <div class='pdf-details'>
                                        <h3>No Notes added!</h3>
                                        
                                    </div>
                                </div>";
                    }else{
                        for($i=0;$i<$totalFiles;$i++){
                            $study_material=mysqli_fetch_array($modules);
                            echo "<div class='pdf-item'>
                                    <div class='pdf-details'>
                                        <h3>".$study_material['MODULE_NAME']."</h3>
                                        <p>".$study_material['DESCRIPTIONN']."</p>
                                    </div>
                                    <div class='pdf-actions'>
                                        <a href='".$study_material['FILE_NAME']."' target='_blank'>View PDF</a>
                                        <a href='".$study_material['FILE_NAME']."' download>Download PDF</a>
                                    </div>
                                </div>";
                        }
                    }
                    
                    
                }
                
                    
            ?>
        </div>
    </div>

    <!-- Assignments Section -->
    <div class="container section" id="assignments">
        <div class="pdf-list">
            <?php
                //echo "<a href='addfile.php?type=ASSIGNMENT' class='new-btn'>Add New</a>";
                $sql="SELECT * FROM notes WHERE SUBJECT_ID='$_SESSION[SUBJECT_ID]' AND MODULE='$module' AND CATEGORY='ASSIGNMENT'";
                $modules=mysqli_query($dbcon,$sql);
                if($modules){
                    $totalFiles=mysqli_num_rows($modules);
                    if($totalFiles==0){
                        echo "<div class='pdf-item'>
                                    <div class='pdf-details'>
                                        <h3>No Assignments added!</h3>
                                        
                                    </div>
                                </div>";
                    }else{
                        for($i=0;$i<$totalFiles;$i++){
                            $study_material=mysqli_fetch_array($modules);
                            echo "<div class='pdf-item'>
                                    <div class='pdf-details'>
                                        <h3>".$study_material['MODULE_NAME']."</h3>
                                        <p>".$study_material['DESCRIPTIONN']."</p>
                                    </div>
                                    <div class='pdf-actions'>
                                        <a href='path/to/assignment1.pdf' target='_blank'>View Assignment</a>
                                        <a href='path/to/assignment1.pdf' download>Download Assignment</a>
                                    </div>
                                </div>";
                        }
                    }
                        
                    
                }
                
                    
            ?>
        </div>
    </div>

    <script>
        function showSection(sectionId) {
            // Hide all sections
            const sections = document.querySelectorAll('.section');
            sections.forEach(section => section.style.display = 'none');

            // Show the selected section
            document.getElementById(sectionId).style.display = 'block';

            // Remove the active class from all tabs
            const tabs = document.querySelectorAll('.selection ul li a');
            tabs.forEach(tab => tab.classList.remove('active'));

            // Add the active class to the clicked tab
            document.getElementById(sectionId + '-tab').classList.add('active');
        }

        // Show the "Notes" section by default when the page loads
        document.addEventListener('DOMContentLoaded', () => {
            showSection('notes');
        });
    </script>
</body>

</html>
