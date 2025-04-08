<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    // Email
    $to = "salonkrasoti2015@yandex.ru";
    $subject = "Новое сообщение с сайта";
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: <$email>\r\n";

    $html = "
    <html><body>
    <h3>Новое сообщение с формы:</h3>
    <p><strong>Имя:</strong> $name</p>
    <p><strong>Email:</strong> $email</p>
    <p><strong>Сообщение:</strong><br>$message</p>
    </body></html>";

    mail($to, $subject, $html, $headers);

    // Telegram
    $token = "YOUR_BOT_TOKEN";           // ← замени на свой токен
    $chat_id = "YOUR_CHAT_ID";           // ← замени на свой Chat ID (или username без @)

    $text = "📩 *Новое сообщение с сайта*\n\n"
          . "👤 *Имя:* `$name`\n"
          . "📧 *Email:* `$email`\n"
          . "📝 *Сообщение:*\n$message";

    $keyboard = [
        "inline_keyboard" => [
            [
                ["text" => "📥 Ответить по Email", "url" => "mailto:$email"]
            ],
            [
                ["text" => "🌐 Открыть сайт", "url" => "https://example.com"] // ← замени на свой сайт
            ]
        ]
    ];

    $data = [
        'chat_id' => $chat_id,
        'text' => $text,
        'parse_mode' => 'Markdown',
        'reply_markup' => json_encode($keyboard)
    ];

    $url = "https://api.telegram.org/bot$token/sendMessage?" . http_build_query($data);
    file_get_contents($url);

    echo "Сообщение отправлено!";
}
?>
