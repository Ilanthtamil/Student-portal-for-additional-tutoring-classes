<?php
    session_start();
    require_once("./database/open-connection.php");

    $new_discussion = $_POST["new-discussion"];
    $subject_id = $_POST["subject-id"];
    $user_id = $_SESSION["user"]["id"];
    $role = $_SESSION["user"]["role"];

    // echo $new_discussion . " " . $subject_id . " " . $user_id . " " . $role;
    // exit(0);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        
        if ($role === "Student") {
            $sql = "INSERT INTO forum(chat_discussions, subject_id, student_id, teacher_id, `timestamp`) VALUES ('$new_discussion', $subject_id, $user_id, NULL, NOW())";
        } else {
            $sql = "INSERT INTO forum(chat_discussions, subject_id, student_id, teacher_id, `timestamp`) VALUES ('$new_discussion', $subject_id, NULL, $user_id, NOW())";
        }

        if ($conn->query($sql) === TRUE) {
            echo 1;
        } else {
            echo 2;
        }

        $conn->close();
    }
