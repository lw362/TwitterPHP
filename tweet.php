<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Tweet Table</title>
<style type="text/css">
.paginate {
	font-family: Arial, Helvetica, sans-serif;
	font-size: .7em;
}

a.paginate {
	border: 1px solid #000080;
	padding: 2px 6px 2px 6px;
	text-decoration: none;
	color: #000080;
}

a.paginate:hover {
	background-color: #000080;
	color: #FFF;
	text-decoration: underline;
}

a.current {
	border: 1px solid #000080;
	font: bold .7em Arial,Helvetica,sans-serif;
	padding: 2px 6px 2px 6px;
	cursor: default;
	background:#2F63FB;
	color: #FFF;
	text-decoration: none;
}

span.inactive {
	border: 1px solid #999;
	font-family: Arial, Helvetica, sans-serif;
	font-size: .7em;
	padding: 2px 6px 2px 6px;
	color: #999;
	cursor: default;
}

table {
	margin: 8px;
	border: #87B61D;
}

th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: .7em;
	background: #98C133;
	color: #FFF;
	padding: 2px 6px;
	border-collapse: separate;
	border: 1px solid #000;
}

td {
	font-family: Arial, Helvetica, sans-serif;
	font-size: .7em;
	background: #E6F1C9;
	border: 1px solid #DDD;
}
</style>

<script>
function hilite(elem)
{
	elem.style.background = '#2F63FB';
}

function lowlite(elem)
{
	elem.style.background = '';
}
</script>

</head>

<body bgcolor="#F9FCFC">

<div style="color:#8670C0">
	<h2 align="center">Tweet Table</h2>
</div>

<form method="post" action="tweet.php">
	<input type="text" value="<?php echo htmlspecialchars($_GET['input']); ?>" name="input" STYLE="color: #FFFFFF;
	 font-family: Verdana; font-weight: bold; font-size: 12px; background-color: #72A4D2;" size="10" maxlength="30">
	<input type="submit" value="Submit">
</form>

<?php
//include paginator.php once
require_once('paginator.php');

//connect to database
mysql_connect("localhost","root","root") or die (mysql_error());
mysql_select_db("tweets") or die (mysql_error());

//database query from input field or using default query
if($_POST['input'])
	$q = "SELECT * FROM tweet WHERE tweet LIKE '%" .$_POST['input'] ."%' ";
else if($_GET['input'])
	$q = "SELECT * FROM tweet WHERE tweet LIKE '%" .$_GET['input'] ."%' ";
else
	$q = "SELECT * FROM tweet ORDER BY ID ASC";
	
$sql = mysql_query($q);

$pages = new Paginator;
$pages->items_total = mysql_num_rows($sql);       
$pages->mid_range = 7;
$pages->paginate();

echo $pages->display_pages();
echo $pages->display_jump_menu(); // displays the page jump menu
echo $pages->display_items_per_page(); // displays the items per page menu

//add page limitation to query
$query = $q ." $pages->limit";
$result = mysql_query($query);

$pagenumlow = $pages->low + 1;
$pagenumhigh = $pages->high + 1;
echo "<p class=\"paginate\">$q (retrieve records $pagenumlow-$pagenumhigh 
		from table - $pages->items_total item total / $pages->items_per_page items per page)";
echo '<br />';

//display data in table
echo "<table>";
echo "<tr><th>ID</th><th>name</th><th>tweet</th><th>tweetid</th>
			<th>createtime</th><th>retweet#</th><th>status#</th>
			<th>follower#</th><th>friend#</th><th>list#</th></tr>";

while($row = mysql_fetch_row($result))
{
	echo "<tr onmouseover=\"hilite(this)\" onmouseout=\"lowlite(this)\"><td>$row[0]</td>
	<td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td>
	<td>$row[6]</td><td>$row[7]</td><td>$row[8]</td><td>$row[9]</td></tr>\n";
}
echo "</table>";

echo $pages->display_pages();

?>

</body>
</html>