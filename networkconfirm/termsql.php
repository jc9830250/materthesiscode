<?php
$dbhost = 'localhost:3306';
$dbuser = 'root';
$dbpass = '#EDC%TGB';
$dbname = 'term';
$conn = mysql_connect($dbhost, $dbuser, $dbpass) ;
mysql_query("set character set 'utf8'");
mysql_query("set names 'utf8'");
mysql_select_db($dbname);
/*
$word ="陳束";
$sql = "SELECT distinct c_personid FROM name WHERE c_name_chn = '$word'  OR c_alt_name_chn = '$word' ";
$result = mysql_query($sql) or die(mysql_error());
echo mysql_result($result, 0);
*/
/*
$sql = "INSERT INTO `term`.`social network` (`idname`, `name`, `cbdblink`, `targetid`, `targetname`, `cbdblinktarget`, `relation`, `note`) VALUES (\'123333377\', \'eeeee\', \'tetetetete\', \'456\', \'eeeeee\', \'ddddd\', \'sssss\', \'qqqqq\');";
mysql_query($sql);
*/
?>
