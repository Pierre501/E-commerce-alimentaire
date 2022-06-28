<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../../images/favicon.png">
    <link href="../../css/bootstrap.css" rel="stylesheet">
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<section class="vh-100 bg-dark">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">
            <h1 class="mb-4">Login</h1>
            <p style="color: red;"><?php if(isset($_GET['erreur'])) { echo "Oups! Veiullez réessayez s'il vous plait!"; } ?></p>
            <form action="traitement.php" method="post">
              <div class="form-outline mb-4">
                <input type="email" name="username" id="typeEmailX-2" class="form-control form-control-md" />
                <label class="form-label" for="typeEmailX-2">Nom d'utilisateur</label>
              </div>
              <div class="form-outline mb-4">
                <input type="password" name="motdepasse" id="typePasswordX-2" class="form-control form-control-md" />
                <label class="form-label" for="typePasswordX-2">Mot de passe</label>
              </div>
              <div class="form-check d-flex justify-content-start mb-4">
                <input class="form-check-input" type="checkbox" value="" id="form1Example3" />
                <label class="form-check-label" for="form1Example3">Mot de passe oublié ?</label>
              </div>
              <input type="submit" class="btn btn-primary btn-lg btn-block" value="Se connecter" />
            </form>
            <hr class="my-4">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>