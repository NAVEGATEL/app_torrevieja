<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter</title>
</head>
<body>
    <div>
        {!! $body !!}
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
         <!-- Enlace de desuscripción -->
        <p>Para darte de baja del boletín, haz clic en el siguiente enlace:</p>
        <a href="{{ $unsubscribeLink }}">Desuscribirse</a>
    </div>
</body>
</html>
