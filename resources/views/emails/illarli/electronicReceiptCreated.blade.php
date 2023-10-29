<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro exitoso en ILLARLI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chivo+Mono:ital,wght@0,100;1,100&family=Montserrat&display=swap"
        rel="stylesheet">
</head>

<body>
    <h1>
        HOLA! -
        {{ $client_name }}
    </h1>
    <h1>Se ha generado su -
        {{ $electronic_receipt_type }}
    </h1>
    <h1>Emitida por -
        {{ $document_name_emissor }}
    </h1>
    <h1>
        Nº Documento -
        {{ $document_number }}
    </h1>
    <h1>Por el valor de -
        {{ $total }}
    </h1>
</body>

</html>
