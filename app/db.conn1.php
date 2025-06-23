<?php 

# server name
$sName = "localhost";
# user name
$uName = "root";
# password
$pass = "";

# database name
$db_name = "chat_app_db";

#creating database connection
try {
  /**conn=To connect to a database and 
   * prepare()=prepare a SQL statement in PHP,
   * PDO= you can use the PDO (PHP Data Objects) extension*/

    $conn = new PDO("mysql:host=$sName;dbname=$db_name",    
                    $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
  echo "Connection failed : ". $e->getMessage();
}
?>