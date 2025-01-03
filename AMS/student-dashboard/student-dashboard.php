<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Check if 'id' is set in the URL and handle cases where it's missing
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

    $_SESSION["T1"]=null;
    $_SESSION["T2"]=null;

    $dbcon = mysqli_connect("localhost", "root", "", "AMS");

    $sql="SELECT * FROM users WHERE USER_ID='$userid'";
    $user=mysqli_query($dbcon,$sql);
    if($user){
        $user_row=mysqli_fetch_array($user);
        $_SESSION["ROLLNO"]=$user_row['USER_NAME'];
    }

    // Fetch teacher details using 'USER_ID'
    $sql = "SELECT * FROM students WHERE USER_ID='$userid'";
    $student = mysqli_query($dbcon, $sql);

    if ($student && mysqli_num_rows($student) > 0) {
        $student_row = mysqli_fetch_array($student);
        $_SESSION['STUDENT_ID'] = $student_row['STUDENT_ID'];
        $_SESSION['CLASS_NAME'] = $student_row['CLASS_NAME'];
        $_SESSION["BATCH_ID"] = $student_row['BATCH_ID'];
        $_SESSION["NAMEE"] = $student_row['NAMEE'];
    } else {
        echo "Student not found!";
        exit;
    }

    $sql="SELECT * FROM batches WHERE BATCH_ID='$student_row[BATCH_ID]'";
    $batch=mysqli_query($dbcon,$sql);
    if($batch){
        $batch_row=mysqli_fetch_array($batch);
        $_SESSION["BATCH_YEAR"] =(int) $batch_row['YEARR'];
    }

    //current semester 
    if($batch_row['SEMESTER_8']==1){
        $current_sem=8;
    }else if($batch_row['SEMESTER_7']==1){
        $current_sem=7;
    }else if($batch_row['SEMESTER_6']==1){
        $current_sem=6;
    }else if($batch_row['SEMESTER_5']==1){
        $current_sem=5;
    }else if($batch_row['SEMESTER_4']==1){
        $current_sem=4;
    }else if($batch_row['SEMESTER_3']==1){
        $current_sem=3;
    }else if($batch_row['SEMESTER_2']==1){
        $current_sem=2;
    }else{
        $current_sem=1;
    }
    
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
    
    // Get current day and date
    $currentDay = date('l');  // e.g., "Monday"
    $currentDate = date('F j, Y');  // e.g., "October 11, 2024"
}

// Add event
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
    <title>Student Dashboard</title>
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
        
    </STYLE>
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
                
                <?php
                    for($i=1;$i<=6;$i++){
                        echo "<li><a href='#semester".$i."'>Semester ".$i."</a></li>";
                    }
                    if($_SESSION["BATCH_YEAR"]>2023){
                        echo "<li><a href='#semester7'>Semester 7</a></li>";
                        echo "<li><a href='#semester8'>Semester 8</a></li>";
                    }
                ?>
                <li><a href="#view-calendar">Calendar</a></li>
                
            </ul>
            <a href="logout.php" class="logout-btn">Logout</a>
            
        </aside>
        <main class="content">
            <!-- Content will be dynamically loaded here -->
            <div id="overview" class="tab-content">
                <header class="header">
                    <h1>Welcome, <?php echo $student_row['NAMEE']; ?> !</h1>
                </header>
                <div class="overview-cards">
                    <div class="card total-users">
                        <h3>Department</h3>
                        <p><?php echo $student_row['CLASS_NAME']; ?></p>
                    </div>
                    <div class="card learning-time">
                        <h3>Current semester</h3>
                        <p><?php echo $current_sem; ?></p>
                    </div>
                    <div class="card total-contents">
                        <div style="height:15px;"></div>
                        <p><?php echo $_SESSION["ROLLNO"]; ?></p>
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

            <!-- Semester -->
            <?php

                for($i=1;$i<=6;$i++){

                    echo "<div id='semester".$i."' class='tab-content'>
                            <div class='panel-container'>";

                    // Check if the SEMESTER_$i exists in the fetched batch row
                    if(isset($batch_row['SEMESTER_'.$i]) && (int) $batch_row['SEMESTER_'.$i]==1){

                        // Fetch subjects for the current semester
                        $sql="SELECT * FROM subjects WHERE SEMESTER='$i' AND CLASS_NAME='BCA'";
                        $subjects=mysqli_query($dbcon,$sql);
                        
                        // Error handling for subjects query
                        if(!$subjects){
                            echo "<div class='panel'>
                                    <h4>Error fetching subjects for Semester - $i</h4>
                                </div>";
                        } else {
                            $sub_count=mysqli_num_rows($subjects);
                            if($sub_count>0){
                                for($j=0;$j<$sub_count;$j++){
                                    $sub_row=mysqli_fetch_array($subjects);
                                    echo "<div class='panel'>
                                            <h4>".$sub_row['SUBJECT_NAME']."</h4>
                                            <div style='height: 20px; width: 100%;'></div>
                                            <a href='modules.php?id=".$sub_row['SUBJECT_ID']."&subject=".$sub_row['SUBJECT_NAME']."'>View Subject</a>
                                        </div>";
                                }
                            } else {
                                echo "<div class='panel'>
                                        <h4>No subjects added for Semester - $i</h4>
                                    </div>";
                            }
                        }
                    } else {
                        echo "<div class='panel'>
                                <h4>Semester - $i not permitted or not set</h4>
                            </div>";
                    }

                    echo "</div></div>";


                    //TO HERE.
                
                }
            ?>
        
            
            
            

        
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
</html>
