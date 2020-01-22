<?php

// $array11 = array(1,2,4,5);
// $array12 = array(1,2,3,4);

// function missing_item($array1,$array2){
//     foreach ($array1 as $a) {
//         if (!in_array($a,$array2)) {
//             print_r("This is the missing nummber: ".$a); 
//         }
//     }
// }

// missing_item($array11,$array12);

$param1=0;
$param2=51;

while ($param1 <= $param2) {
    if ($param1%2==0) {
        echo $param1;
        echo "<br>";
        
    }
    $param1=$param1+1;  
    
}


?>

