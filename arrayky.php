<?php

$a = 25;
$b = 45;
$c = 65;
$d = 150;

$str = [$a, $b, $c, $d]; //одномерные массивы
print_r($str) . '<br>';


$bigmass = [ //ассоциативные массивы
    1 => 25,
    "Screm" => "Yes",
    "TXT" => "GO,GO!"
    ];

echo $bigmass[1] . '<br>';

echo $bigmass["Screm"] . '<br>';

echo $bigmass["TXT"]. '<br>';


$mnm = [ //Многомерные массивы
    [2,5,7],
    ["TESTMER" => "Chest", "Trem" => "Laster", "Grimm" => "Slowly"],
    ["znak" => true, "Spor" => "Yes"]
];

echo $mnm[1]["TESTMER"]. '<br>';

//поменяем ключ в многомерном массиве

$new_arr = array();
foreach ($mnm[1] as $key => $value) {

    if($key=="TESTMER") {$new_arr["DERTMER"] = $value; unset ($mnm[$key]); }

    else {$new_arr[$key] = $value;}

}
print_r($new_arr);



