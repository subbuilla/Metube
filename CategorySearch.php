<?php
require_once("commonFiles/header.php");
require_once("files/Classes/SearchResultsProvider.php");
?>
<form>
<select name="categories" onchange="videoByCategory(this.value)">
  <option value="">Select a Category:</option>
  <option value="1">Music</option>
  <option value="2">Games</option>
  <option value="3">Art</option>
  <option value="4">Technology</option>
  <option value="5">Sports</option>

  </select>
</form>
<div id="cate"><b>No Category Selected</b></div>





<?php
require_once("commonFiles/footer.php");
?>



