<?php
    $servername = "localhost";
    $database = "u873197374_titan";
    $username = "u873197374_mattias";
    $password = "";
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $database);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    if (isset($_GET['user']) && $_GET['user']) {
        $user = $_GET['user'];
        $list = array();
        
        $sql = "SELECT login.userID, login.firstname, login.lastname from friends LEFT JOIN login ON login.userID = friends.user1ID WHERE (friends.user2ID = '".$user."' AND friends.confirm = 0)";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                array_push($list, array("firstname" => $row["firstname"], "lastname" => $row["lastname"], "userID" => $row["userID"]));
            }
           
            
        }
        echo json_encode(array("results" => $list, "success" => 1));
        
        
    } else {
        echo json_encode(array('success' => 0));
    }
    $conn->close();
    exit();
?>