<body>

hi
<?php
 if (isset($_POST["uname"]) && isset($_POST["pword"])) {
     $username = $this->pdo->quote($_POST["Username"]);
     $password = $this->pdo->quote($_POST["Password"]);
     $stmnt = $this->pdo->prepare("SELECT passwordhash FROM users WHERE username=?");
     $stmnt->execute([$username]);
     $result = $stmnt->fetch();
     if ($result['passwordhash'] == hash('md5', $password)) {
         setcookie("user", $_REQUEST["Username"]);
         header("Location: astonevents.php");
         die();
     } else {
         echo "<h1>Invalid Username Or Password</h1>";
     }
 } else {
     echo "<h1>Enter a username and password</h1>";
 }
 ?>
 </body>
