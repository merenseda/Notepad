<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta lang="tr">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <title><?= isset($pageTitle) ? $pageTitle : 'Notpad' ?></title>
    <link rel="icon" href="../public/image/favicon.ico" type="image/x-icon">
</head>

<!-- Menu -->
<main class="container bg-light text-light col-md-10 rounded mt-2 mb-1 p-2">
    <nav class="d-flex justify-content-between align-items-center">
        <b class="text-left" style="font-size: 1.2rem; font-weight: 600; color: black;">
            <?= isset($pageTitle) ? $pageTitle : 'Notpad' ?>
        </b>
        <div>
            <a href="../views/noteAdd.php" class="mx-3 text-black" style="font-size: 1.1rem;">Ekle</a>
            <a href="../views/noteList.php" class="mx-3 text-black" style="font-size: 1.1rem;">Notlarım</a>
        </div>
    </nav>
</main>
<!-- /Menu -->


<body class="bg-dark text-light">
    <main class="container bg-light text-light col-md-10 rounded mb-1">
        <div class="row justify-content-center">
            <!-- Page Content -->
            <?= $content ?>
            <!-- /Page Content -->
        </div>
    </main>
</body>

<!-- Footer -->
<div class="container col-md-10 border border-white rounded">
    <div class="row justify-content-center">
        <footer class="bg-dark text-white mt-3 footer mt-auto">
            <div class="container p-4">
                <div class="row">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <p class="mb-0">&copy; 2021 Süslü Parantez. Tüm Hakları Saklıdır.</p>
                    </div>
                    <div class="col-md-6 mb-4 mb-md-0">
                        <div class="d-flex justify-content-center justify-content-md-end">
                            <a href="https://facebook.com" target="_blank" class="text-white me-4" title="Facebook">
                                <i class="fab fa-facebook-f fa-lg"></i>
                            </a>
                            <a href="https://twitter.com" target="_blank" class="text-white me-4" title="Twitter">
                                <i class="fab fa-twitter fa-lg"></i>
                            </a>
                            <a href="https://instagram.com" target="_blank" class="text-white me-4" title="Instagram">
                                <i class="fab fa-instagram fa-lg"></i>
                            </a>
                            <a href="https://linkedin.com" target="_blank" class="text-white" title="LinkedIn">
                                <i class="fab fa-linkedin-in fa-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<!-- /Footer -->

<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="../assets/js/script.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
</body>

</html>