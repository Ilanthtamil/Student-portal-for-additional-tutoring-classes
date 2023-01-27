<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Login Form</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <div class="box">
        <form autocomplete="off" method="post" action="./index.php">
            <h2>Sign in</h2>
            <div class="inputBox">
                <input type="number" required="required" name="user-id" />
                <span>User ID</span>
                <i></i>
            </div>
            <div class="inputBox">
                <input type="password" required="required" name="password" />
                <span>Password</span>
                <i></i>
            </div>
            <br>
            <div class="student-type">
                <select name="student-type">
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                </select>
            </div>
            <div class="links">
                <a href="#">Forgot Password ?</a>
                <a href="#">Signup</a>
            </div>
            <button class="login-btn" type="submit" name="login">Login</button>

            <p style="background-image: url('ace logo.jpg')"></p>
        </form>
    </div>

    <?php
    if (isset($_POST["login"])) {
        $user_id = $_POST["user-id"];
        $password = $_POST["password"];
        $student_type = $_POST["student-type"];
        // echo "<script>alert(" . $student_type . "');</script>";

        if (!(strlen($user_id) > 0) || !(strlen($user_id) <= 5)) {
            echo "<script>alert('Enter a valid user ID.')</script>";
        } else {
            if (!(strlen($password) > 0) || !(strlen($password) <= 50)) {
                echo "<script>alert('Enter a valid password.')</script>";
            } else {
                if ($student_type !== "student" && $student_type !== "teacher") {
                    echo "<script>alert('Enter a valid student type.')</script>";
                } else {
                    require_once("../database/open-connection.php");

                    if ($student_type === "student") {
                        // prepare and bind
                        $stmt = $conn->prepare("SELECT * FROM student WHERE student_id=? LIMIT 1");
                        $stmt->bind_param("i", $studentID);

                        // pass as parameters
                        $studentID = $user_id;
                        // execute the statements
                        $stmt->execute();

                        // get the results
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {

                            $row = $result->fetch_assoc();

                            session_start();

                            $_SESSION["user"]["id"] = $user_id;
                            $_SESSION["user"]["name"] = $row["name"];
                            $_SESSION["user"]["role"] = "Student";

                            require_once("../database/close-connection.php");

                            header("location: ../main.php");
                        } else {
                            require_once("../database/close-connection.php");

                            echo "<script>alert('The student you entered is not in the database.');</script>";
                        }
                    } else if ($student_type === "teacher") {
                        // prepare and bind
                        $stmt = $conn->prepare("SELECT * FROM teacher WHERE teacher_id=? LIMIT 1");
                        $stmt->bind_param("i", $teacherID);

                        // pass as parameters
                        $teacherID = $user_id;
                        // execute the statements
                        $stmt->execute();

                        // get the results
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {

                            $row = $result->fetch_assoc();

                            session_start();

                            $_SESSION["user"]["id"] = $user_id;
                            $_SESSION["user"]["name"] = $row["name"];
                            $_SESSION["user"]["role"] = "Teacher";

                            require_once("../database/close-connection.php");

                            header("location: ../main.php");
                        } else {
                            require_once("../database/close-connection.php");

                            echo "<script>alert('The admin you entered is not in the database.');</script>";
                        }
                    }
                }
            }
        }
    }
    ?>
</body>

</html>