<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <p>Resultado de Processamento</p>
    <p>Código de retorno {{$categorias->status}}</p>{{-- propriedade --}}
    <p>Mensagem: {{$categorias->mensagem}}</p>

    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
        </tr>
        @foreach ($categorias->categorias as $categoria)
            <tr>
                <th>{{$categoria->id}}</th>
                <th>{{$categoria->nome_da_categoria}}</th>
            </tr>
        @endforeach
    </table>
</body>
</html>