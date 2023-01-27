<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("location: ../auth/logout.php");
}

$role=$_SESSION["user"]["role"];

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
            <h1>Quiz Exercise</h1>


            <form method="post" action="quiz.php">
            <label for="quizID">Quiz ID :</label>
            <input type="text" name="quizID" id="quizID">
            <br>
            <label for="question">Question:</label>
            <input type="text" name="question" id="question">
            <br>
            <label for="choice1">Choice 1:</label>
            <input type="text" name="choice1" id="choice1">
            <br>
            <label for="choice2">Choice 2:</label>
            <input type="text" name="choice2" id="choice2">
            <br>
            <label for="choice3">Choice 3:</label>
            <input type="text" name="choice3" id="choice3">
            <br>
            <br>
            <label for="answer">Answer:</label>
            <input type="text" name="answer" id="answer">
            <br>
            <button name="add-btn" class="add-btn" type="submit">Add</button>
        </form>


            <?php    

$sql = "SELECT * FROM quiz";
$result = mysqli_query($conn, $sql);

// Check
if (mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr>";
    echo "<th>No.</th>";
    echo "<th>Question</th>";
    echo "<th>Choice 1</th>";
    echo "<th>Choice 2</th>";
    echo "<th>Choice 3</th>";
    echo "<th>Answer</tr>";
    echo "</tr>";
    // Output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["quizID"]. "</td>";
        echo "<td>" . $row["question"]. "</td>";
        echo "<td>" . $row["choice1"]. "</td>";
        echo "<td>" . $row["choice2"]. "</td>";
        echo "<td>" . $row["choice3"]. "</td>";
        echo "<td>" .$row["answer"]. "</td>";
        echo "</tr>";
    }
    echo "</table>";

} else {
    echo "0 results";
}
?>

<?php
$sql = "SELECT * FROM quiz";
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) > 0) {
    echo "<ul>";
    // Output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "<li>";
        echo "Quiz ID: " . $row["quizID"]. "<br>";
        echo "Question: " . $row["question"]. "<br>";
        echo "Choices: <br>";
        $choices = array($row["choice1"], $row["choice2"], $row["choice3"]);
        for ($i = 0; $i < count($choices); $i++) {
            echo "<input type='radio' name='choice_".$row["quizID"]."' value='".$choices[$i]."'>".$choices[$i]."<br>";
        }
        echo "Answer: " . $row["answer"]. "<br>";
        echo "</li>";
    }
    echo "</ul>";
}

// $score = 0;

// if (mysqli_num_rows($result) > 0) {
//     while($row = mysqli_fetch_assoc($result)) {
//         $answer = $row["answer"];
//         $user_answer = $_POST["choice"];  // assume that the user's answer is submitted through a form field called "choice"

//         if ($answer == $user_answer) {
//             $score++;
//         }
//     }
// }

// echo "Total score: " . $score;


?>
<form action="submit.php" method="post">
  <ul>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
      <li>
        <?php echo "Quiz ID: " . $row["quizID"]. "<br>"; ?>
        <?php echo "Question: " . $row["question"]. "<br>"; ?>
        <?php echo "Choices: <br>"; ?>
        <?php $choices = array($row["choice1"], $row["choice2"], $row["choice3"]); ?>
        <?php for ($i = 0; $i < count($choices); $i++): ?>
          <?php echo "<input type='radio' name='choice_" . $row["quizID"] . "' value='".$choices[$i]."'>".$choices[$i]."<br>"; ?>
        <?php endfor; ?>
        <?php echo "<input type='hidden' name='answer_" . $row["quizID"] . "' value='" . $row["answer"] . "'>"; ?>
      </li>
    <?php endwhile; ?>
  </ul>
  <input type="submit" value="Submiit">
</form>


<?php
if(isset($_POST["add-btn"])&& ($role==="Teacher")){

    $quizID= $_POST['quizID'];
    $question = $_POST['question'];
    $choice1= $_POST['choice1'];
    $choice2 = $_POST['choice2'];
    $choice3 = $_POST['choice3'];
    $answer = $_POST['answer'];

    $sql = "INSERT INTO quiz (quizID, question, choice1, choice2, choice3, answer)
    VALUES ('$quizID', '$question', '$choice1', '$choice2', '$choice3', '$answer')";
      
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    //header("Location: ".$_SERVER['PHP_SELF']);
    
}
?>