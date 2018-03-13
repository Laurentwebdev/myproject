<?php 
include __DIR__.'/Services/dbconnector.php';
$configs = require __DIR__.'/config/app.config.php';

use Services\dbconnector;

dbconnector::setConfig($configs["db"]);

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    
    $username = $_POST["username"] ?? null;
    $password = $_POST["password"] ?? null;
    $password_2 = $_POST["password_2"] ?? null;
    $comment = $_POST["comment"] ?? null;
        
    $usernameSuccess = is_string($username) && strlen($username) >2;
    $passwordsuccess = $password === $password_2 && strlen($password) >5;
    
    if($usernameSuccess && $passwordsuccess){
        
        try{
            $connection = dbconnector::getConnection();
        }catch (PDOException $exception){
                http_response_code(500);
                echo "problem, evacuate immediately";
                exit(10);
        }
        
        $sql = "INSERT INTO user(username, password, comment) VALUES (\"$username\", \"$password\", \"$comment\")";
        $affected = $connection->exec($sql);
        
        if (!$affected){
            echo implode(", ", $connection->errorInfo());
        }
        echo "SuCcEsSfUlLy ReGiStErEd";?><br>
        <a href="/index.php">Go back</a>
        <?php 
        return;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset = "UTF-8">
<title>Signup</title>
</head>
<body>
<a href=/index.php>Go back</a>

<form action="/signup.php" method="post">

  <div class="container">
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="username" value=<?php echo htmlentities($username ?? "")?>>

    <label for="password"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" >
    
    <label for="password_2"><b>retype ur pswd just 2 b sure</b></label>
    <input type="password" placeholder="Enter Password" name="password_2" >

    <label for="comment"><b>So let us know what you think of our product</b></label>
    <input type="text" placeholder="Comment" name="comment" >

    <button type="submit">Signup</button>

  </div>

</form>

</body>
</html>

