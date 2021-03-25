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
    
    if (isset($_GET['search']) && $_GET['search']) {
        $search = '';
        $userfound = false;
        $search = strtolower($_GET["search"]);
        
        $sql = "SELECT userID, firstname, lastname from login";
        $db = $conn->query($sql);
        $result = array();
        
        if ($db->num_rows > 0) {
            // output data of each row
            while($row = $db->fetch_assoc()) {
                if(($search == strtolower($row["firstname"])) or ($search == strtolower($row["lastname"]))){
                    array_push($result, array("firstname" => $row["firstname"], "lastname" => $row["lastname"], "userID" => $row["userID"]));
                    $userfound = true;
                }
            }
        }
        echo json_encode(array("results" => $result, "success" => $userfound));
        $conn->close();
        
    } else {
        echo json_encode(array('success' => 0, "results" => $result));
    }
    exit();
?>