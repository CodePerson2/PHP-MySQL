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
    
    function local($date, $type) {
        $datetime = DateTime::createFromFormat ( "Y-m-d H:i:s", $date );
        //$date=date_create($date);
        date_modify($datetime,"-7 hours");
        if($type == 1){return ($datetime->format("d-m-Y"));}
        else if($type == 2){return $datetime->format("D, h:ia");}
    }
    
    
    //isset($_GET['groupID']) && $_GET['groupID'] && isset($_GET['lastMessageID']) && $_GET['lastMessageID'] && isset($_GET['amount']) && $_GET['amount'] && isset($_GET['userID']) && $_GET['userID']
    
    if (isset($_GET['groupID']) && $_GET['groupID'] && isset($_GET['lastMessageID']) && $_GET['lastMessageID'] && isset($_GET['amount']) && $_GET['amount'] && isset($_GET['userID']) && $_GET['userID']) {
        $userID = $_GET['userID'];
        $groupID = $_GET['groupID'];
        $messID = $_GET['lastMessageID'];
        $amount = $_GET['amount'];
        $friend;
        $messageFound = false;
        $list = array();
        
        $sql = "SELECT message.messageID, message.message, message.userID, message.create_at, login.firstName, login.lastName from message LEFT JOIN login ON login.userID = message.userID  WHERE message.groupID = '".$groupID."' ORDER BY message.create_at DESC ";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                if($row['userID'] == $userID){
                    $friend = false;
                }
                else{
                    $friend = true;
                }
                
                if($amount == -1 && $row['messageID'] != $messID){
                    $time = local($row["create_at"], 2);
                    $date = local($row["create_at"], 1);
                    array_push($list, array("fname" => $row["firstName"], "lname" => $row["lastName"], "message" => $row["message"], "friend" => $friend, "time" => $time, "date" => $date, "messageID" => $row['messageID']));
                    $messageFound = true;
                }
                else if($amount > 0 && $row['messageID'] != $messID)
                {
                    $time = local($row["create_at"], 2);
                    $date = local($row["create_at"], 1);
                   array_push($list, array("fname" => $row["firstName"], "lname" => $row["lastName"], "message" => $row["message"], "friend" => $friend, "time" => $time, "date" => $date, "messageID" => $row['messageID']));
                   $amount--;
                   $messageFound = true;
                }
                else if($row['messageID'] <= $messID){
                    break;
                }
                
            }
           
            
        }
        else{
            echo json_encode(array('success' => 0, 'error' => 'no results'));
            $conn->close();
            exit();
        }
        if($messageFound)echo json_encode(array("results" => $list, "success" => 1, "groupID" => $groupID, "amount" => $amount, "messID" => $messID));
        else echo json_encode(array('success' => 0, 'error' => "no new messages" . $results -> connect_error));
        
        
    } 
    else {
        echo json_encode(array('success' => 0, 'error' => "error3: " . $results -> connect_error));
    }
    $conn->close();
    exit();
?>