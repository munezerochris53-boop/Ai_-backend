<?php
require_once "config.php";

function getApiKey() {
    global $API_KEYS;
    return $API_KEYS[array_rand($API_KEYS)];
}

function getModel($name) {
    global $MODELS;
    return $MODELS[$name] ?? $MODELS["mistral"];
}￼Enter
