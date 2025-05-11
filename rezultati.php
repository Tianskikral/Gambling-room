<?php
session_start();

$imena = [$_POST['player1'], $_POST['player2'], $_POST['player3']];
$stKock = (int)$_POST['stevilokock'];
$steviloIger = (int)$_POST['steviloiger'];
$rezultati = [];
$zmagovalci = [];

foreach ($imena as $ime) {
    $vsota = 0;
    $slike = [];

    for ($igra = 0; $igra < $steviloIger; $igra++) {
        for ($i = 0; $i < $stKock; $i++) {
            $met = rand(1, 6);
            $vsota += $met;
            $slike[] = "slike/dice$met.gif";
        }
    }

    $rezultati[] = [
        'ime' => htmlspecialchars($ime),
        'vsota' => $vsota,
        'kocke' => $slike
    ];
}

$najvisja = max(array_column($rezultati, 'vsota'));
foreach ($rezultati as $rezultat) {
    if ($rezultat['vsota'] === $najvisja) {
        $zmagovalci[] = $rezultat;
    }
}
?>

<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <title>Rezultati igre</title>
    <link rel="stylesheet" href="style.css">
    <meta http-equiv="refresh" content="10; url=Index.html" />
    <style>
        body {
            background: #121212;
            color: #87ffff;
            font-family: 'Courier New', monospace;
            text-align: center;
        }

        h1 {
            color: orange;
            margin-top: 30px;
        }

        .rezultat-container {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .rezultat {
            background-color: #1e1e1e;
            padding: 20px;
            border-radius: 10px;
            border: 2px solid orange;
            width: 200px;
            text-align: center;
        }

        .dice-row {
            display: flex;
            justify-content: center;
            gap: 5px;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }

        img {
            height: 40px;
            margin: 5px;
        }

        @keyframes shake {
            0% { transform: rotate(0deg); }
            25% { transform: rotate(10deg); }
            50% { transform: rotate(-10deg); }
            75% { transform: rotate(10deg); }
            100% { transform: rotate(0deg); }
        }

        img.shake {
            animation: shake 0.5s ease-in-out;
        }
    </style>
</head>
<body>
    <h1>Rezultati igre</h1>

    <div class="rezultat-container">
        <?php foreach ($rezultati as $rezultat): ?>
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
    <?php foreach ($zmagovalci as $zmagovalec): ?>
        <p><?= $zmagovalec['ime'] ?> (<?= $zmagovalec['vsota'] ?>)</p>
    <?php endforeach; ?>

    <p>Preusmeritev na začetno stran v 10 sekundah...</p>

    <audio id="diceSound" src="https://www.myinstants.com/media/sounds/dice-roll.mp3"></audio>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const sound = document.getElementById('diceSound');
            sound.play().catch(e => console.log("Zvok ni predvajan:", e));
        });
    </script>
</body>
</html>
