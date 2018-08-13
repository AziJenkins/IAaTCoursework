<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include_once("event.php");
class Model
{
    private $server;
    private $dbname;
    private $uname;
    private $pword;
    private $pdo;

    public function __construct($server, $dbname, $uname, $pword)
    {
        $this->server = $server;
        $this->dbname = $dbname;
        $this->uname = $uname;
        $this->pword = $pword;
        $this->pdo = null;
    }

    public function establishConnection()
    {
        try {
            $this->pdo = new PDO("mysql:dbname=$this->dbname;host=$this->server", $this->uname, $this->pword);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo("Sorry. Something went wrong when trying to establish connection to the database :(");
            echo($e->getMessage());
        }
    }

    public function getEvents()
    {
        if (isset($_GET["isFiltered"])) {
            $order = "ORDER BY " . $_GET["order"] . " " . $_GET["Direction"];
            $where = "WHERE ";
            if (isset($_GET["sportfilter"])) {
                $where .= 'category=\'Sport\' OR ';
            }
            if (isset($_GET["culturefilter"])) {
                $where .= 'category=\'Culture\' OR ';
            }
            if (isset($_GET["otherfilter"])) {
                $where .= 'category=\'Other\'';
            }
            if (substr($where, strlen($where)-4) === ' OR ') {
                $where = rtrim($where, " OR ");
            }
            if (strlen($where) < 7) {
                $where = null;
            }
            $query = "SELECT * FROM events " . $where . $order;
            $rows = $this->pdo->query($query);
        } else {
            $rows = $this->pdo->query("SELECT * FROM events");
        }
        $events = array();
        foreach ($rows as $row) {
            $name = $row["name"];
            $category = $row["category"];
            $time = $row["datetime"];
            $description = $row["description"];
            $organiser = $row["organiser"];
            $venue = $row["venue"];
            $image = $row["image"];
            $popularity = $row["popularity"];
            $events[] = new Event($name, $category, $time, $description, $organiser, $venue, $image, $popularity);
        }
        return $events;
    }

    public function createEvent()
    {
        $name = $_POST["ename"];
        $category = $_POST["Category"];
        $date = $_POST["Date"];
        $description = $_POST["Description"];
        $venue = $_POST["Venue"];
        if (isset($_POST["image"])) {
            $image = $_POST["image"];
        } else {
            $image = null;
        }
        if (isset($_COOKIE["user"])) {
            $organiser = $_COOKIE["user"];
        } else {
            echo "Please login";
            return;
        }
        $insert = "INSERT INTO events (name, category, datetime, description, organiser, venue, image, popularity) VALUES (?,?,?,?,?,?,?,?)";
        $stmnt = $this->pdo->prepare($insert);
        $stmnt->execute([$name, $category, $date, $description, $organiser, $venue, $image, 1]);
        $stmnt2 = $this->pdo->prepare("INSERT INTO usereventmap (user, eventname, datetime, isorganising) VALUES (?,?,?,?)");
        $stmnt2->execute([$_COOKIE["user"], $name, $date, 1]);
    }

    public function login()
    {
        if (isset($_POST["uname"]) && isset($_POST["pword"])) {
            $username = $_POST["uname"];
            $password = $_POST["pword"];
            $stmnt = $this->pdo->prepare("SELECT passwordhash FROM users WHERE username= :username");
            $stmnt->bindParam(':username', $username);
            echo $username;
            $stmnt->execute();
            $result = $stmnt->fetch(PDO::FETCH_ASSOC);
            if ($result['passwordhash'] === hash('md5', $password)) {
                setcookie("user", $_POST["uname"]);
                echo "<h3>Hello " . $username . "</h3>";
            } else {
                echo "<h1>Invalid Username Or Password</h1>";
                echo $result['passwordhash'];
                echo "   ";
                echo hash('md5', $password);
            }
        } else {
            echo "<h1>Enter a username and password</h1>";
        }
    }

    public function register()
    {
        $username = $_POST["Username"];
        $password = $_POST["Password"];
        $password2 = $_POST["Password2"];
        $email = $this->pdo->quote($_POST["email"]);
        if ($password === $password2) {
            if (isset($_POST["organiser"]) && $_POST["organiser"] == 'Yes') {
                $organiser = 1;
            } else {
                $organiser = 0;
            }
            $stmnt = $this->pdo->prepare("INSERT INTO users (username, passwordhash, isorganiser, email) VALUES (?,?,?,?)");
            $stmnt->execute([$username, hash('md5', $password), $organiser, $email]);
            $_POST["Success"] = true;
        } else {
            echo "Passwords must match";
        }
    }

    public function showInterest($event, $time)
    {
        $stmnt = $this->pdo->prepare("INSERT INTO usereventmap (user, eventname, datetime) VALUES (?,?,?)");
        $stmnt->execute([$_COOKIE["user"], $event, $time]);
        $stmnt2 = $this->pdo->prepare("UPDATE events SET popularity = popularity + 1 WHERE name = ? AND datetime = ?");
        $stmnt2-> execute([$event, $time]);
    }
}
