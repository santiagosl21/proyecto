<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehiculos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <h1>Hello, world!</h1>
    <table class="table table-hover">
        <thead>
            <tr>
                <td>id</td>
                <td>Marca</td>
                <td>Modelo</td>
                <td>Tipo</td>
                <td>Placa</td>
                <td>...</td>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($vehiculos as $vehiculo) {
                    echo '<tr>';
                    echo '<td>'. $vehiculo["id"] .'</td>';
                    echo '<td>'. $vehiculo["marca"] .'</td>';
                    echo '<td>'. $vehiculo["modelo"] .'</td>';
                    echo '<td>'. $vehiculo["tipo"] .'</td>';
                    echo '<td>'. $vehiculo["placa"] .'</td>';
                    echo '<td>
                    <button type="button" class="btn btn-warning">Editar</button>
                    <button type="button" class="btn btn-danger">Eliminar</button>

                    <td/>';
                    echo '</tr>';
                }
            ?>
        </tbody>

    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>