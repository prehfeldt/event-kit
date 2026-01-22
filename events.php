<?php
$events = json_decode(file_get_contents(__DIR__ . '/events.json'), true);

if (date('w') < 5) {
    $events['Freitag'] = (new DateTime())->add(new DateInterval(sprintf('P%sD', 5 - date('w'))))->format('d.m.Y');
}
uasort($events, function ($a, $b) {
    return strtotime($a) - strtotime($b);
});

$now = new DateTime();
?>
<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Event Countdown</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="events.png">

        <style>
            * { font-family: Sans-Serif; }
            :root { color-scheme: light dark; }
            body { color: #fff; background-color: #1b1b1b; }
            thead { font-weight: bold }
            table, thead, tfoot, th, td { border: 1px solid grey; border-collapse: collapse; padding: 3px; }
            .days { text-align: right }
            .events { margin: 0 auto; }
        </style>
    </head>
    <body>
        <table class="events">
            <thead>
                <tr>
                    <th>Event</th>
                    <th>Datum</th>
                    <th>Tage bis Start</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $name => $date): ?>
                    <?php
                    $startDate = new DateTime($date);
                    if ($now > $startDate) continue;
                    $diff = $startDate->diff($now);

                    $daysTitle = sprintf(
                        '%d Wochen, %d Tage',
                        floor(($diff->days + 1) / 7),
                        ($diff->days + 1) % 7
                    );
                    ?>
                    <tr>
                        <td><?php echo preg_replace('/(\*)(.*?)\1/', '<strong>\2</strong>', $name); ?></td>
                        <td title="<?php echo $startDate->format('l'); ?>">
                            <?php echo $startDate->format('d.m.Y'); ?>
                        </td>
                        <td class="days" title="<?php echo $daysTitle; ?>">
                            <?php echo $diff->days + 1; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </body>
</html>
