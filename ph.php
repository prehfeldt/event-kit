<?php

declare(strict_types=1);

$result = json_decode(file_get_contents('https://get.api-feiertage.de/?states=nw'), true);

$weekDays = [
    1 => 'Montag',
    2 => 'Dienstag',
    3 => 'Mittwoch',
    4 => 'Donnerstag',
    5 => 'Freitag',
    6 => 'Samstag',
    7 => 'Sonntag'
];

$lastYear = null;
?>
<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Public Hollidays NRW</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="events.png">

        <style>
            * { font-family: Sans-Serif; }
            :root { color-scheme: light dark; }
            body { color: #fff; background-color: #1b1b1b; }
            .good { color: #AEE85D; }
            .bad { color: #99171d; }
        </style>
    </head>
    <body>
        <?php foreach ($result['feiertage'] as $feiertag): ?>
            <?php
            $date = new DateTime($feiertag['date']);
            if ($date->format('Y') !== $lastYear) {
                echo sprintf('<h2>%s</h2>', $date->format('Y'));
                $lastYear = $date->format('Y');
            }

            $class = 'good';
            if ($date->format('N') > 5) {
                $class = 'bad';
            }

            echo sprintf(
                '<div class="%s">%s (%s): %s</div>',
                $class,
                $feiertag['fname'],
                $date->format('d.m.Y'),
                $weekDays[$date->format('N')]
            );
            ?>
        <?php endforeach; ?>

        <br>
        <a href="events.php">&lt; Event Countdown</a>
    </body>
</html>
