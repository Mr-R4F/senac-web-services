<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <table border="1">
            <tr>
                <td>id</td>
                <td>nome</td>
                <td>idade</td>
            </tr>

            @foreach ($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->id}} </td>
                    <td>{{ $cliente->nome }}</td>
                    <td>{{ $cliente->idade }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</body>
</html>