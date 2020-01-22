<?php
// $manu ="que hace esto a ver";
// $manuel = "TTWREA6JiVTKCcpRTxXNUU7JzFPKCY1Uz0mNEA8RjVUO1JYT
// itCIVQ5MiFRPTY1RDgyIU05NllPPFIhUA0KRzg3KUEoJlFMOTY9QT
// xCIUEoJlFBKCY5STtGJUwoJjVOKCYtWThGNVI4ViVNPCJgUiwjJF
// UNCmA=

// ";

// echo "<br>";
// print_r (base64_encode($manu));
// echo "<br>";
// print_r (base64_decode($manuel));

$password = "lollol";
$password = hash('sha256',$password);
echo $password;

?>

