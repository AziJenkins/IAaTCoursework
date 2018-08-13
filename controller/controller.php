<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
  include_once("model/model.php");
  include_once("view/view.php");

  class Controller
  {
      public $model = null;
      public $view = null;

      public function __construct()
      {
          $this->test = "yes";
          $this->model = new Model("sql2.freemysqlhosting.net", "sql2251850", "sql2251850", "sX9%pR4!");
          $this->model->establishConnection();
          $this->view = new View($this->model);
      }

      public function getView()
      {
          return $this->view;
      }
  }
