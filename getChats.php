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
    
    function local($date) {
        $datetime = DateTime::createFromFormat ( "Y-m-d H:i:s", $date );
        //$date=date_create($date);
        date_modify($datetime,"-7 hours");
        return $datetime->format("g:ia, jS M");
    }
    
    if (isset($_GET['user']) && $_GET['user']) {
        $user = $_GET['user'];
        $list = array();
        
        $sql = "SELECT DISTINCT r1.groupID, r1.friend_chat, r1.friend_name, r2.message, r2.create_at, r2.firstName, r1.name from (SELECT userChatGroup.friend_chat, userChatGroup.friend_name, userChatGroup.recent_activity,  userChatGroup.groupID, chatGroup.name from userChatGroup LEFT JOIN chatGroup ON chatGroup.groupID = userChatGroup.groupID WHERE userChatGroup.userID = 1) r1 LEFT JOIN (SELECT m.create_at, groupID, message, firstName from message m LEFT JOIN login l ON m.userID = l.userID where m.create_at=(SELECT MAX(create_at) FROM message WHERE groupID = m.groupID)) r2 ON (r1.groupID = r2.groupID) order by r2.create_at DESC";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                if($user == $row["userID"]){
                    continue;
                }
                $date = local($row["create_at"]);
                if($row["friend_chat"] == 1)
                {
                    array_push($list, array("name" => $row["friend_name"], "groupID" => $row["groupID"], "message" => $row["message"], "date" => $date, "messageName" => $row["firstName"]));
                }
                else
                {
                    array_push($list, array("name" => $row["name"], "groupID" => $row["groupID"], "message" => $row["message"], "date" => $date, "messageName" => $row["firstName"]));
                }
            }
           
            
        }
        echo json_encode(array("results" => $list, "success" => 1));
        
        
    } else {
        echo json_encode(array('success' => 0));
    }
    $conn->close();
    exit();
?>