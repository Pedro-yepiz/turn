<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Turn</title>
</head>
<body>
    <p>Detalles:</p>
    <ul>
        <li><strong>Nombre:</strong> <em>{{ $nombre }}</em></li>
        <li><strong>Email:</strong> <em>{{ $email }}</em></li>
        <li><strong>Teléfono:</strong> <em>{{ $telefono }}</em></li>
        <li><strong>Asunto:</strong> <em>{{ $asunto }}</em></li>
        <li><strong>Hora de envio:</strong> <em>{{ $created_at }}</em></li>

    </ul>
</body>
</html>