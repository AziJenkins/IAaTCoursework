<?php
class Event
{
    public $name = null;
    public $category = null;
    public $time = null;
    public $description = null;
    public $organiser = null;
    public $venue = null;
    public $image = null;
    public $popularity = null;

    public function __construct($name, $category, $time, $description, $organiser, $venue, $image, $popularity)
    {
        $this->name = $name;
        $this->category = $category;
        $this->time = $time;
        $this->description = $description;
        $this->organiser = $organiser;
        $this->venue = $venue;
        $this->image = $image;
        $this->popularity = $popularity;
    }

    public function __get($event)
    {
        return $this->$event;
    }
}
