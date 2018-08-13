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
          $this->model = new Model("127.0.0.1", "astonevents", "guest", "password");
          $this->model->establishConnection();
          $this->view = new View($this->model);
      }

      public function getView()
      {
          return $this->view;
      }
  }
