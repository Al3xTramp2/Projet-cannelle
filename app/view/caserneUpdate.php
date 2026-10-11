<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier une caserne</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>

<body>
<nav class="navbar navbar-expand-lg bg-danger" data-bs-theme="dark">
    <div class="container">
        <a class="navbar-brand" href="index.php?c=default&amp;a=home">Cannelle</a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#menu"
                aria-controls="menu" aria-expanded="false"
                aria-label="Afficher le menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?c=pompier&amp;a=show">Pompiers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page"
                       href="index.php?c=caserne&amp;a=show">Casernes</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container my-4">
    <h1 class="h3 mb-3">
        Modifier la caserne n° {{ $caserne->getNumCaserne() }}
    </h1>

    <form method="post" action="index.php" class="row g-3">
        <input type="hidden" name="c" value="caserne">
        <input type="hidden" name="a" value="doUpdate">
        <input type="hidden" name="numCaserne"
               value="{{ $caserne->getNumCaserne() }}">

        <div class="col-md-6">
            <label for="adresse" class="form-label">Adresse</label>
            <input type="text" class="form-control" id="adresse"
                   name="adresse" maxlength="15" value="{{ $caserne->getAdresse() }}" required>
        </div>

        <div class="col-md-6">
            <label for="ville" class="form-label">Ville</label>
            <input type="text" class="form-control" id="ville"
                   name="ville" maxlength="20" value="{{ $caserne->getVille() }}" required>
        </div>

        <div class="col-md-6">
            <label for="cp" class="form-label">Code postal</label>
            <input type="text" class="form-control" id="cp"
                   name="cp" inputmode="numeric" maxlength="5" pattern="[0-9]{5}"
                   title="5 chiffres" value="{{ $caserne->getCP() }}" required>
        </div>

        <div class="col-md-6">
            <label for="codeTypeC" class="form-label">Type de caserne</label>
            <select class="form-select" id="codeTypeC" name="codeTypeC">
                @foreach($types as $code => $nom)
                <option value="{{ $code }}" {{ $caserne->getCodeTypeC() === $code ? "selected" : "" }}>{{ $nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-danger">Enregistrer</button>
            <a class="btn btn-outline-secondary"
               href="index.php?c=caserne&amp;a=detail&amp;numCaserne={{ $caserne->getNumCaserne() }}">Annuler</a>
        </div>
    </form>
</main>

<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
