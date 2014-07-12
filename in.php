<?php
$content="";
$date="";
$file = "json.txt";
echo
<<<HTMLPART
<!doctype html>
<html>
<head></head>
<body>
<form action="" method="POST" name="out">
<textarea name="text"></textarea><br>
<input type="submit" value="SUBMIT">
</form>
</body>
</html>
HTMLPART;
if (isset($_POST['text']) && ($_POST['text']!=""))
    { $content = $_POST['text'];
        $date = date('H:i:s d-M-Y');
    }
$v = '{"content": "'.$content.'",
"timestamp" : "'.$date.'",
"is_sent": false }';

echo $tmp = file_get_contents($file);
$tmp .= $v;

if (isset($_POST['text']) && ($_POST['text']!=""))
        {   strip_tags($tmp);
            trim($tmp);
            file_put_contents($file,$tmp);
            echo "TEXT RECORD ADDED....OK";
            unset($_POST['text']);
        }
else echo "RECORD NOT ADDED";
?> 