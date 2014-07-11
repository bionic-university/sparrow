<?php
// Procedural approach
class Keykeeper {
    public function __construct($whattoopen, $close = false ) {
        $whattoopen = strtolower($whattoopen);
        if ($close) {
                switch ($whattoopen) {
                    case 'door' :
                        echo Self::Close($whattoopen);
                        break;
                    case 'chest' :
                        echo Self::Close($whattoopen);
                        break;
                    case 'gates' :
                        echo Self::Close($whattoopen);
                        break;
                    case 'window' :
                        echo Self::Close($whattoopen);
                        break;
                    default :
                        echo "Unfortunately the Keykeeper can not close this thing :( try door chest gates or window";
                        break;
                }
            }
        else {
            switch ($whattoopen) {
                case 'door' :
                    echo Self::Unlock($whattoopen);
                    break;
                case 'chest' :
                    echo Self::Unlock($whattoopen);
                    break;
                case 'gates' :
                    echo Self::Open($whattoopen);
                    break;
                case 'window' :
                    echo Self::Open($whattoopen);
                    break;
                default :
                    echo "Unfortunately the Keykeeper can not open this thing :( try door chest gates or window";
                    break;
            }
        }

        echo '<br>';
    }

    public function Open($whattoopen) {return " the Keyekeeper has opened the ".$whattoopen;}
    public function Close($whattoclose) {return " the Keyekeeper has closed the ".$whattoclose;}
    public function Unlock($whattounlock) {return " the Keyekeeper has unlocked the ".$whattounlock." with the key";}

}
// To open smth you need to send a string of object type
// To close smth you need to send any second parameter

$openthe = ['Chest', 'Door', 'Window','Gates'];
$a = new Keykeeper($openthe[0]);
$b = new Keykeeper($openthe[1]);
$c = new Keykeeper($openthe[2]);
$d = new Keykeeper($openthe[3]);
$e = new Keykeeper($openthe[0],true);
$f = new Keykeeper($openthe[1],1);
$g = new Keykeeper($openthe[2],"yes");
$h = new Keykeeper($openthe[3],true);

?>