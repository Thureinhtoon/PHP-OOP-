<?php
$arr = [
    [
        'name' => 'Ko Thu',
        'age' => 21
    ],
    [
        'name' => 'Ko Ko',
        'age' => 18
    ]
    ];

    $json = '{"name":"Ko Thu","age":21}';
    
    // $data = json_decode($json);
    // print_r($data) ;
    echo json_encode($arr);
?>