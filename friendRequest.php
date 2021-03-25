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
    
    function sendFriendrequest($userID, $friendID){
        $send_request = true;
        include 'request-send-confirm.php';
        echo json_encode(array("success" => 1, "reason" => "request sent"));
        exit();
    }
    
    if (isset($_POST['friend']) && $_POST['friend'] && isset($_POST['user']) && $_POST['user']) {
        $confirm_request = false;
        $send_request = false;
        $friendID = $_POST['friend'];
        $userID = $_POST['user'];
        
        #make this code the same as add friend from request
        
        $sql = "SELECT user1ID, user2ID, confirm from friends";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                if(($friendID == $row["user1ID"] || $userID == $row["user1ID"]) && ($userID == $row["user2ID"] || $friendID == $row["user2ID"]) && $row["confirm"] == 1){
                    echo json_encode(array('success' => 0, 'reason' => 'already friends'));
                    exit();
                }
                if($userID == $row["user1ID"] && $friendID == $row["user2ID"] && $row["confirm"] == 0){
                    echo json_encode(array('success' => 0, 'reason' => 'request already sent'));
                    exit();
                }
                if($userID == $row["user2ID"] && $friendID == $row["user1ID"] && $row["confirm"] == 0){
                    $confirm_request = true;
                    include 'request-send-confirm.php';
                    echo json_encode(array("success" => 1, "reason" => "friends made"));
                    exit();
                    
                }
            }
        }
        sendFriendrequest($userID, $friendID);
        
        
    } else {
        echo json_encode(array('success' => 0));
    }
    exit();
?>