<?php
require 'config.php';
require("rb.config.php");

// -----------------------

if (isset($_GET["social_network2_id"]) ) {
	$social_network2 = R::load( 'social_network2', $_GET["social_network2_id"] );   //Retrieve
	if (isset($social_network2) ) {
		echo $social_network2->text;
		?>
<style>
body {
	line-height: 1.5em;
	padding: 2em;
}
p {
	padding-left: 0 !important;
	line-height: 1.5em !important;
}
</style>
		<?php
		exit();
	}
} 	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<link rel="stylesheet" href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<link rel="stylesheet" href="//pulipulichen.github.io/blogger/posts/2016/12/semantic/semantic.min.css">
<link rel="stylesheet" href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css">
<script src="//pulipulichen.github.io/blogger/posts/2016/12/semantic/semantic.min.js"></script>
<script src="//pulipulichen.github.io/blogger/posts/2016/12/jszip.min.js"></script>
<script src="//pulipulichen.github.io/blogger/posts/2016/12/FileSaver.min.js"></script>
<script src="//pulipulichen.github.io/blogger/posts/2016/11/r-text-mining/wordcloud2.js"></script>
<script src="//pulipulichen.github.io/blogger/posts/2016/12/clipboard.min.js"></script>
<script src="//pulipulichen.github.io/blogger/posts/2016/12/smooth-scroll.min.js"></script>
<!-- <link rel="icon" href="icon.png" type="image/png"> -->
<title><?php echo $CONFIG["title"]; ?></title>
<link rel="icon" type="image/png" href="favicon.png" />
<style>
body {
	padding: 2em;
}

.pointer {
	cursor: pointer;
	text-decoration: underline;
}

table td,
table th {
	vertical-align: top;
}

td strong {
	color: red;
}
/*
td.fulltext {
	text-align: center;
	white-space: nowrap;
	overflow-x: hidden;
	
}*/
td div.segment {
	text-align: center;
	padding-top: 0 !important;
    padding-bottom: 0 !important;
	white-space: nowrap;
}

td div.segment a {
	color: black;
	
}

.float-action-button {
  position: fixed;
  bottom: 1em;
  right: 1em;
  box-shadow: 0 0 4px rgba(0, 0, 0, 0.14), 0 4px 8px rgba(0, 0, 0, 0.28) !important;
}
</style>

</head>

<body>

<h1 id="top"><?php echo $CONFIG["title"]; ?></h1>
<form class="ui form" method="GET" action="index.php">
	<div class="ui segment">
		<div class="field">
			<label for="text">
				全文關鍵詞
			</label>
			<input type="text" id="text" name="text" 
                               placeholder="<?php echo $CONFIG["hint"]; ?>"
			<?php if(isset($_GET["text"])) { ?> value="<?php echo $_GET["text"]; ?>" <?php } ?> />
		</div> 
		<div class="field">
			<label for="title">
				文集名
			</label>
			<input type="text" id="title" name="title" placeholder=""
			<?php if(isset($_GET["title"])) { ?> value="<?php echo $_GET["title"]; ?>" <?php } ?> />
		</div> 
		<div class="field">
			<label for="name">
				人名
			</label>
			<input type="text" id="name" name="name" placeholder="" 
			<?php if(isset($_GET["name"])) { ?> value="<?php echo $_GET["name"]; ?>" <?php } ?> />
		</div> 
		<div class="field">
			<label for="cbdbid">
				CBDBID
			</label>
			<input type="text" id="cbdbid" name="cbdbid" placeholder="" 
			<?php if(isset($_GET["cbdbid"])) { ?> value="<?php echo $_GET["cbdbid"]; ?>" <?php } ?> />
		</div> 

          <div class="field">
			<label for="relation">
				社會網絡屬性
			</label>
          <input type="text" id="relation" name="relation" placeholder="" 
			<?php if(isset($_GET["relation"])) { ?> value="<?php echo $_GET["relation"]; ?>" <?php } ?> />
		</div>



		<div class="field">
			<button type="submit" class="ui button blue fluid">查詢</button>
		</div>
	</div>
<?php
if(isset($_GET["text"]) || isset($_GET["title"]) || isset($_GET["name"]) || isset($_GET["cbdbid"]) || isset($_GET["relation"])) {
	@$text = $_GET["text"];
	@$search_title = $_GET["title"];
	@$search_name = $_GET["name"];
	@$search_cbdbid = $_GET["cbdbid"];
	@$search_cbdbid = $_GET["relation"];
	// http://semantic-ui.com/elements/divider.html
	?>
<h2 class="ui horizontal divider header">查詢結果 </h2>
	<?php
	
// ---------------
// 開始查詢
include("simple_html_dom.php");

$cond = [];
$values = [];

if (isset($text) && $text !== "") {
	array_push($cond, 'text LIKE :text');
	$values[":text"] = '%' . $text . '%';
}
if (isset($search_title) && $search_title !== "") {
	array_push($cond, 'title LIKE :title');
	$values[":title"] = '%' . $search_title . '%';
}
if (isset($search_name) && $search_name !== "") {
	array_push($cond, 'name LIKE :name');
	$values[":name"] = '%' . $search_name . '%';
}

if (isset($search_name) && $search_name !== "") {
	array_push($cond, 'targetname LIKE :targetname');
	$values[":targetname"] = '%' . $search_name . '%';
}


if (isset($search_cbdbid) && $search_cbdbid !== "") {
	array_push($cond, 'idname LIKE :idname');
	$values[":idname"] = '%' . $search_name . '%';
}

if (isset($search_cbdbid) && $search_cbdbid !== "") {
	array_push($cond, 'targetid LIKE :targetid');
	$values[":targetid"] = '%' . $search_name . '%';
}

if (isset($search_relation) && $search_relation !== "") {
	array_push($cond, 'relation LIKE :relation');
	$values[":relation"] = '%' . $search_relation . '%';
}
//$social_network2s = R::find( 'social_network2'
//	, implode(" OR ", $cond)
//	, $values );
	
$social_network2s = R::getAll("SELECT * FROM social_network2 WHERE " . implode(" OR ", $cond) . " ORDER BY id, title", $values);
//$social_network2s = R::getAll("SELECT * FROM social_network2 WHERE fulltext LIKE '%中%' ORDER BY year, title");
//echo count($social_network2s);

$social_network2s = R::convertToBeans( 'social_network2', $social_network2s );
//echo "SELECT id, title, name, date, fulltext FROM social_network2 WHERE " //. implode(" OR ", $cond) ;

//echo implode(" OR ", $values);

$social_network2_count =  count($social_network2s);
	?>
	<div class="ui info message">
		總共找到 <?php echo $social_network2_count ?> 筆文件
	</div>
	<?php
	
// --------------------------
if ($social_network2_count > 0) {
	?>

<button type="button" onclick="$(window).scrollTop(0)" class="circular large teal ui icon button float-action-button" title="回到頁首">
		<i class="large angle double up icon"></i>
</button>
<table class="ui striped table">
	<thead>
		<!-- <th>ID</th> -->
		<th>編號</th>
		<th>文集名</th>
		<th>章節</th>
		<th>CBDBID</th>
		<th>人名</th>
		<th>目標人名CBDBID</th>
		<th>目標人名</th>
		<th>連線關係</th>
		<th>相關內文</th>
	</thead>
	<tbody>
	<?php
foreach ($social_network2s AS $social_network2) {
	$id = $social_network2->id;
	
	$fulltext = $social_network2->text;
	$fulltext = str_get_html($fulltext)->plaintext;
	$fulltext_parts;
	if (isset($_GET["text"]) && $text !== "") {
		// 全文 > 依照新詞 斷開 成 很多陣列
		$fulltext_parts = explode($text, $fulltext);
		if (count($fulltext_parts) < 2) {
			continue;
		}
	}
	
	echo '<tr>';
	//echo '<td>' . $social_network2->id . '</td>';
	$date = $social_network2->id;
	echo '<td class="top aligned pointer" title="' . $id .'">' . $id . '</td>';
	

	$title = $social_network2->title;
	$ori_title = $title;
	if (mb_strlen($title) > 8 ) {
		$title = mb_substr($title, 0, 8) . "...";
	}
	$title = '<a href="index.php?social_network2_id=' . $id . '" target="_blank">'. $title .'</a>';
	echo '<td class="top aligned" title="'.$ori_title.'">' . $title . '</td>';
	
	//echo strpos("AAAVBBBVCCC", "V");	//4
	$chapter = $social_network2->chapter;
	$ori_chapter = $chapter;
	if (mb_strlen($chapter) > 8 ) {
		$chapter = mb_substr($chapter, 0, 8) . "...";
	}
$chapter = '<a href="index.php?social_network2_id='.$id . '" target="_blank">' . $chapter . '</a>';
	echo '<td class="top aligned" title="'.$chapter.'">' . $chapter . '</td>';
	
     $idname = $social_network2->idname;
	echo '<td class="top aligned" title="' . $idname . '">' . $idname . '</td>';



	$name = $social_network2->name;
	$ori_name = $name;
	if (mb_strlen($name) > 4 ) {
		$name = mb_substr($name, 0, 4) . "...";
	}
	echo '<td class="top aligned" title="' . $ori_name . '">' . $name . '</td>';

     $targetid = $social_network2->targetid;
	echo '<td class="top aligned" title="' . $targetid . '">' . $targetid . '</td>';


	$targetname = $social_network2->targetname;
	$ori_targetname = $targetname;
	if (mb_strlen($targetname) > 4 ) {
		$targetname = mb_substr($targetname, 0, 4) . "...";
	}
	echo '<td class="top aligned" title="' . $ori_targetname . '">' . $targetname . '</td>';
	//echo '<td>' . $social_network2->id . '</td>';
	
	// -----------------------
	$relation = $social_network2->relation;
	echo '<td class="top aligned" title="' . $relation . '">' . $relation . '</td>';
	

	$abstract_length = 20;
	if (isset($_GET["text"]) && $text !== "") {
		
		echo '<td class="fulltext top aligned center aligned">';
		//echo count($fulltext_parts);
		
		// Fulltext: AAAVBBBVCCC
		// New Term: V
		// Explode: ["AAA", "BBB", "CCC"]
		
		// foreach 0: continue
		// foreach 1: "AAA", "V", "BBB"
		// foreach 2: "BBB", "V", "CCC"
		
		
		foreach ($fulltext_parts AS $index => $part) {
			if ($index === 0) {
				continue;
			}
			
			
			echo '<div class="ui vertical  segment">';
			echo '<a href="index.php?social_network2_id=' . $id . '" target="_blank">';
			
			
			$last_part = $fulltext_parts[($index-1)];
			$last_part_len = mb_strlen($last_part);
			if ($last_part_len > $abstract_length) {
				$last_part = "..." . mb_substr($last_part, $last_part_len-$abstract_length, $abstract_length);
			}
			while (mb_strlen($last_part) < $abstract_length) {
				$last_part = "　" . $last_part;
			} 
			
			echo $last_part;
			
			// ---------
			
			echo '<strong>' . $text . '</strong>';
			
			$current_part = $part;
			$current_part_len = mb_strlen($current_part);
			if ($current_part_len > $abstract_length) {
				$current_part = mb_substr($current_part, 0, $abstract_length) . "...";
			}
			while (mb_strlen($current_part) < $abstract_length) {
				$current_part = $current_part . "　";
			} 
			echo $current_part;
			
			echo '</a>';
			
			echo '</div>';
		}
		echo '</td>';
	} 
	else {
		
		$fulltext = mb_substr($fulltext, 0, $abstract_length*2) . "...";
		$fulltext = '<a href="index.php?social_network2_id=' . $id . '" target="_blank">' . $fulltext . '</a>';
		echo '<td>' . $fulltext . '</td>';
	}
	
	// -----------------
	echo '</tr>';
	
}
	?>
	</tbody>
</table>
	
	<?php
}	//if ($social_network2_count > 0) {
	
}	// if (isset($_GET["text"])) {
?>
</form>

</body>
</html>
