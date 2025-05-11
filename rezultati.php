<?php
session_start();

$imena = [$_POST['player1'], $_POST['player2'], $_POST['player3']];
$stKock = (int)$_POST['stevilokock'];
$steviloIger = (int)$_POST['steviloiger'];

$rezultati = [];
$zmagovalci = [];

// Zapiši v sejo vhodne podatke
$_SESSION['igralci'] = $imena;
$_SESSION['kocke'] = $stKock;
$_SESSION['igre'] = $steviloIger;

foreach ($imena as $ime) {
    $vsota = 0;
    $slike = [];

    for ($igra = 0; $igra < $steviloIger; $igra++) {
        for ($i = 0; $i < $stKock; $i++) {
            $met = rand(1, 6);
            $vsota += $met;
            $slike[] = "dice$met.gif";
        }
    }

    $rezultati[] = [
        'ime' => htmlspecialchars($ime),
        'vsota' => $vsota,
        'kocke' => $slike
    ];
}

$_SESSION['rezultati'] = $rezultati;

$najvisja = max(array_column($rezultati, 'vsota'));
foreach ($rezultati as $rezultat) {
    if ($rezultat['vsota'] === $najvisja) {
        $zmagovalci[] = $rezultat;
    }
}

$_SESSION['zmagovalci'] = $zmagovalci;
?>

<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <title>Rezultati igre</title>
    <link rel="stylesheet" href="style.css">
    <meta http-equiv="refresh" content="10; url=Index.html" />
</head>
<body>
    <h1>Rezultati igre</h1>

    <div class="rezultat-container">
        <?php foreach ($_SESSION['rezultati'] as $rezultat): ?>
            <div class="rezultat">
                <h3><?= $rezultat['ime'] ?></h3>
                <div class="dice-row">
                    <?php foreach ($rezultat['kocke'] as $kocka): ?>
                        <img src="<?= $kocka ?>" alt="kocka" class="shake">
                    <?php endforeach; ?>
                </div>
                <p><strong>Skupaj:</strong> <?= $rezultat['vsota'] ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <h2>Zmagovalec/ci:</h2>
    <?php foreach ($_SESSION['zmagovalci'] as $zmagovalec): ?>
        <p><?= $zmagovalec['ime'] ?> (<?= $zmagovalec['vsota'] ?>)</p>
    <?php endforeach; ?>

    <p>Preusmeritev na začetno stran v 10 sekundah...</p>

    <audio id="diceSound" src="https://www.myinstants.com/media/sounds/dice-roll.mp3"></audio>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const sound = document.getElementById('diceSound');
            sound.play().catch(() => {});
        });
    </script>
</body>
</html>
