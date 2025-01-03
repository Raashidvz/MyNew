<?php
    session_start();
    if($_SERVER['REQUEST_METHOD']=='GET'){
       // session_start();
        // error_reporting(0);
        // $userid=$_GET['id'];
        // $_SESSION["USER_ID"]=$userid;
        $dbcon=mysqli_connect("localhost","root","","AMS");
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            // First visit with 'id' in URL, store it in session
            $userid = $_GET['id'];
            $_SESSION["USER_ID"] = $userid;
        } elseif (isset($_SESSION['USER_ID'])) {
            // Use the 'USER_ID' from session for subsequent requests
            $userid = $_SESSION['USER_ID'];
        } else {
            // If no 'id' in URL and no session, redirect or show an error
            echo "User ID is missing.";
            exit;
        }
        // $sql="SELECT * FROM users WHERE USER_ID='$userid'";
        // $admin=mysqli_query($dbcon,$sql);
        // if($admin){
        //     $admin_row=mysqli_fetch_array($admin);
        // }
        // Get current day and date

        // Get today's events
    $currentDateForDB = date('Y-m-d');
    $sql = "SELECT event_title FROM events WHERE event_date = '$currentDateForDB' AND USER_ID='$_SESSION[USER_ID]'";
    $result = mysqli_query($dbcon, $sql);
    $eventsToday = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $eventsToday[] = $row['event_title'];
        }
    }

    $currentDay = date('l');  // e.g., "Monday"
    $currentDate = date('F j, Y');  // e.g., "October 11, 2024"

        $sql="SELECT * FROM teachers";
        $teachers=mysqli_query($dbcon,$sql);
        if($teachers){
            $teachers_count=mysqli_num_rows($teachers);
        }

        $sql="SELECT * FROM batches";
        $batches=mysqli_query($dbcon,$sql);
        if($batches){
            $batches_count=mysqli_num_rows($batches);
        }

        $sql="SELECT * FROM subjects";
        $subjects=mysqli_query($dbcon,$sql);
        if($subjects){
            $subjects_count=mysqli_num_rows($subjects);
        }

        // $sql="SELECT * FROM subjects WHERE TEACHER_ID='$teacher_row[TEACHER_ID]' OR TEACHER_ID2='$teacher_row[TEACHER_ID]'";
        // $subjects=mysqli_query($dbcon,$sql);
        // if($subjects){
        //     $sub_count=mysqli_num_rows($subjects);
        // }

        // $sql="SELECT * FROM notes WHERE TEACHER_ID='$teacher_row[TEACHER_ID]'";
        // $notes=mysqli_query($dbcon,$sql);
        // if($notes){
        //     $file_count=mysqli_num_rows($notes);
        // }

        //Lets store data in session
        // $_SESSION["USER_ID"] = $userid;
        // $_SESSION["TEACHER_ID"] = $teacher_row['TEACHER_ID'];

    }
    if (isset($_POST['add_event'])) {
        $eventDate = $_POST['date'];
        $eventTitle = $_POST['title'];
    
        // Check if both fields are set and not empty
        if (!empty($eventDate) && !empty($eventTitle)) {
            $dbcon = mysqli_connect("localhost", "root", "", "AMS");
    
            // Check if the connection is successful
            if ($dbcon) {
                $stmt = $dbcon->prepare("INSERT INTO events (USER_ID,event_date, event_title) VALUES (?,?, ?)");
    
                if ($stmt) {
                    $stmt->bind_param("sss",$_SESSION['USER_ID'], $eventDate, $eventTitle);
                    if ($stmt->execute()) {
                        // Event successfully added
                        echo "<script>alert('Event added successfully!');</script>";
                    } else {
                        echo "<script>alert('Failed to add event!');</script>";
                    }
                    $stmt->close();
                } else {
                    echo "<script>alert('Failed to prepare statement!');</script>";
                }
    
                mysqli_close($dbcon); // Close the connection after execution
            } else {
                echo "<script>alert('Database connection failed!');</script>";
            }
        } else {
            echo "<script>alert('Both fields are required!');</script>";
        }
    
        // Redirect to the calendar tab after adding the event
        header("Location: ?tab=view-calendar");
        exit();
    }
    
// Get current month and year
if (isset($_GET['month']) && isset($_GET['year'])) {
    $month = $_GET['month'];
    $year = $_GET['year'];
} else {
    $month = date('m');
    $year = date('Y');
}

// Fetch events for the current month
$startOfMonth = "$year-$month-01";
$endOfMonth = "$year-$month-" . date('t', strtotime($startOfMonth));
$query = "SELECT * FROM events WHERE USER_ID='$_SESSION[USER_ID]' AND event_date BETWEEN '$startOfMonth' AND '$endOfMonth'";
$result = $dbcon->query($query);
$events = [];
while ($row = $result->fetch_assoc()) {
    $events[$row['event_date']][] = $row['event_title'];
}

// Calculate previous and next months
$prevMonth = $month - 1;
$nextMonth = $month + 1;
$prevYear = $year;
$nextYear = $year;

if ($prevMonth < 1) {
    $prevMonth = 12;
    $prevYear--;  // Decrement year when moving back from January to December
}
if ($nextMonth > 12) {
    $nextMonth = 1;
    $nextYear++;  // Increment year when moving forward from December to January
}

// Zero-pad the month values for consistency
$prevMonth = str_pad($prevMonth, 2, "0", STR_PAD_LEFT);
$nextMonth = str_pad($nextMonth, 2, "0", STR_PAD_LEFT);

$firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
$daysInMonth = date('t', $firstDayOfMonth);
$monthName = date('F', $firstDayOfMonth);
$firstDayOfWeek = date('w', $firstDayOfMonth);
$dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style21.css" type="text/css">
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('.sidebar ul li a');
            const contents = document.querySelectorAll('.tab-content');

            // Function to show the active tab
            function showActiveTab(tabId) {
                // Hide all contents
                contents.forEach(content => content.classList.remove('active'));

                // Show the target tab content
                const target = document.getElementById(tabId);
                if (target) {
                    target.classList.add('active');
                }
            }

            // Check the URL parameters for the active tab
            const urlParams = new URLSearchParams(window.location.search);
            const activeTab = urlParams.get('tab');

            if (activeTab) {
                showActiveTab(activeTab); // Load the tab based on URL parameter
            } else {
                contents[0].classList.add('active'); // Load the first tab by default
            }

            tabs.forEach(tab => {
                tab.addEventListener('click', function (e) {
                    e.preventDefault();
                    const tabId = tab.getAttribute('href').substring(1); // Get tab ID from href
                    showActiveTab(tabId);
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
                <li><a href="#overview">Overview</a></li>
                <li><a href="#manage-students">Manage Students</a></li>
                <li><a href="#manage-teachers">Manage Teachers</a></li>
                <li><a href="#manage-subjects">Manage Subjects</a></li>
                <li><a href="#manage-batches">Manage Batches</a></li>
                <li><a href="#view-calendar">Calendar</a></li>
            </ul>
            <a href="logout.php" class="logout-btn">Logout</a>
            
        </aside>
        <main class="content">
            <!-- Content will be dynamically loaded here -->
            <div id="overview" class="tab-content">
                <header class="header">
                    <h1>Welcome to control room!</h1>
                </header>
                <div class="overview-cards">
                    <div class="card total-users">
                        <h3>Total Batches</h3>
                        <p><?php echo $batches_count; ?></p>
                    </div>
                    <div class="card learning-time">
                        <h3>Total Subjects</h3>
                        <p><?php echo $subjects_count; ?></p>
                    </div>
                    <div class="card total-contents">
                        <h3>Total teachers</h3>
                        <p><?php echo $teachers_count; ?></p>
                    </div>
                </div>
                <div class="charts">
                    <div class="chart-container">
                        <div class="symbol">📅</div>
                            <div class="day"><?php echo $currentDay; ?></div>
                            <div class="date"><?php echo $currentDate; ?></div>
                        
                            <div class="events">
                                <?php if (!empty($eventsToday)): ?>
                                    <ul>
                                        <?php foreach ($eventsToday as $event): ?>
                                            <li><?php echo $event; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="chart-container">
                        <div class="symbol"></div>
                        <div style="height:55px;"></div>
                            <div style="color:#428bda;" class="day">FUNIVERSITY</div>
                            <div class="date"></div>
                
                    </div>
                </div>
            </div>

            <div id="manage-students" class="tab-content">
                <a href="addStudents.php?tab=manage-students" class="new-btn">Add New</a>
                <div style="height: 20px; width: 100%;"></div>
                <?php
                    $sql = "SELECT * FROM batches";
                    $batch = mysqli_query($dbcon, $sql);
                    if ($batch) {
                        echo "<div class='cardx-container'>";
                        $count = mysqli_num_rows($batch);
                        for ($i=0; $i < $count; $i++) {
                            $batch_row = mysqli_fetch_array($batch);
                            
                            echo "<div class='cardx'>
                                <h3>Batch-".$batch_row['CLASS']."</h3>
                                <p>".$batch_row['YEARR']."</p>
                                <a href='viewStudents.php?id=".$batch_row['BATCH_ID']."'>View</a>
                                </div>";
                        }
                    }
                    echo "</div>";
                ?>
            </div>
        
            <div id="manage-subjects" class="tab-content">
                <a href="addSubjects.php?tab=manage-subjects" class="new-btn">Add New</a>
                <div style="height: 20px; width: 100%;"></div>
                <table>
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Class</th>
                            <th>Semester</th>
                            <!-- <th>Teacher-1</th>
                            <th>Teacher-2</th> -->
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    <?php
                        $sql="SELECT * FROM subjects ORDER BY SEMESTER";
                        $subjectTable=mysqli_query($dbcon,$sql);
                        if($subjectTable){
                            $rowCount=mysqli_num_rows($subjectTable);
                            for($i=0;$i<$rowCount;$i++){
                                $subject=mysqli_fetch_array($subjectTable);
                                $id=$subject['SUBJECT_ID'];

                                echo "<tr>
                                        <td>".$subject['SUBJECT_NAME']."</td>
                                        <td>".$subject['CLASS_NAME']."</td>
                                        <td>".$subject['SEMESTER']."</td>
                                       
                                        <td class='action-btn'><a href='update_subject.php?id=".$id."&tab=manage-subjects' class='update-btn'>Update</a></td>
                                    </tr>";
                            }
                            // <td>".$teacherName1."</td>
                            // <td>".$teacherName2."</td>
                            // <td class='action-btn'><a href='update_subject.php?id1=".$key1."&id2=".$key2."&tab=manage-teachers' class='update-btn'>Update</a><a href='delete.php?id=".$subject['SUBJECT_ID']."&rolee=subject1&tab=manage-subjects' class='delete-btn'>Delete-1</a><a href='delete.php?id=".$subject['SUBJECT_ID']."&rolee=subject2&tab=manage-subjects' class='delete-btn'>Delete-2</a></td>

                        }
                        
                    ?>
                        
                    </tbody>
                </table>
            </div>

            <div id="manage-teachers" class="tab-content">
                <a href="addTeachers.php?tab=manage-teachers" class="new-btn">Add New</a>
                <div style="height: 20px; width: 100%;"></div>
                <table>
                    <thead>
                        <tr>
                            
                            <th>User Name</th>
                            <th>Teacher Name</th>
                            <th>Email</th>
                            <th>Department</th>      
                            <th>Joining Date</th>
                            <th>Phone No</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $sql="SELECT * FROM users WHERE ROLEE=2 AND STATUSS='ACTIVE'";
                        $teachers=mysqli_query($dbcon,$sql);
                        if($teachers){
                            $rowCount=mysqli_num_rows($teachers);
                            for($i=0;$i<$rowCount;$i++){
                                $row=mysqli_fetch_array($teachers);
                                $key=$row['USER_ID'];
                                $sql2="SELECT * FROM teachers where USER_ID=$key";
                                $data=mysqli_query($dbcon,$sql2);
                                if($data){
                                    $person=mysqli_fetch_array($data);
                                }
                                echo "<tr>
                                        <td>".$row['USER_NAME']."</td>
                                        <td>".$person['NAMEE']."</td>
                                        <td>".$row['EMAIL']."</td>
                                        <td>".$person['DEPARTMENT']."</td>
                                        <td>".$person['JOINING_DATE']."</td>
                                        <td>".$person['PHONE_NO']."</td>
                                        <td class='action-btn'><a href='update_teacher.php?id=".$key."&tab=manage-teachers' class='update-btn'>Update</a>
                                                           <a href='delete.php?id=".$row['USER_ID']."&rolee=teacher&tab=manage-teachers' class='delete-btn' onclick='return confirmDelete()'>Delete</a>
                                        </td>
                                        
                                    </tr>";
                            }
                        }
                        
                    ?>
                        
                    </tbody>
                </table>
            </div>

            <div id="manage-batches" class="tab-content">
                <table>
                    <thead>
                        <tr>
                            
                            <th>Batch</th>
                            <th>Class</th>
                            <th>Sem-1</th>
                            <th>Sem-2</th>
                            <th>Sem-3</th>
                            <th>Sem-4</th>
                            <th>Sem-5</th>
                            <th>Sem-6</th>
                            <th>Sem-7</th>
                            <th>Sem-8</th>
                            <!-- <th></th> -->
                        </tr>
                    </thead>
                    <tbody>

                    <?php
                        $sql="SELECT * FROM batches order by YEARR DESC";
                        $batches=mysqli_query($dbcon,$sql);
                        if($batches){
                            $rowCount=mysqli_num_rows($batches);
                            for($i=0;$i<$rowCount;$i++){
                                $row=mysqli_fetch_array($batches);

                                echo "<tr>
                                        <td>".$row['YEARR']."</td>
                                        <td>".$row['CLASS']."</td>";

                                        if($row['SEMESTER_1']==0){
                                            echo "<td><a href='updateAccess.php?id=".$row['BATCH_ID']."&access=1&semester=SEMESTER_1&tab=manage-batches' class='accessAllow-btn'>Give Access</a></td>"; 
                                        }else{
                                            echo "<td><a href='updateAccess.php?id=".$row['BATCH_ID']."&access=0&semester=SEMESTER_1&tab=manage-batches' class='accessDeny-btn'>Deny Access</a></td>";
                                        }

                                        if($row['SEMESTER_2']==0){
                                            echo "<td><a href='updateAccess.php?id=".$row['BATCH_ID']."&access=1&semester=SEMESTER_2&tab=manage-batches' class='accessAllow-btn'>Give Access</a></td>"; 
                                        }else{
                                            echo "<td><a href='updateAccess.php?id=".$row['BATCH_ID']."&access=0&semester=SEMESTER_2&tab=manage-batches' class='accessDeny-btn'>Deny Access</a></td>";
                                        }

                                        if($row['SEMESTER_3']==0){
                                            echo "<td><a href='updateAccess.php?id=".$row['BATCH_ID']."&access=1&semester=SEMESTER_3&tab=manage-batches' class='accessAllow-btn'>Give Access</a></td>"; 
                                        }else{
                                            echo "<td><a href='updateAccess.php?id=".$row['BATCH_ID']."&access=0&semester=SEMESTER_3&tab=manage-batches' class='accessDeny-btn'>Deny Access</a></td>";
                                        }

                                        if($row['SEMESTER_4']==0){
                                            echo "<td><a href='updateAccess.php?id=".$row['BATCH_ID']."&access=1&semester=SEMESTER_4&tab=manage-batches' class='accessAllow-btn'>Give Access</a></td>"; 
                                        }else{
                                            echo "<td><a href='updateAccess.php?id=".$row['BATCH_ID']."&access=0&semester=SEMESTER_4&tab=manage-batches' class='accessDeny-btn'>Deny Access</a></td>";
                                        }

                                        if($row['SEMESTER_5']==0){
                                            echo "<td><a href='updateAccess.php?id=".$row['BATCH_ID']."&access=1&semester=SEMESTER_5&tab=manage-batches' class='accessAllow-btn'>Give Access</a></td>"; 
                                        }else{
                                            echo "<td><a href='updateAccess.php?id=".$row['BATCH_ID']."&access=0&semester=SEMESTER_5&tab=manage-batches' class='accessDeny-btn'>Deny Access</a></td>";
                                        }

                                        if($row['SEMESTER_6']==0){
                                            echo "<td><a href='updateAccess.php?id=".$row['BATCH_ID']."&access=1&semester=SEMESTER_6&tab=manage-batches' class='accessAllow-btn'>Give Access</a></td>"; 
                                        }else{
                                            echo "<td><a href='updateAccess.php?id=".$row['BATCH_ID']."&access=0&semester=SEMESTER_6&tab=manage-batches' class='accessDeny-btn'>Deny Access</a></td>";
                                        }

                                        if($row['SEMESTER_7']==0){
                                            echo "<td><a href='updateAccess.php?id=".$row['BATCH_ID']."&access=1&semester=SEMESTER_7&tab=manage-batches' class='accessAllow-btn'>Give Access</a></td>"; 
                                        }else{
                                            echo "<td><a href='updateAccess.php?id=".$row['BATCH_ID']."&access=0&semester=SEMESTER_7&tab=manage-batches' class='accessDeny-btn'>Deny Access</a></td>";
                                        }

                                        if($row['SEMESTER_8']==0){
                                            echo "<td><a href='updateAccess.php?id=".$row['BATCH_ID']."&access=1&semester=SEMESTER_8&tab=manage-batches' class='accessAllow-btn'>Give Access</a></td>"; 
                                        }else{
                                            echo "<td><a href='updateAccess.php?id=".$row['BATCH_ID']."&access=0&semester=SEMESTER_8&tab=manage-batches' class='accessDeny-btn'>Deny Access</a></td>";
                                        }

                                    // echo "<td class='action-btn'><a href='delete.php?id=".$row['BATCH_ID']."&rolee=batch&tab=manage-batches' class='delete-btn'>Delete</a></td>";
                                        
                                echo "</tr>";

                            }
                        }
                        
                    ?>
                
                    </tbody>
                </table>
            </div>

            <div id="view-calendar" class="tab-content">
                <div class="calendar-container">
                    <!-- Calendar navigation -->
                    <div class="navigation">
                        <a href="?month=<?php echo $prevMonth; ?>&year=<?php echo $prevYear; ?>&tab=view-calendar">Previous</a>
                        <h2><?php echo $monthName . ' ' . $year; ?></h2>
                        <a href="?month=<?php echo $nextMonth; ?>&year=<?php echo $nextYear; ?>&tab=view-calendar">  Next  </a>
                    </div>

                    <table>
                        <tr>
                            <?php foreach ($dayNames as $day): ?>
                                <th><?php echo $day; ?></th>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <?php
                            for ($i = 0; $i < $firstDayOfWeek; $i++) {
                                echo '<td class="empty"></td>';
                            }

                            for ($day = 1; $day <= $daysInMonth; $day++) {
                                $today = ($day == date('j') && $month == date('m') && $year == date('Y')) ? 'today' : '';

                                $currentDate = "$year-$month-".str_pad($day, 2, "0", STR_PAD_LEFT);

                                echo "<td class='$today'>$day";

                                // Display events for the current date
                                if (isset($events[$currentDate])) {
                                    echo '<div class="events">';
                                    foreach ($events[$currentDate] as $event) {
                                        echo "<div>$event</div>";
                                    }
                                    echo '</div>';
                                }

                                echo "</td>";

                                if (($day + $firstDayOfWeek) % 7 == 0) {
                                    echo '</tr><tr>';
                                }
                            }

                            $remainingDays = (7 - (($daysInMonth + $firstDayOfWeek) % 7)) % 7;
                            for ($i = 0; $i < $remainingDays; $i++) {
                                echo '<td class="empty"></td>';
                            }
                            ?>
                        </tr>
                    </table>

                    <!-- Form to Add Events -->
                    <form method="POST" action="?tab=view-calendar">
                        <h3>Add Event</h3>
                        <input type="date" name="date" required>
                        <input type="text" name="title" placeholder="Event Title" required>
                        <input type="submit" name="add_event" value="Add Event">
                    </form>
                </div>
            </div>
            <!-- Add more sections as needed -->
        </main>
    </div>
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="script.js"></script> -->
</body>
<script>
function confirmDelete() {
    return confirm("Are you sure you want to delete this teacher?");
}
</script>

</html>
