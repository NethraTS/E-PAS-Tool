<?php 
$con = new Mongo;
$db = $con->goals1;
$c = $db->goal_definition;
$goal =strtoupper($_REQUEST["goal"]);
$goal=trim($goal);
?>
<select class="static-form-control" id="def1"><option selected disabled>Select a definition</option>
      <?php
      $cursor = $c->distinct('definition',array('goal'=>$goal)); 
		foreach ($cursor as $val) {
		?>
  	      <option><?php echo $val['name']; ?></option>
	   <?php } ?>					 
</select>