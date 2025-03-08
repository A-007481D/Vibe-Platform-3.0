<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Invitation</title>
</head>

<body>
    <h1>QR Code généré avec succès</h1>
    <p>Scannez ce QR code pour rejoindre :</p>
    <img src="{{ $qrImage }}" alt="QR Code">
    <p>Ou cliquez sur le lien suivant pour accepter l'invitation : <a
            href="{{ route('invitation.accept', ['token' => $qrcode->token]) }}">Accepter l'invitation</a></p>
</body>

</html>
