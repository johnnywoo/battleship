<?php

if (is_file(__DIR__ . $_SERVER['REQUEST_URI'])) {
    // php -S will serve the file (images, JS, etc)
    return false;
}

require_once __DIR__ . '/../vendor/autoload.php';

// http://127.0.0.1/api/a1a2a3a4 => {"is_valid":false}
if (substr($_SERVER['REQUEST_URI'], 0, 5) == '/api/') {
    $board = new Board();

    $spec = substr($_SERVER['REQUEST_URI'], 5);

    $shipsString = preg_replace('[^a-j0-9]','', $spec);
    preg_match_all('/([a-j])(\d+)/', $shipsString, $matches, PREG_SET_ORDER);

    foreach ($matches as $match) {
        $board->addShip($match[1], $match[2]);
    }

    $numberOfShips = $board->getNumberOfShips();
    echo json_encode([
        'is_valid' => ($numberOfShips == 4),
    ]);
    exit;
}
