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
    
    if (isset($_GET['email']) && $_GET['email'] && isset($_GET['password']) && $_GET['password']) {
        $email = $password = $userID = "";
        $firstname = $lastname = "";
        
        $pass = false;
        $email = $_GET["email"];
        $password = $_GET["password"];
        $sql = "SELECT userID, email, password, firstname, lastname from login";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                if($email == $row["email"] and password_verify($password, $row["password"])){
                    $firstname = $row["firstname"];
                    $lastname = $row["lastname"];
                    $userID = $row["userID"];
                    $pass = true;
                    break;
                }
            }
        }
        echo json_encode(array("firstname" => $firstname, "lastname" => $lastname, "password" => $pass, "userID" => $userID));
        
    } else {
        echo json_encode(array('success' => 0));
    }
    exit();
?>