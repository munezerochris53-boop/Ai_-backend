<?php
session_start();

if (!isset($_SESSION["messages"])) {
    $_SESSION["messages"] = [];
}

function addMessage($role, $content) {
    $_SESSION["messages"][] = [
        "role" => $role,
        "content" => $content
    ];

    // limit memory (last 10)
    $_SESSION["messages"] = array_slice($_SESSION["messages"], -10);
}

function getMessages() {
    return $_SESSION["messages"];
}
