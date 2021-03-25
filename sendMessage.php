<?php
    $servername = "localhost";
    $database = "u873197374_titan";
    $username = "u873197374_mattias";
    $password = "";
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $database);
    // Check connection
    if (!$conn) 
    {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    
    
    if (isset($_POST['message']) && $_POST['message'] && isset($_POST['user']) && $_POST['user'] && isset($_POST['group']) && $_POST['group']) 
    {
        date_default_timezone_set('America/Vancouver');
        
        $sql = "INSERT INTO message (userID, groupID, message) VALUES (?,?,?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $_POST['user'], $_POST['group'], $_POST['message']);
        $result = $stmt->execute();
        
        if($result){
            $newMessageId = $stmt->insert_id;
            $time = date("D, h:ia");
            $date = date("d/m/Y");
            
            echo json_encode(array('success' => 1, 'messageID' => $newMessageId, 'reason' => 'message sent', 'date' => $date, 'time' => $time));
            $conn->close();
            exit();
        }
        else
        {
            echo json_encode(array('success' => 0, 'reason' => 'message failed to send'));
        }
        
        
    } 
    else 
    {
        echo json_encode(array('success' => 0, 'reason' => 'server error123'));
    }
    $conn->close();
    exit();
?>