<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Teacher</title>

    <link rel="stylesheet" href="../css/bootstrap.css" />
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row d-flex justify-content-center align-items-center" style="height: 100vh;">

                    <div class="col-12 col-md-6 p-5 border bg-white">

                        <h1 class="text-center mb-3">Teacher Log In</h1>
                        <h4 class="">Welcome Back</h4>
                        <span class="text-danger" id="msg"></span>
                        <input class="form-control mb-3" placeholder="Email" id="email" type="text" />
                        <input class="form-control" placeholder="Password" id="password" type="password" />
                        <a class="mb-4" href="register.php">create New Account.</a>
                        <button onclick="signIn();" class="btn btn-success w-100 my-3">Log In</button>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="../js/bootstrap.bundle.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="js/script.js"></script>
</body>

</html>