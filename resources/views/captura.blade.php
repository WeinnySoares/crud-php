<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="{{route('insert')}}" method="post">
    @csrf
   <input type="text" name="search" placeholder="Digite aqui para buscar ..">
   <button type="submit">Capturar</button>
</form>
</body>
</html>

