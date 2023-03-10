<?php
session_start();

if (!isset($_SESSION["user"])) {
  header("location: ../auth/logout.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>ACE Tuition Portal</title>
  <link rel="stylesheet" href="style.css" />
  <!-- Font Awesome Cdn Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
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
        <a href="uploadzone.php">Upload zone</a>
        <a href="quiz.php">Quiz</a>
        <a href="discussion-forum.php">Discussion Forum</a>
        <a href="./auth/logout.php">Logout <i class="fa-solid fa-right-from-bracket"></i></a>

        <!---
        <div class="links">
          <span>Quick Link</span>
          <a href="#">Test</a>
          <a href="#">Assignment</a> 
          
        </div>--->
      </div>
    </nav>

    <div class="main-body">
      <h2>Dashboard</h2>
      <div class="promo_card">
        <h1>Welcome to ACE Tuition</h1>
        <span>A Journey to Excellence.</span>
        <button>Learn More</button>
      </div>

      <div class="history_lists">
        <div class="list1">
          <div class="row">
            <h4>History</h4>
            <a href="#">See all</a>
          </div>
          <table>
            <thead>
              <tr>
                <th>#</th>
                <th>Due Dates</th>
                <th>Lecturer Name</th>
                <th>Course Type</th>
                <th>Type</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>2, Aug, 2022</td>
                <td>Sam </td>
                <td>Programming</td>
                <td>Quiz</td>
              </tr>
              <tr>
                <td>2</td>
                <td>29, July, 2022</td>

                <td>Sam</td>
                <td>Programming</td>
                <td>Exercise</td>
              </tr>
              <tr>
                <td>3</td>
                <td>15, July, 2022</td>

                <td>Ronaldo</td>
                <td>English</td>
                <td>Quiz</td>
              </tr>
              <tr>
                <td>4</td>
                <td>5, July, 2022</td>
                <td>Leo Messi</td>
                <td>Science</td>
                <td>Forum</td>
              </tr>
              <tr>
                <td>5</td>
                <td>29, June, 2022</td>
                <td>Ronaldo</td>
                <td>English</td>
                <td>Exercise</td>
              </tr>
              <tr>
                <td>6</td>
                <td>28, June, 2022</td>
                <td>Peter Parker</td>
                <td>Mathematics</td>
                <td>Forum</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="list2">
          <div class="row">
            <h4>Attendance</h4>
            <a href="#">See all</a>
          </div>
          <table>
            <thead>
              <tr>
                <th>#</th>
                <th>Course</th>
                <th>Date</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Programming</td>
                <td>5, July, 2022</td>
                <td>2/10</td>
              </tr>
              <tr>
                <td>2</td>
                <td>Mathematics </td>
                <td>5, July, 2022</td>
                <td>3/10</td>
              </tr>
              <tr>
                <td>3</td>
                <td>English</td>
                <td>5, July, 2022</td>
                <td>9/10</td>
              </tr>
              <tr>
                <td>4</td>
                <td>English</td>
                <td>6, July, 2022</td>
                <td>2/10</td>
              </tr>
              <tr>
                <td>5</td>
                <td>Programming</td>
                <td>5, July, 2022</td>
                <td>5/10</td>
              </tr>
              <tr>
                <td>6</td>
                <td>Science</td>
                <td>5, July, 2022</td>
                <td>2/10</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="sidebar">
      <h4>Scribble Zone</h4>



    </div>
  </div>
</body>

</html>