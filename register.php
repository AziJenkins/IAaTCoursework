<?php
include_once("controller/controller.php");
$controller = new Controller();
if (isset($_POST["register"])) {
    $controller->model->register();
    if (isset($_POST["Success"])) {
        echo "Success. Please login";
        echo "<a href=\"astonevents.php\">Home</a>";
    } else {
        echo "Failed";
        echo "<a href=\"astonevents.php\">Home</a>";
    }
} else {
    ?>
  <form name="register" method="post" action="register.php">
    Username: <input type="text" name="Username" />
    Password: <input type="password" name="Password" >
    Re-enter password:<input type="password" name="Password2" >
    Aston email: <input type="email" name="email" value="Email" pattern=".+@aston.ac.uk" required/>
    Register as organiser? <input type="checkbox" value="organiser" name="organiser" />
    <input type="submit" name="submit" value="submit">
    <input type="hidden" name="register" value="true" />
  </form>
  <?php
}
