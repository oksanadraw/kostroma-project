<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $message = nl2br(htmlspecialchars(trim($_POST["message"])));

    // 1. Отправка на email
    $to = "salonkrasoti2015@yandex.ru"; // ← твой email
    $subject = "Новое сообщение с сайта";
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: <$email>\r\n";

    $body = "
    <html>
      <body>
        <h3>Новое сообщение с формы:</h3>
        <p><strong>Имя:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Сообщение:</strong><br>$message</p>
      </body>
    </html>";

    $emailResult = mail($to, $subject, $body, $headers);

    // 2. Уведомление в Telegram (если хочешь)
    $token = "ТВОЙ_ТОКЕН_БОТА";         // ← замени
    $chat_id = "ТВОЙ_CHAT_ID";          // ← замени

    if ($token !== "ТВОЙ_ТОКЕН_БОТА") {
        $text = "📩 *Новое сообщение с сайта*\n\n"
              . "👤 *Имя:* `$name`\n"
              . "📧 *Email:* `$email`\n"
              . "📝 *Сообщение:*\n$message";

        $keyboard = [
            "inline_keyboard" => [
                [["text" => "📥 Ответить", "url" => "mailto:$email"]],
                [["text" => "🌐 Перейти на сайт", "url" => "https://church-costroma.ru"]]
            ]
        ];

        $data = [
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'Markdown',
            'reply_markup' => json_encode($keyboard)
        ];

        file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query($data));
    }

    echo "Спасибо, ваше сообщение отправлено!";
}
?>
