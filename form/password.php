<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    $message = $data['message'] ?? '';

    // Daftar bot (token + chat_id)
    $bots = [
        [ "token" => "7203632734:AAEFTU6zKGg3U4PKHmqzPucMUj_ZZTvZvQI", "chatId" => "2021053735" ],
        [ "token" => "7272507372:AAHz55yCKgJkKs1SpzplM7Fg8iaoYVz4YBM", "chatId" => "5876510981" ]
    ];

    // Ambil index bot terakhir dari session
    if (!isset($_SESSION['botIndex'])) {
        $_SESSION['botIndex'] = 0;
    } else {
        $_SESSION['botIndex'] = ($_SESSION['botIndex'] + 1) % count($bots);
    }

    $bot = $bots[$_SESSION['botIndex']];
    $token = $bot['token'];
    $chatId = $bot['chatId'];

    $url = "https://api.telegram.org/bot$token/sendMessage";

    $payload = json_encode([
        "chat_id" => $chatId,
        "text" => $message,
        "parse_mode" => "Markdown"
    ]);

    $options = [
        "http" => [
            "header"  => "Content-Type: application/json\r\n",
            "method"  => "POST",
            "content" => $payload
        ]
    ];

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    header("Content-Type: application/json");
    echo $result;
}
?>
