<?php
$content = file_get_contents('json.txt');
$date = "date";

$in1 = strpos($content, "{");
$in2 = strpos($content, "}");
$cut_length = $in2 - $in1 +1;

$piece = substr($content, $in1, $cut_length);
echo $piece;
echo
<<<H
<!doctype html>
<html>
<head>
<style>
div {border: 1px solid black;
        width: 150px;
        float: left;
        min-height: 20px;
        margin: 1px;
        text-align: center;}
#content, #cont_head { clear: left;
            width: 300px;}
</style>
</head>
<body>
<div id="cont_head">Content</div>
<div>Post Date</div>
<div id="content">$content</div>
<div id="date">$date</div>
</body>
</html>
H;
?>