<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier un pompier</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-danger" data-bs-theme="dark">
    <div class="container">
        <a class="navbar-brand" href="/default/home">Cannelle</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Afficher le menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/pompier/liste">Pompiers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/caserne/liste">Casernes</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<main class="container my-4">
    <h1 class="h3 mb-3">Modifier {{ $pompier->getMatricule() }}</h1>
    <form method="post" action="/pompier/update" class="row g-3">
        <input type="hidden" name="matricule" value="{{ $pompier->getMatricule() }}">

        <div class="col-md-6">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" maxlength="10" value="{{ $pompier->getPrenom() }}" required>
        </div>
        <div class="col-md-6">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" maxlength="20" value="{{ $pompier->getNom() }}" required>
        </div>
        <div class="col-md-6">
            <label for="dateNaissance" class="form-label">Date de naissance</label>
            <input type="date" class="form-control" id="dateNaissance" name="dateNaissance" value="{{ $pompier->getDateNaissance()->format("Y-m-d") }}" required>
        </div>
        <div class="col-md-6">
            <label for="chefAgret" class="form-label">Chef d'agrès</label>
            <select class="form-select" id="chefAgret" name="chefAgret">
                <option value="N" {{ $pompier->getChefAgret() === "N" ? "selected" : "" }}>Non</option>
                <option value="O" {{ $pompier->getChefAgret() === "O" ? "selected" : "" }}>Oui</option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="codeGrade" class="form-label">Grade</label>
            <select class="form-select" id="codeGrade" name="codeGrade">
                @foreach($grades as $code => $nom)
                <option value="{{ $code }}" {{ $pompier->getCodeGrade() === $code ? "selected" : "" }}>{{ $nom }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="numCaserne" class="form-label">Caserne</label>
            <select class="form-select" id="numCaserne" name="numCaserne">
                @foreach($casernes as $caserne)
                <option value="{{ $caserne->getNumCaserne() }}" {{ $pompier->getNumCaserne() === $caserne->getNumCaserne() ? "selected" : "" }}>{{ $caserne->getVille() }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="matriculeRespo" class="form-label">Matricule du responsable</label>
            <input type="text" class="form-control" id="matriculeRespo" name="matriculeRespo" maxlength="7" value="{{ $pompier->getMatriculeRespo() }}" required>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-danger">Enregistrer</button>
            <a class="btn btn-outline-secondary" href="/pompier/matricule/{{ $pompier->getMatricule() }}">Annuler</a>
        </div>
    </form>
</main>
<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
