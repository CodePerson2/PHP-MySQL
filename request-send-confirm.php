<?php
    $servername = "localhost";
    $database = "u873197374_titan";
    $username = "u873197374_mattias";
    $password = "";
    // Create connection
    $mysqli = new mysqli($servername, $username, $password, $database);
        if(!$mysqli){ 
            die("ERROR: Could not connect. " 
                    . $mysqli->connect_error); 
        } 
        if($confirm_request == true){
            $sql = "UPDATE friends SET confirm = 1 WHERE (user1ID = ".$friendID." AND user2ID = ".$userID.")";
            
        }
        if($send_request == true){
            $sql = "INSERT INTO friends (user1ID, user2ID) 
            VALUES ('".$userID."', '".$friendID."')";
            
        }
        
        if($mysqli->query($sql) === true){ 
            if($confirm_request == true)
            {
                include "makeFriendChat.php";
            } 
        } else{ 
            echo json_encode(array("success" => 0, "reason" => "error occurred" . $confirm_request));
            exit();
        } 
        
        $mysqli->close();
        
?>