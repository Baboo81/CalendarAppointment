<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./assets/styles/normalize.css">
        <link rel="stylesheet" href="./assets/styles/bootstrap.min.css">
        <link rel="stylesheet" href="./assets/styles/calendar.css">
        <script src="./assets/scripts/bootstrap.bundle.min.js" defer></script>
        <title>Calendar appointment</title>
    </head>
    <body>
        <section>
                <!--Construction du calendrier-->
                <section id="calendarBloc" class="p-4">
                    <nav class="navbar navbar-dark mb-3">
                        <a class="text-align center mx-4" href="/index.php" class="navbar-brand">Agenda</a>
                    </nav>

                    <?php 
                        require './assets/source/Month.php';
                        
                        $month =new App\Date\Month($_GET['month'] ?? null, $_GET['year']  ?? null); 
                    
                    
                        $start = $month->getStartingDay();
                        $start = $start->format('N') === '1' ? $start : $month->getStartingDay()->modify('last monday');
                        
                    ?>
                    <!--Btn nav calendrier-->
                    <div class="d-flex flex-row align-items-center justify-content-between mx-3">
                        <h1><?= $month->toString(); ?></h1>
                        <div>
                            <a href="/index.php?month=<?= $month->prevMonth()->month; ?>&year=<?= $month->prevMonth()->year; ?>" class="btn btn-secondary">&lt;</a>
                            <a href="/index.php?month=<?= $month->nextMonth()->month; ?>&year=<?= $month->nextMonth()->year; ?>" class="btn btn-secondary">&gt;</a>
                        </div>
                    </div>
                    

                    <!--Pour le nb de semaines-->
                    <?= $month->getWeeks(); ?>

                    <table class="calendarTable calendarTable--<?= $month->getWeeks(); ?>weeks">
                        <?php for ($i = 0; $i < $month->getWeeks(); $i++): ?>
                            <tr>
                                <?php 
                                    foreach($month->days as $k => $day): //Je part du mois et récupère les jours
                                    $date = (clone $start)->modify( "+" . ($k + $i * 7) . "days")
                                ?>
                                <td class="<?= $month->withinMonth($date) ? '' : 'calendarOtherMonth'; ?>">
                                    <?php if ($i === 0): ?>
                                        <div class="calendarWeekDay"><?= $day; ?></div>
                                    <?php endif; ?>
                                    <div class="calendarDay"><?= $date->format('d');?></div>
                                </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endfor; ?>
                    </table>           
                </section>
            </section>
            <!--Calendar END-->
    </body>
</html>