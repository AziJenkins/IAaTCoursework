<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include_once("model/event.php");
include_once("model/model.php");
class View
{
    public $model = null;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function displayFeed()
    {
        $events = $this->model->getEvents();
        foreach ($events as $event) {
            $name = $event->name;
            $time = $event->time; ?>
        <div id="event">
        <h3><?php echo $name ?></h3>
        <h4><?php echo $event->category ?></h4>
        <p1><?php echo $event->description ?></p1>
        <h4><?php echo $time ?></h4>
        <h4><?php echo $event->organiser ?></h4>
        <h4><?php echo $event->venue ?></h4>
        <h4><?php echo $event->popularity ?></h4>
        <?php if ($event->image != null) {
                ?>
        <img src=<?php echo $event->image ?>/>
        <?php
            }

            if (!isset($_REQUEST['event']) or $_REQUEST['event'] != $name) {
                echo "<form name=\"interest\" method=\"post\" action=\"index.php\">";
                echo "<input type=\"submit\" name=\"showInterest\" value=\"Show Interest\" />";
                echo "<input type=\"hidden\" name=\"event\" value=\"$name\">";
                echo "</form>";
            } else {
                if ($_REQUEST['event'] === $name) {
                    $this->model->showInterest($name, $time);
                }
            } ?>
        </div>
        <?php
        }
    }

    public function displayLogin()
    {
        if (!isset($_POST["isSubmitted"])) {
            echo "<form method=\"post\" action=\"index.php\">";
            echo "Username: <input type=\"text\" name=\"uname\" id=\"uname\"/>";
            echo "Password: <input type=\"password\" name=\"pword\" id=\"pword\"/>";
            echo "<input type=\"submit\" name=\"btnLogin\"  value=\"Login\"/>";
            echo "<input type=\"hidden\" name=\"isSubmitted\" value=\"true\" />";
            echo "</form>";
        } else {
            $this->model->login();
        }
    }

    public function displayCreateForm()
    {
        echo "<form method=\"post\" action=\"index.php\" id=\"create\">";
        echo "<div id=\"column\">Event name: <input type=\"text\" name=\"ename\" /></div>";
        echo "<div id=\"column\">Category: <select name=\"Category\">";
        echo "<option value=\"Sport\">Sport</option>";
        echo "<option value=\"Culture\">Arts</option>";
        echo "<option value=\"Others\">Science</option>";
        echo "</select></div>";
        echo "<div id=\"column\">Date and time: <input type=\"datetime\" name=\"Date\" /></div>";
        echo "<div id=\"column\">Description: <input type=\"text\" name=\"Description\"></div>";
        echo "<div id=\"column\">Venue: <input type=\"text\" name=\"Venue\" /></div>";
        echo "<div id=\"column\">Image: <input type=\"image\" name=\"Image\" /></div>";
        echo "<input type=\"submit\" name=\"btnCreateEvent\" value=\"Create\" />";
        echo "<input type=\"hidden\" name=\"created\"  />";
        echo "</form>";
    }

    public function displayFilter()
    {
        echo "<form method=\"get\" id=\"filter\" action=\"index.php\">";
        echo "<select name=\"order\">";
        echo "<option value=\"datetime\">Date/Time</option>";
        echo "<option value=\"popularity\">Popularity</option>";
        echo "</select>";
        echo "<select name=\"Direction\">";
        echo "<option value=\"ASC\">Ascending</option>";
        echo "<option value=\"DESC\">Descending</option>";
        echo "</select>";
        echo "Sport <input type=\"checkbox\" value=\"Sport\" name=\"sportfilter\"/>";
        echo "Culture <input type=\"checkbox\" value=\"Culture\" name=\"culturefilter\"/>";
        echo "Other <input type=\"checkbox\" value=\"Other\" name=\"otherfilter\" />";
        echo "<input type=\"submit\" name=\"Filter\" />";
        echo "<input type=\"hidden\" name=\"isFiltered\" value=\"true\" />";
        echo "</form>";
    }
}
