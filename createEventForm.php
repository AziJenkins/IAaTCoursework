<form method="post" action="<?php $controller->model->createEvent(); ?>" id="create">
  Event name: <input type="text" name="Event Name" />
  Category: <select name="Category">
                  <option value="Sport"></option>
                  <option value="Arts"></option>
                  <option value="Science"></option>
                  </select>
  Date and time: <input type="datetime" name="Date" />
  Description: <input type="text" name="Description">
  Venue: <input type="text" name="Venue" />
  Image: <input type="image" name="Image" />
  <input type="submit" name="btnCreateEvent" value="Create" />
</form>
