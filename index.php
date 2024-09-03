<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Problema de las N Reinas</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <h1>Resolver el Problema de las N Reinas</h1>

    <form method="POST" action="">
        <label for="nReinas">Número de Reinas (N):</label>
        <input type="number" id="nReinas" name="nReinas" min="4" required>
        <button type="submit">Resolver</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nReinas'])) {
        $n = intval($_POST['nReinas']);
        $soluciones = [];
        $tablero = array_fill(0, $n, array_fill(0, $n, 0));

        function esSeguro($tablero, $fila, $columna, $n)
        {
            for ($i = 0; $i < $fila; $i++) {
                if ($tablero[$i][$columna] == 1) {
                    return false;
                }
            }

            for ($i = $fila, $j = $columna; $i >= 0 && $j >= 0; $i--, $j--) {
                if ($tablero[$i][$j] == 1) {
                    return false;
                }
            }

            for ($i = $fila, $j = $columna; $i >= 0 && $j < $n; $i--, $j++) {
                if ($tablero[$i][$j] == 1) {
                    return false;
                }
            }

            return true;
        }

        function resolverNReinas($tablero, $fila, $n, &$soluciones)
        {
            if ($fila == $n) {
                $soluciones[] = $tablero;
                return;
            }

            for ($columna = 0; $columna < $n; $columna++) {
                if (esSeguro($tablero, $fila, $columna, $n)) {
                    $tablero[$fila][$columna] = 1;
                    resolverNReinas($tablero, $fila + 1, $n, $soluciones);
                    $tablero[$fila][$columna] = 0;
                }
            }
        }

        resolverNReinas($tablero, 0, $n, $soluciones);

        echo "<h2>Soluciones para $n Reinas:</h2>";
        echo "<div class='container'>";
        if (!empty($soluciones)) {
            foreach ($soluciones as $index => $solucion) {
                echo "<div class='solucion'>";
                echo "<h3>Solución " . ($index + 1) . "</h3>";
                
                echo "<table>";
                for ($i = 0; $i < $n; $i++) {
                    echo "<tr>";
                    for ($j = 0; $j < $n; $j++) {
                        $color = (($i + $j) % 2 == 0) ? "blanco" : "negro";
                        $reina = $solucion[$i][$j] == 1 ? "<span class='reina'>♛</span>" : "";
                        echo "<td class='$color'>$reina</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<p>No se encontraron soluciones para $n reinas.</p>";
        }
    }
    ?>
</body>

</html>
