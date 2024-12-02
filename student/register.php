<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration | Student</title>

    <link rel="stylesheet" href="../css/bootstrap.css" />
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row d-flex justify-content-center align-items-center">

                    <div class="col-12 col-md-6 p-5 border bg-white mt-5">

                        <h1 class="text-center mb-3">Student Registration</h1>
                        <h4 class="">Welcome</h4>
                        <span class="text-danger" id="msg"></span>
                        <div>
                            <label for="">First Name</label>
                            <input class="form-control mb-3" placeholder="First Name" id="fname" type="text" />
                        </div>
                        <div>
                            <label for="">Last Name</label>
                            <input class="form-control mb-3" placeholder="Last Name" id="lname" type="text" />
                        </div>
                        <div>
                            <label for="">Email</label>
                            <input class="form-control mb-3" placeholder="Email" id="email" type="text" />
                        </div>
                        <div>
                            <label for="">Password</label>
                            <input class="form-control mb-3" placeholder="Password" id="password" type="password" />
                        </div>
                        <a class="mb-4" href="login.php">Already Have An Account.</a>
                        <button onclick="signUp();" class="btn btn-success w-100 my-3">Register New Student</button>

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