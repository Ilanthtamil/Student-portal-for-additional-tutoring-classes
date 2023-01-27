<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("location: ../auth/logout.php");
}
$role = $_SESSION["user"]["role"];


$subject_id = NULL;


require_once("./database/open-connection.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>ACE Tuition Portal</title>
    <link rel="stylesheet" href="./css/discussion-forum-styles.css" />
    <!-- Font Awesome Cdn Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <header class="header">
        <div class="logo">
            <img src="./images/ace logo.png" width="40" height="50" alt="">

            <a href="main.php">ACE Tuition</a>
            <div class="search_box">
                <input type="text" placeholder="Search ">
                <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
            </div>
        </div>

        <div class="header-icons">
            <i class="fas fa-bell"></i>
            <div class="account">
                <img src="https://img.freepik.com/premium-vector/graduate-student-avatar-student-student-icon-flat-design-style-education-graduation-isolated-student-icon-white-background-vector-illustration-web-application-printing_153097-1566.jpg" alt="">
                <h4><?php echo $_SESSION["user"]["name"]; ?></h4>
            </div>
        </div>
    </header>
    <div class="container">
        <nav>
            <div class="side_navbar">
                <span>Main Menu</span>
                <a href="main.php" class="active">Home</a>
                <a href="attendance.php">Attendance</a>
                <a href="uploadzone.php">Upload and Download</a>
                <a href="quiz.php">Quiz</a>
                <a href="discussion-forum.php">Discussion Forum</a>
                <a href="./auth/logout.php">Logout <i class="fa-solid fa-right-from-bracket"></i></a>
            </div>
        </nav>

        <div style="background-color: #fff; width: 80%; height: 100%; padding: 1em;">
            <h1>Attendance</h1>
            <br>
            <div>
        
        <form method="post" action="attendance.php">
            <label for="attendance_id">Enter Attendance ID:</label>
            <input type="text" name="attendance_id" id="attendance_id">
            <br>
            <label for="date">Select Date:</label>
            <input type="date" name="date" id="date">
            <br>
            <label for="time_start">Select Time Start:</label>
            <input type="time" name="time_start" id="time_start">
            <br>
            <label for="time_end">Select Time End:</label>
            <input type="time" name="time_end" id="time_end">
            <br>
            <label for="subject">Select subject:</label>
            <select type="text" name="subject" id="subject">
                <?php
                   
                    // Retrieve all subjects from the database
                    $query = "SELECT * FROM subject";
                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                    // Output each subject as an option in the select menu
                    echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                    }
                ?>
            </select>
            <br>
            <label for="presence">Enter Presence:</label>
            <input type="text" name="presence" id="presence">
            
            <br>
            <button name="add-btn" class="add-btn" type="submit">Add</button>
        </form>
        

        </body>
<?php
// PHP program to pop an alert
// message box on the screen
  
// Function definition
function function_alert($message) {
      
    // Display the alert box 
    echo "<script>alert('$message');</script>";
}
  
  
// Function call
//function_alert("Welcome to Geeks for Geeks");
  
?>

<?php
$sql = "SELECT * FROM attendance";
$result = mysqli_query($conn, $sql);

// Check if the query returned any rows
if (mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr>";
    echo "<th>No.</th>";
    echo "<th>Date</th>";
    echo "<th>Time start</th>";
    echo "<th>Time end</th>";
    echo "<th>Subject</th>";
    echo "<th>Presence</th>";
    echo "</tr>";
    // Output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["attendance_id"]. "</td>";
        echo "<td>" . $row["date"]. "</td>";
        echo "<td>" . $row["time_start"]. "</td>";
        echo "<td>" . $row["time_end"]. "</td>";
        echo "<td>" . $row["subject"]. "</td>";
        echo "<td>" . $row["presence"]. "</td>";
        //echo "<td><button class='delete-btn' data-attendance-id='" . $row["attendance_id"] . "'>Delete</button></td>";
        echo "</tr>";

        
    }
    echo "</table>";
} else {
    echo "0 results";
}
?>

<form method="post" action="attendance.php">
            <label for="attendance_id">Enter Attendance ID to delete:</label>
            <input type="text" name="attendance_id" id="attendance_id">
            <button name="dlt-btn" class="dlt-btn" type="submit">Delete</button>
</form>

<?php
if(isset($_POST["add-btn"])&&($role === "Teacher")){

    $attendance_id = $_POST['attendance_id'];
    $date = $_POST['date'];
    $time_start = $_POST['time_start'];
    $time_end = $_POST['time_end'];
    $subject = $_POST['subject'];
    $presence = $_POST['presence'];
   
    $sql = "INSERT INTO attendance (attendance_id, date, time_start, time_end, subject, presence)
    VALUES ('$attendance_id', '$date', '$time_start', '$time_end','$subject','$presence')";
      
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    header("Location: ".$_SERVER['PHP_SELF']);
    
}
?>

<?php
if(isset($_POST["dlt-btn"])&&($role === "Teacher")){
    $attendance_id = $_POST['attendance_id'];
    $sql = "DELETE FROM attendance WHERE attendance_id = $attendance_id;";
    
    if ($conn->query($sql) === TRUE) {
        echo "Deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

   //header("Location: ".$_SERVER['PHP_SELF']);
}
?>
</html>