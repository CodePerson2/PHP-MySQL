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
//date_default_timezone_set('America/Vancouver');

$script_tz = date_default_timezone_get();

if (strcmp($script_tz, ini_get('date.timezone'))){
    echo 'Script timezone differs from ini-set timezone.' . ' ' . date_default_timezone_get() . ' ' . date("y/m/d h:ia") . '<br>';
} else {
    echo 'Script timezone and ini-set timezone match.' . ' ' . date_default_timezone_get() . ' ' . date("y/m/d h:ia") . '<br>';
}

$errors = [];

$table1 = "CREATE TABLE IF NOT EXISTS login (
    userID INT NOT NULL AUTO_INCREMENT,
    password VARCHAR(100),
    firstName VARCHAR(30) NOT NULL,
    lastName VARCHAR(30) NOT NULL,
    email VARCHAR(30) NOT NULL UNIQUE,
    create_At DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    confirmAccount INT NOT NULL DEFAULT 0,
    PRIMARY KEY (userID)
)";

$table2 = "CREATE TABLE IF NOT EXISTS friends(
    user1ID INT,
    user2ID INT,
    confirm INT DEFAULT 0,
    create_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user1ID) REFERENCES login(userID) ON DELETE CASCADE,
    FOREIGN KEY (user2ID) REFERENCES login(userID) ON DELETE CASCADE
)";

$table3 = "CREATE TABLE IF NOT EXISTS userChatGroup(
    userID INTEGER,
    groupID INTEGER,
    friend_chat INTEGER DEFAULT 0,
    friend_name VARCHAR(60),
    recent_activity DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userID) REFERENCES login(userID) ON DELETE CASCADE,
    FOREIGN KEY (groupID) REFERENCES chatGroup(groupID) ON DELETE CASCADE
)";
    
$table4 = "CREATE TABLE IF NOT EXISTS chatGroup(
    groupID INTEGER NOT NULL AUTO_INCREMENT,
    name VARCHAR(30) NOT NULL,
    color INTEGER DEFAULT 0,
    create_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (groupID)
)";
    
$table5 = "CREATE TABLE IF NOT EXISTS message(
    messageID INTEGER NOT NULL AUTO_INCREMENT,
    userID INTEGER NOT NULL,
    groupID INTEGER NOT NULL,
    message VARCHAR(256),
    create_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userID) REFERENCES login(userID) ON DELETE CASCADE,
    FOREIGN KEY (groupID) REFERENCES chatGroup(groupID) ON DELETE CASCADE,
    PRIMARY KEY (messageID)
)";

$tables = [$table1, $table2, $table3, $table4, $table5];


foreach($tables as $k => $sql){
    $query = @$conn->query($sql);

    if(!$query)
       $errors[] = "Table $k : Creation failed ($conn->error)";
    else
       $errors[] = "Table $k : Creation done";
}


foreach($errors as $msg) {
   echo "$msg <br>";
}


?>