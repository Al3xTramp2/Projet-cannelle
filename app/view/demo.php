<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demo</title>
</head>
<body>
<h1>Bonjour {{ $nom }}</h1>

@if($age >= 18)
<p>Majeur</p>
@else
<p>Mineur</p>
@endif

<ul>
    @foreach($casernes as $numero => $ville)
    <li>Caserne {{ $numero }} : {{ $ville }}</li>
    @endforeach
</ul>
</body>
</html>