<?php
header("Content-Type: application/json");

require_once "router.php";
require_once "memory.php";
require_once "rate_limit.php";

$input = json_decode(file_get_contents("php://input"), true);

$message = $input["message"] ?? "";
$modelName = $input["model"] ?? "mistral";

if (!$message) {
    echo json_encode(["error" => "No message"]);
    exit;
}

addMessage("user", $message);

$apiKey = getApiKey();
$model  = getModel($modelName);

$data = [
    "model" => $model,
    "messages" => getMessages()
];

$ch = curl_init("https://api.openrouter.ai/v1/chat/completions");
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $apiKey",
        "Content-Type: application/json"
    ],
    CURLOPT_POSTFIELDS => json_encode($data)
]);

$result = curl_exec($ch);
curl_close($ch);

$res = json_decode($result, true);
$reply = $res["choices"][0]["message"]["content"] ?? "No response";

addMessage("assistant", $reply);

echo json_encode([
    "reply" => $reply,
    "model" => $modelName
]);
