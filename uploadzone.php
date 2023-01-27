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
            <h1>Upload and Download Zone</h1>
            <br>
            <div>

            <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>upload</title>
</head>
<body>
   
   <?php
    if(isset($_POST['submit'])){
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $path = "files/".$fileName;
        
        $query = "INSERT INTO files(filename) VALUES ('$fileName')";
        $run = mysqli_query($conn,$query);
    
        if($run){
            move_uploaded_file($fileTmpName,$path);
            echo "success";
        }
        else{
            echo "error".mysqli_error($conn);
        }
        
    }
    
    ?>

   <table border="1px" align="center">
       <tr>
           <td>
               <form action="uploadzone.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="file">
                    <button type="submit" name="submit"> Upload</button>
                </form>
           </td>
       </tr>
       <tr>
           <td>
              <?php
        
               $query2 = "SELECT * FROM files ";
               $run2 = mysqli_query($conn,$query2);
    
               while($rows = mysqli_fetch_assoc($run2)){
                   ?>
                
                   <p><?php echo $rows['filename'] ?></p>
               <a href="Download.php?file=<?php echo $rows['filename'] ?>">Download</a><br>
               <?php
               }
               ?>
           </td>
       </tr>
   </table>
    
</body>
</html>