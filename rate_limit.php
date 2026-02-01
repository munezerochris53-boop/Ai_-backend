here<?php
session_start();

$limit = 20; // requests
$seconds = 60;

if (!isset($_SESSION["rate"])) {
    $_SESSION["rate"] = [];
}

$now = time();
$_SESSION["rate"] = array_filter($_SESSION["rate"], fn($t) => $t > $now - $seconds);

if (count($_SESSION["rate"]) >= $limit) {
    http_response_code(429);
    echo json_encode(["error" => "Rate limit exceeded"]);
    exit;
}

$_SESSION["rate"][] = $now;
