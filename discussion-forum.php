<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("location: ../auth/logout.php");
}

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
            <h1>Forum</h1>
            <br>
            <div>
                <p>Choose A Subject: </p>
                <form action="discussion-forum.php" method="POST">
                    <?php


                    // prepare and bind
                    $stmt = $conn->prepare("SELECT * FROM `subject`;");

                    // execute the statements
                    $stmt->execute();

                    // get the results
                    $result = $stmt->get_result();

                    echo "<select name='subject' class='subject' style='width: 12em; height: 3em; background-color: aqua; border-radius: 0.625em; padding-left: 0.3em;'>";
                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <option value="<?php echo $row["subject_id"]; ?>"><?php echo $row["name"]; ?></option>
                    <?php
                    }
                    echo "</select>";

                    ?>
                    <button name="subject-btn" class="subject-btn" type="submit">Open Forum</button>
                </form>
            </div>

            <br>

            <?php
            if (isset($_POST["subject-btn"])) {
                $subject_id = $_POST["subject"];

                if (!(strlen($subject_id) > 0)) {
                    echo "<script>alert('Choose a subject.');</script>";
                } else {

                    // prepare and bind
                    $stmt = $conn->prepare("SELECT f.chat_discussions, f.`timestamp`, t.name AS teacher_name, s.name AS student_name FROM forum f LEFT JOIN teacher t ON f.teacher_id=t.teacher_id LEFT JOIN student s ON f.student_id=s.student_id WHERE f.subject_id=? ORDER BY f.`timestamp` ASC;");
                    $stmt->bind_param("i", $subject_id);

                    // execute the statements
                    $stmt->execute();

                    // get the results
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        echo '<div class="forum-container">
                            <h2>Discussions</h2>
                            <div class="forum">';
                        while ($row = $result->fetch_assoc()) {
                            echo '<br>
                            <div class="discussions" style="height: 100%; display: block;">
                                    <div style="background-color: #6969d329; width: 100%; border-radius: 0.625em; display: flex; align-items: center; padding: 1em;">';

                            if ($row["student_name"] == NULL) {
                                echo '<img src="./images/teacher-avatar.png" width="30" alt="Teacher Image."><p style="display: inline-block;margin-left: 1em;">' . $row["teacher_name"] . ' (Teacher)</p>';
                            } else if ($row["teacher_name"] == NULL) {
                                echo '<img src="./images/student-avatar.png" width="30" alt="Student Image."><p style="display: inline-block;margin-left: 1em;">' . $row["student_name"] . ' (Student)</p>';
                            }

                            echo '</div>
                                <div style="margin-left: 2em; margin-top: -0.5em;"><i class="fa-solid fa-turn-down fa-2x"></i></div>
                                <div style="background-color: #6969d329; width: 100%; border-radius: 0.625em; display: flex; align-items: center; padding: 1em; margin-top: -0.4em;">
                                    <p>' . $row["chat_discussions"] . '</p>
                                </div>
                            </div>';
                        }
                        echo '
                        </div>
                            <br>
                            <div>
                                <form id="sample-form" style="border-radius: 0.625em;">
                                    <div style="padding: 1em; width: 100%; display: flex; align-items: center;">
                                        <textarea name="new-discussion" cols="80" rows="10" max="500" required style="border: 1px solid black; border-radius: 0.625em; padding: 1em;" class="form-data"></textarea>
                                        <input type="hidden" value="' . $subject_id . '" name="subject-id" class="form-data">
                                        <button type="button" onclick="save_data();" name="add-new-discussion-btn" id="add-new-discussion-btn" class="add-new-discussion-btn" style="padding: 1em; height: 40%; border-radius: 0.625em; background-color: purple; color: white;">Add New Discussion</button>
                                    </div>
                                </form>
                            </div>
                        </div>';
                    } else {
                        // echo "<script>alert(" . $subject_id . ");</script>";
                        echo "No data for this subject.";
                    }
                }
            }
            require_once("./database/close-connection.php");
            ?>

        </div>


    </div>
    <script>
        function save_data() {

            const form_element = document.getElementsByClassName("form-data");

            const form_data = new FormData();

            for (var count = 0; count < form_element.length; count++) {
                form_data.append(form_element[count].name, form_element[count].value);
            }

            document.getElementById("add-new-discussion-btn").disabled = true;

            var ajax_request = new XMLHttpRequest();

            ajax_request.open('POST', 'submit-discussion-forum-data.php');

            ajax_request.send(form_data);

            ajax_request.onreadystatechange = function() {

                if (ajax_request.readyState == 4 && ajax_request.status == 200) {
                    document.getElementById("add-new-discussion-btn").disabled = false;

                    document.getElementById("sample-form").reset();

                    var returned_value = ajax_request.responseText;

                    if (returned_value === 1) {
                        alert('Data has been inserted.');
                    } else if (returned_value === 2) {
                        alert('Data insertion error.');
                    }

                    location.reload();
                }
            }
        }
    </script>
</body>

</html>