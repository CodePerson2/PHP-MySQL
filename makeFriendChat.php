<?php
    $servername = "localhost";
    $database = "u873197374_titan";
    $username = "u873197374_mattias";
    $password = "";
    // Create connection
    $mysqli = new mysqli($servername, $username, $password, $database);
        if(!$mysqli)
        { 
            die("ERROR: Could not connect. " 
                    . $mysqli->connect_error); 
        }
        
        $userName = '';
        $friendName = '';
        
        $sql_names = "SELECT userID, firstname, lastname FROM login WHERE (userID = ".$userID." OR userID = ".$friendID.")";
        $result = $mysqli->query($sql_names);
    
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                if($userID == $row["userID"]){
                    $userName = $row["firstname"] . ' ' . $row["lastname"];
                }
                if($friendID == $row["userID"]){
                    $friendName = $row["firstname"] . ' ' . $row["lastname"];
                }
            }
        }
        
        
        $sql = "INSERT INTO chatGroup (name) 
        VALUES (0000)";
        
        if($mysqli->query($sql) === true)
        { 
            $newGroupId = $mysqli->insert_id;

            $sql = "INSERT INTO userChatGroup (userID, groupID, friend_chat, friend_name) 
            VALUES (".$friendID.", ".$newGroupId.", 1, '".$userName."'), (".$userID.", ".$newGroupId.", 1, '".$friendName."')";
        
            if($mysqli->query($sql) === true)
            {
                     
                echo json_encode(array("success" => 1, "reason" => "chats created"));
                exit();
            }
                
            else
            {
                echo json_encode(array("success" => 0, "reason" => "$mysqli->error"));
                exit();    
            }
            
        } 
        else
        { 
            echo json_encode(array("success" => 0, "reason" => "error occurred"));
            exit();
        } 
        
        $mysqli->close();
        
?>