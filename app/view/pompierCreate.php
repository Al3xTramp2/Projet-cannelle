<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nouveau pompier</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-danger" data-bs-theme="dark">
    <div class="container">
        <a class="navbar-brand" href="index.php?c=default&amp;a=home">Cannelle</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Afficher le menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php?c=pompier&amp;a=show">Pompiers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?c=caserne&amp;a=show">Casernes</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<main class="container my-4">
    <h1 class="h3 mb-3">Nouveau pompier</h1>
    <form method="post" action="index.php" class="row g-3">
        <input type="hidden" name="c" value="pompier">
        <input type="hidden" name="a" value="doCreate">

        <div class="col-md-6">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" maxlength="10" required>
        </div>
        <div class="col-md-6">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" maxlength="20" required>
        </div>
        <div class="col-md-6">
            <label for="dateNaissance" class="form-label">Date de naissance</label>
            <input type="date" class="form-control" id="dateNaissance" name="dateNaissance" required>
        </div>
        <div class="col-md-6">
            <label for="chefAgret" class="form-label">Chef d'agrès</label>
            <select class="form-select" id="chefAgret" name="chefAgret">
                <option value="N">Non</option>
                <option value="O">Oui</option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="codeGrade" class="form-label">Grade</label>
            <select class="form-select" id="codeGrade" name="codeGrade">
                @foreach($grades as $code => $nom)
                <option value="{{ $code }}">{{ $nom }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="numCaserne" class="form-label">Caserne</label>
            <select class="form-select" id="numCaserne" name="numCaserne">
                @foreach($casernes as $caserne)
                <option value="{{ $caserne->getNumCaserne() }}">{{ $caserne->getVille() }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="matriculeRespo" class="form-label">Matricule du responsable</label>
            <input type="text" class="form-control" id="matriculeRespo" name="matriculeRespo" maxlength="7" required>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-danger">Enregistrer</button>
            <a class="btn btn-outline-secondary" href="index.php?c=pompier&amp;a=show">Annuler</a>
        </div>
    </form>
</main>
<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
