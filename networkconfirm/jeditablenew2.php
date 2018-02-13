
<?php
include("termsql.php");
include("neo4jcon.php");
$id = $_POST['id'];
$value = $_POST['value'];
#$id =1;
#$field="relation";
#$value="unknown";
list($field, $id) = explode('_', $id);
mysql_query("UPDATE social_network2 SET $field='$value' WHERE id='$id'");
echo "$value";










?>
