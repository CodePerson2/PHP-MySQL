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

    if (isset($_POST['friend']) && $_POST['friend'] && isset($_POST['user']) && $_POST['user']) {
        $friendID = $_POST['friend'];
        $userID = $_POST['user'];

        
        $sql = "DELETE FROM friends WHERE (user1ID = ".$friendID." AND user2ID = ".$userID.")";
        
        
        if ($conn->query($sql) === TRUE) 
        {
          echo json_encode(array('success' => 1, 'reason' => "request deleted successfully"));
        } 
        else 
        {
          echo json_encode(array('success' => 0, 'reason' => "Error deleting request: " . $conn->error));
        }
                
        
    } else {
        echo json_encode(array('success' => 0));
    }
    exit();
?>