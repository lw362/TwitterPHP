<?php
require_once ('pieshow.php');
require_once ('barshow.php');

$query = "iphone5 galaxy htc";
pieshow($query);

$qry = "obama";
barshow($qry);

$mgraph = new MGraph();
$mgraph->SetMargin(2,2,2,2);
$mgraph->SetFrame(true,'darkgray',2);
$mgraph->Add($graph);
$mgraph->Add($graph2,0,240);
$mgraph->Stroke();

?>