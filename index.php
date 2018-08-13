<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT); ?>
<!DOCTYPE html>
<html>
<head>
  <title> Aston Events</title>
  <?php include_once("controller/controller.php");
  $controller = new Controller();
  ?>
  <link rel="stylesheet" href="layout.css">
</head>
<body>
  <h1>Aston Events</h1>
  <?php if (isset($_COOKIE["user"])) {
      echo "<h2>Hello " . $_COOKIE["user"] . "</h2>";
  } ?>

  <div id="feed">
    <?php $controller->view->displayFeed();?>
  </div>
  <div id="sidebar">
  <div id="loginForm">
    <?php
    if (!isset($_COOKIE["user"])) {
        $controller->view->displayLogin(); ?>
    <a href="register.php">Register</a>
    <?php
    } else {
        ?>
    <a href="logout.php">Logout</a>
    <?php
    }?>
  </div>
  <div id="filter">
    <?php $controller->view->displayFilter();?>
  </div>
  <div id="createEvent"> <?php
    if (isset($_POST["created"]) && $_POST["created"] != null) {
        $controller->model->createEvent();
        echo "<h3>Event Successfully Created</h3>";
    }
    if (isset($_COOKIE["user"])) {
        $controller->view->displayCreateForm();
    }
    ?>
  </div>
  </div>
</body>
</html>
