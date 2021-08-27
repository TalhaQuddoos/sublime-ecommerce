<?php

require_once("__func__.php");

$username = $_SESSION['user'] ?? null;
if ($username) {
    $redirect_to = $_GET['return'] ?? "/cart";
    header("Location: $redirect_to");
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $registered = $Auth->register();
    if ($registered) {
        $redirect_to = "/login";
        header("Location: $redirect_to");
    } else {
        header("Location: ".$_SERVER['PHP_SELF']."?error");
    }
} else {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Register - Sublime</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.markuptag.com/bootstrap/5/css/bootstrap.min.css">
    </head>

    <body>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-4 offset-md-4">
                    <div class="login-form bg-light mt-4 p-4">
                        <form action="" method="POST" class="row g-3">
                            <h4>Register</h4>
                            <?php if (isset($_GET['error'])) { ?>
                                <div class="alert alert-danger mb-0">Invalid username or password.</div>
                            
                            <?php } ?>
                            <div class="col-12">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control form-control-lg" placeholder="Name">
                            </div>
                            <div class="col-12">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control form-control-lg" placeholder="Username">
                            </div>
                            <div class="col-12">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control form-control-lg" placeholder="Password">
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe"> Remember me</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary float-end">Signup</button>
                            </div>
                        </form>
                        <hr class="mt-4">
                        <div class="col-12">
                            <p class="text-center mb-0">Already have account? <a href="/login">Login</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://www.markuptag.com/bootstrap/5/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>

<?php } ?>