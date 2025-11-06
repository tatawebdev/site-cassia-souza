<!-- messages.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <link rel="stylesheet" href="path/to/your/css/style.css"> <!-- Substitua com o caminho correto -->
</head>
<body>
    <div class="container">
        <h1>Messages</h1>
        <!-- Área para listar as mensagens -->
        <div class="messages-list">
            <?php if (!empty($messages)) : ?>
                <ul>
                    <?php foreach ($messages as $message) : ?>
                        <li>
                            <strong><?php echo $message['sender']; ?>:</strong> 
                            <?php echo $message['content']; ?>
                            <span class="timestamp"><?php echo $message['timestamp']; ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p>No messages to display.</p>
            <?php endif; ?>
        </div>

        <!-- Formulário para enviar uma nova mensagem -->
        <div class="message-form">
            <form action="/send-message" method="POST">
                <label for="message">Send a message:</label>
                <textarea id="message" name="message" rows="4" placeholder="Type your message here"></textarea>
                <button type="submit">Send</button>
            </form>
        </div>
    </div>
</body>
</html>
