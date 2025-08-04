<?php
 

echo "This is the first PHP file.";

$array = array("apple", "banana", "cherry");

$string = "Hello, World!";

$a = 0;

while (strlen($string) > $a) {
    echo " $string[$a] \n";
    $a++;
}
for($i = 0; $i < count($array); $i++) {
    echo "Element at index $i is: " . $array[$i] . "<br>";
    if ($array[$i] == "banana") {
        echo "Found banana at index $i! \n";
    }
}

?>