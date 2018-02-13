
<?php
include("termsql.php");
include("neo4jcon.php");
#$id = $_POST['id'];
#$value = $_POST['value'];
#list($field, $id) = explode('_', $id);
$field = "relation";
$value =  "unknown";
$idname=34697;
$targetid =203686;
$title ="蘇門集";
$chapter= "卷七00018";

#mysql_query("UPDATE social_network2 SET $field='$value' WHERE id='$id'");
#echo $value;
#$sql = "SELECT * FROM `social_network2` WHERE id=$id";
#$result = mysql_query($sql)  or die(mysql_error());
#while ($record = mysql_fetch_array($result)) {

#         $idname = $record['idname'];
#         $name= $record['name'];
#         $cbdblink= $record['cbdblink'];
#         $targetid =$record['targetid'];
#         $targetname= $record['targetname'];
#         $cbdblinktarget= $record['cbdblinktarget'];
#         $relation=$record['relation'];
#         $title=$record['title'];
#         $chapter=$record['chapter'];
$query="MATCH (u:personmingtest8{nameid:'$idname'})-[rel]->(c:personmingtest8{nameid:'$targetid'}) DELETE rel CREATE (u)-[r:$value{文集名:'$title', 章節:'$chapter'}]->(c)";
$client->run($query);
echo $query;
#}










?>
