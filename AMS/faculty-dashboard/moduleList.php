<?php
    session_start();
    if($_SERVER['REQUEST_METHOD']=='GET'){
        // session_start();
        error_reporting(0);
        $sub_id=$_GET['id'];
        $sub_name=$_GET['subject'];
        $tag=$_GET['tag'];
        $dbcon=mysqli_connect("localhost","root","","AMS");

        //Lets store data to session
        $_SESSION["SUBJECT_ID"] = $sub_id;
        $_SESSION["SUBJECT_NAME"] = $sub_name;
        $_SESSION["TAG"]=$tag;

        $sqq="SELECT * FROM subjects WHERE SUBJECT_ID='$sub_id'";
        $subj=mysqli_query($dbcon,$sqq);
        if($subj){
            $subject_details=mysqli_fetch_array($subj);
            $_SESSION["SEMESTER"]=$subject_details['SEMESTER'];
        }

        $sql="SELECT * FROM routemap WHERE SUBJECT_NAME='$_SESSION[SUBJECT_NAME]' AND TEACHER_ID='$_SESSION[TEACHER_ID]'";
        $routemap=mysqli_query($dbcon,$sql);
        if($routemap){
            $routemap_row=mysqli_fetch_array($routemap);
            $year_of_batch=$routemap_row['YEARR'];
            $sql="SELECT * FROM batches WHERE YEARR='$routemap_row[YEARR]' AND CLASS='$routemap_row[CLASS]'";
            $batch=mysqli_query($dbcon,$sql);
            if($batch){
                $batch_row=mysqli_fetch_array($batch);
                $batch_id=$batch_row['BATCH_ID'];
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style21.css" type="text/css">
    <STYLE>
        .new-btn{
            display: inline-block;
            padding: 15px 20px;
            background-color: #ffffff;
            color: #0a6b91;
            width: 110px;
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
        .assign-btns {
            display: flex;
            flex-direction: row;
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
        .overview-cards{
            padding-top: 10px;
        }
        .header h1{
            margin-top: 10px;
        }
        
    </STYLE>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.sidebar ul li a');
    const contents = document.querySelectorAll('.tab-content');

    // Function to show the active tab
    function showActiveTab(tabId) {
        contents.forEach(content => content.classList.remove('active'));
        const target = document.getElementById(tabId);
        if (target) {
            target.classList.add('active');
        }
    }

    // Load the tab based on URL parameter
    const urlParams = new URLSearchParams(window.location.search);
    const activeTab = urlParams.get('tab');

    if (activeTab) {
        showActiveTab(activeTab); // Load the tab based on URL parameter
    } else {
        contents[0].classList.add('active'); // Load the first tab by default
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', function (e) {
            const href = tab.getAttribute('href');
            if (href.startsWith('#')) {
                e.preventDefault();
                const tabId = href.substring(1);
                showActiveTab(tabId); // Switch the tab
            }
        });
    });
});

    </script>
</head>
<body>
    <!-- <header>
        <h1>Admin Dashboard</h1>
        <nav>
            <ul>
                <li><a href="#" class="logout-btn">Logout</a></li>
            </ul>
        </nav>
    </header> -->
    <div class="dashboard">
        <aside class="sidebar">
           
            <ul>
            <?php echo "<li><a href='facultyDashboard.php?id=".$_SESSION['USER_ID']."'>Back</a></li>"; ?>
            <li><a href='#overview'>Overview</a></li>
            <?php
                $sql="SELECT TOTAL_MODULES FROM subjects WHERE SUBJECT_ID='$sub_id'";
                $subject=mysqli_query($dbcon,$sql);
                if($subject){
                    $module_count=mysqli_fetch_array($subject);
                
                    for($i=1;$i<=$module_count[0];$i++){
                        $sql="SELECT * FROM notes WHERE SUBJECT_ID='$sub_id' AND MODULE='$i'";
                        $module=mysqli_query($dbcon,$sql);
                        if($module){
                            
                            $module_row=mysqli_fetch_array($module);
                            $module_name=($module_row['MODULE_NAME']==null)?"Module not added":$module_row['MODULE_NAME'];
                            //$_SESSION['MODULE_NAME']=$module_name;
                            echo "
                                
                                    
                                    <li><a href='#module".$i."'>Module-".$i."</a></li>
                               
                            ";
                        }
                        
                    }
                }
                
                
            ?>
            <li><a href='#AssignGrades'>AssignGrades</a></li>
            <li><a href='#PaperPathway'>PaperPathway</a></li>
            <li><a href='#Archives'>Archives</a></li>
            <li><a href='#Students'>Students</a></li>
               
                <!-- <a href='notes-assignments.php?module=".$i."'>View</a> -->
            </ul>
            <a href="logout.php" class="logout-btn">Logout</a>
            
        </aside>
        
        <main class="content">
            <!-- Content will be dynamically loaded here -->
            <div id="overview" class="tab-content">
                <header class="header">
                    <h1><?php echo $_SESSION["SUBJECT_NAME"] ?> </h1>
                </header>
                <div class="overview-cards">
                    <div class="card total-users">
                        <h3>Semester</h3>
                        <p><?php echo $_SESSION['SEMESTER']; ?></p>
                    </div>
                    <div class="card learning-time">
                        <h3>Total Modules</h3>
                        <p><?php echo $module_count[0]; ?></p>
                    </div>
                    <div class="card total-contents">
                        <h3>Total Students</h3>
                        <p><?php 
                            $zz="SELECT * FROM students WHERE BATCH_ID='$batch_id' order by NAMEE";
                            $xx=mysqli_query($dbcon,$zz);
                            $count=mysqli_num_rows($xx);
                        echo $count ?></p>
                    </div>
                </div>
                <!-- <div class="charts">
                    <div class="chart-container">
                        <div class="symbol"></div>
                            <div class="day"><?php echo $currentDay; ?></div>
                            <div class="date"><?php echo $currentDate; ?></div>
                        </div>
                    <div class="chart-container">
                        <canvas id="learningProgress"></canvas>
                    </div>
                </div> -->
            </div>

            <!-- module contents -->
            <?php
                $sql="SELECT TOTAL_MODULES FROM subjects WHERE SUBJECT_ID='$sub_id'";
                $subject=mysqli_query($dbcon,$sql);
                if($subject){
                    $module_count=mysqli_fetch_array($subject);
                
                    for($i=1;$i<=$module_count[0];$i++){
                        $sql="SELECT * FROM notes WHERE SUBJECT_ID='$sub_id' AND MODULE='$i' AND TEACHER_ID='$_SESSION[TEACHER_ID]' AND CATEGORY='NOTE'";
                        $study_material=mysqli_query($dbcon,$sql);
                        if($study_material){
                            //Main body according to module selection
                            echo "<div id='module".$i."' class='tab-content'>";
                                
                                //content in this module
                                // echo "<header class='header'>
                                //         <h1>Module ".$i."</h1>
                                //     </header>";
                                if($tag!='old'){
                                    echo "<a href='addNotes.php?module=".$i."' class='new-btn'>Add New</a>";
                                }
                                // echo "<h2>NOTES</h2>";
                                echo "<div style='height: 20px; width: 100%;'></div>";
                                echo "<div class='panel-container'>";
                                $study_material_count=mysqli_num_rows($study_material);
                            
                                if($study_material_count>0){

                                
                                    
                            
                                        for($j=0;$j<$study_material_count;$j++){
                                            $study_material_row=mysqli_fetch_array($study_material);
                                            $title=($study_material_row['MODULE_NAME']==null)?"Module not added":$study_material_row['MODULE_NAME'];
                                            // Dynamically get the file path from the database
                                            $file_path = $study_material_row['FILE_NAME'];  // This should be the column storing the file path
                                            // $sub_row=mysqli_fetch_array($subjects);
                                            echo "<div class='pdf-item'>
                                                        <div class='pdf-details'>
                                                            <h3>".$study_material_row['MODULE_NAME']."</h3>
                                                            <p>".$study_material_row['DESCRIPTIONN']."</p>
                                                        </div>
                                                        <div class='pdf-actions'>
                                                            <a href='$file_path' target='_blank'>View </a>";
                                                            if($tag!='old'){
                                                                echo "<a href='deleteFile.php?id=".$study_material_row['NOTE_ID']."&tab=module".$i."' onclick='return confirmDelete()'>Delete </a>";
                                                            }else{
                                                                echo "<a href='".$study_material_row['FILE_NAME']."' download>Download</a>";
                                                            }
                                                            
                                                        echo "</div>
                                                        
                                                </div>";
                                        }
                                }else{
                                    echo "<div class='pdf-item'>
                                            <div class='pdf-details'>
                                                <h3>No module-".$i." files added</h3>
                                            </div>               
                                        </div>";
                                }
                                echo "</div>";
                               
                            echo "</div>";
                        }
                        
                    }
                }
                
            ?>
            
            <!-- Assign grades  -->
            <div id="AssignGrades" class="tab-content">  
            
                <?php
                    $sql="SELECT * FROM notes WHERE SUBJECT_ID='$sub_id' AND TEACHER_ID='$_SESSION[TEACHER_ID]' AND CATEGORY='ASSIGNMENT' ORDER BY MODULE";
                    $assignments=mysqli_query($dbcon,$sql);
                    if($assignments){
                        echo "";
                        if($tag!='old'){
                            echo "<a href='addAssignments.php' class='new-btn'>Add New</a>";
                        }
                        echo "<div style='height: 20px; width: 100%;'></div>";
                        echo "<div class='panel-container'>";
                        $assignments_count=mysqli_num_rows($assignments);


                        if ($assignments_count > 0){

                        
                            for($j=0;$j<$assignments_count;$j++){
                                $assignments_row=mysqli_fetch_array($assignments);
                                if($assignments_row['MODULE']==0){
                                    $module='General Assignment';
                                }else{
                                    $module='Module'.$assignments_row['MODULE'];
                                }
                                // Dynamically get the file path from the database
                                $file_path = $assignments_row['FILE_NAME'];  // This should be the column storing the file path
                                echo "<div class='pdf-item'>
                                        <div class='pdf-details'>
                                            <h3>".$module." - ".$assignments_row['MODULE_NAME']."</h3>
                                            <p>".$assignments_row['DESCRIPTIONN']."</p>
                                        </div>
                                        <div class='pdf-actions assign-btns '>
                                            <a href='$file_path' target='_blank'>View </a>";
                                            if($tag!='old'){
                                                echo "<a href='deleteFile.php?id=".$assignments_row['NOTE_ID']."&tab=AssignGrades' onclick='return confirmDelete()'>Delete </a>";
                                            }else{
                                                echo "<a href='$file_path' download>Download</a>";
                                            }
                                            echo "<a href='submitted_works.php?id=".$assignments_row['NOTE_ID']."'>Review </a>
                                        </div>
                                        
                                    </div>";
                            }
                        
                        }else{
                            echo "<div class='pdf-item'>
                                    <div class='pdf-details'>
                                        <h3>No assignments added</h3>
                                    </div>
                                </div>";
                        }
                    echo "</div>";                           
                        
                }
                    
                ?>
            </div>


            <div id="PaperPathway" class="tab-content">  
           
            <?php
                $sql="SELECT * FROM notes WHERE SUBJECT_ID='$sub_id' AND CATEGORY='PAPERPATHWAY'";
                $paper=mysqli_query($dbcon,$sql);
                if($paper){
                    echo "";
                    if($tag != 'old'){
                        echo "<a href='addPaper.php' class='new-btn'>Add New</a>";
                    }
                    echo "<div style='height: 20px; width: 100%;'></div>";
                    echo "<div class='panel-container'>";
                    $paper_count = mysqli_num_rows($paper);

                    if ($paper_count > 0){
                        for ($j = 0; $j < $paper_count; $j++) {
                            $paper_row = mysqli_fetch_array($paper);

                            // Get the file path from the database
                            $file_path = $paper_row['FILE_NAME'];  // Ensure this is the correct column for file path
                            echo "<div class='pdf-item'>
                                    <div class='pdf-details'>
                                        <h3>".$paper_row['MODULE_NAME']."</h3>
                                        <p>".$paper_row['DESCRIPTIONN']."</p>
                                    </div>
                                    <div class='pdf-actions'>
                                        <a href='$file_path' target='_blank'>View</a>";
                                        if($tag!='old'){
                                            echo "<a href='deleteFile.php?id=".$paper_row['NOTE_ID']."&tab=PaperPathway' onclick='return confirmDelete()'>Delete</a>";
                                        }else{
                                            echo "<a href='$file_path' download>Download</a>";
                                        }
                                        
                                    echo "</div>
                                </div>";
                        }
                    } else {
                        echo "<div class='pdf-item'>
                                <div class='pdf-details'>
                                    <h3>No previous year question paper added</h3>
                                </div>
                            </div>";
                    }
                    echo "</div>";                           
                }
            ?>
        </div>


            

            
            <div id="Archives" class="tab-content">  
                <?php
                    $sqlx="SELECT * FROM subjects WHERE SUBJECT_ID='$sub_id'";
                    $sub=mysqli_query($dbcon,$sqlx);
                    $sub_details=mysqli_fetch_array($sub);
                    $sql="SELECT * FROM notes WHERE SUBJECT_ID='$sub_id' ORDER BY TEACHER_ID ";
                    $notes=mysqli_query($dbcon,$sql);
                    if($notes){
                        
                        echo "<div style='height: 20px; width: 100%;'></div>";
                        echo "<div class='panel-container'>";
                        $notes_count=mysqli_num_rows($notes);


                        if ($notes_count > 0){

                            $flag=0;
                            for($j=0;$j<$notes_count;$j++){
                                $notes_row=mysqli_fetch_array($notes);
                                if($notes_row['TEACHER_ID']==$sub_details['TEACHER_ID'] || $notes_row['TEACHER_ID']==$sub_details['TEACHER_ID2']){
                                    continue;
                                }else{

                                    $flag=1;
                                    if($notes_row['MODULE']==0){
                                        $module='General Assignment';
                                    }else{
                                        $module='Module'.$notes_row['MODULE'];
                                    }
                                    // Dynamically get the file path from the database
                                    $file_path = $notes_row['FILE_NAME'];  // This should be the column storing the file path
                                    echo "<div class='pdf-item'>
                                            <div class='pdf-details'>
                                                <h3>".$module." - ".$notes_row['MODULE_NAME']."</h3>
                                                <p>".$notes_row['DESCRIPTIONN']."</p>
                                                <p>".$sub_id."</p>
                                            </div>
                                            <div class='pdf-actions'>
                                                <a href='$file_path' target='_blank'>View </a>
                                                <a href='$file_path' download>Download</a>
                                            </div>
                                            
                                        </div>";
                                }
                            }
                        
                        }
                        
                        if($flag==0){
                            echo "<div class='pdf-item'>
                                    <div class='pdf-details'>
                                        <h3>No archieved files</h3>
                                    </div>
                                </div>";
                        }
                    echo "</div>";                           
                        
                }
                    
                ?>
            </div>

            <div id="Students" class="tab-content">
                <div class="container">
                    <table>
                        <thead>
                            <tr>
                                <th>Roll NO</th>
                                <th>Full Name</th>
                                <th>Batch</th>
                                <th>Email</th>
                                <th>Contact</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                
                                $sql="SELECT * FROM students WHERE BATCH_ID='$batch_id' order by NAMEE";
                                $data3=mysqli_query($dbcon,$sql);
                                if($data3){
                                    $student_count=mysqli_num_rows($data3);
                                    for($j=0;$j<$student_count;$j++){
                                        $student=mysqli_fetch_array($data3);
                                        $sql="SELECT * FROM users WHERE USER_ID='$student[USER_ID]'";
                                        $data4=mysqli_query($dbcon,$sql);
                                        $user=mysqli_fetch_array($data4);
                                        if($user['STATUSS']=='INACTIVE'){
                                            continue;
                                        }
                                        echo"  <tr>
                                                    <td>".$user['USER_NAME']."</td>
                                                    <td>".$student['NAMEE']."</td>
                                        
                                                    <td>".$batch_row['YEARR']."</td>
                                                    <td>".$user['EMAIL']."</td>
                                                    <td>".$student['PARENT_CONTACT']."</td>
                                                </tr>";
                                            
                                    }
                                } 
                            ?>
                            <!-- Add more student rows as needed -->
                        </tbody>
                    </table>
                </div>
            </div>   
        </main>
    </div>
</body>
<script>
function confirmDelete() {
    return confirm("Are you sure you want to delete this file?");
}
</script>
</html>
