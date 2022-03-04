<?php

    $dineroInicial = isset($_GET["inicial"]) ? intval($_GET["inicial"]) : 0;
    $adicionAnual = isset($_GET["adicion"]) ? intval($_GET["adicion"]) : 0;
    $anios = isset($_GET["years"]) ? intval($_GET["years"]) : 0;
    $interesAnual = isset($_GET["interes"]) ? intval($_GET["interes"]) : 0;

    $total = $dineroInicial;
    $totalSinInversion = $dineroInicial;
    $sinInversionArray = [];

    for ($i=1; $i <= $anios; $i++) {
        $total =  $total + $adicionAnual;
        $total = $total + ($total*$interesAnual/100);
        $valoresCrecientes[$total] = number_format($total, 2);
    }

    for ($i = 1; $i <= $anios; $i++) {
        $totalSinInversion = $totalSinInversion + $adicionAnual;
        $sinInversionArray[$totalSinInversion] = $totalSinInversion;
    }

    $valoresCrecientes[$total] = number_format($total, 2);

    $total = number_format($total, 2);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graficas</title>
    <link rel="stylesheet" href="./styles.css?v1">
</head>
<body>

    <h1>Calculadora De Interes Compuesto</h1>

    <form class="form-container" method="GET">
        <div class="form-item">
            <label for="inicial">Capital Inicial</label>
            <input name="inicial" id="inicial" type="text" value=<?php echo $dineroInicial ?>>
        </div>
        <div class="form-item">
            <label for="adicion">Adicción Anual</label>
            <input name="adicion" id="adicion" type="text" value=<?php echo $adicionAnual ?>>
        </div>
        <div class="form-item">
            <label for="years">Años</label>
            <input name="years" id="years" type="text" value=<?php echo $anios ?>>
        </div>
        <div class="form-item">
            <label for="interes">Tasa De Interés Anual (%)</label>
            <input name="interes" id="interes" type="text" value=<?php echo $interesAnual ?>>
        </div>
        <div class="submit-container">
            <input class="submit" type="submit" value="Calcular">
        </div>
    </form>

    <h2 style="display: <?php echo $anios ? "block" : "none"?>;" class="valor-final">Balance Final: $<?php echo $total ? $total : "00.00"?></h2>
    <canvas style="display: <?php echo $anios ? "block" : "none"?>;" id="myChart" width="400" height="100"></canvas>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    let labelsAños = [];
    let labelsValores = [];
    let valoresSinInversion = [];

    for (let index = 1; index < <?php echo $anios+1 ?>; index++) {
        labelsAños.push(`Año ${index}`);
    }
    <?php
        foreach ($valoresCrecientes as $key => $value) {
    ?>
        labelsValores.push(<?php echo $key ?>);
    <?php
        }
    ?>

    <?php
        foreach ($sinInversionArray as $key => $value) {
    ?>
        valoresSinInversion.push(<?php echo $key ?>);
    <?php
        }
    ?>

console.log(labelsValores, valoresSinInversion);
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labelsAños,
            datasets: [{
                label: 'Crecimiento Del Interes Compuesto:',
                data: labelsValores,
                fill: false,
                backgroundColor:'white',
                borderColor: "#3FA0EF",
                borderWidth: 2
                },
                {
                label: 'Crecimiento Del Capital Sin Interes:',
                data: valoresSinInversion,
                fill: false,
                backgroundColor: 'white',
                borderColor: "red",
                borderWidth: 2
                }]
            },
            options: {
            legend: {
                    display: true,
                    position: 'top',
                    labels: {
                    boxWidth: 80,
                    fontColor: 'black'
                    }
                }
            }
        });
    </script>
</body>
</html>