<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "studentportal";

    //server database connection
    //$servername = "localhost";
    //$username = "id20210082_ace";
    //$password = "]W~W0+uV]-zg/h2H";
    //$dbname = "id20210082_studentportal";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
