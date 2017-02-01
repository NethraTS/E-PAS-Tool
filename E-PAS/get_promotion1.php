<?php 
$con = new Mongo;
$db = $con->AppraisalManagement1;
$c = $db->selectCollection('designationCategories');
$cate = $_REQUEST["category"];
?>
<select class="form-control" name="currentposition" id="current1">
<option value="" disabled="true">Proposed Position</option>
<?php 
$cursor = $c->distinct("role", array("category" =>$cate));
foreach($cursor as $doc){?>
<option><?php echo $doc;?></option>
<?php	
}
?>
</select>
