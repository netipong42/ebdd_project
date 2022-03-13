<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../assets/img/logo.png" type="image/x-icon">
    <?php require_once("../template/linkheader.php") ?>
    <title>Admin</title>
</head>

<body class="bg-gradient-danger">

    <!-- content -->
    <div class="container">

        <!-- Outer Row -->
        <div class="row  min-vh-100 d-flex justify-content-center align-items-center p-5">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-lg-block ">
                                <img src="../../assets/img/logo.png" alt="" class="img-fluid mt-3 p-3">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Admin</h1>
                                    </div>
                                    <form class="user" action="../../server/login.php" method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" placeholder="Enter Username" name="user" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" placeholder="Password" name="pass" required>
                                        </div>
                                        <button type="submit" class="btn btn-success btn-user btn-block">Login</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <!-- content -->
    <?php require_once("../template/footer.php") ?>
    <?php require_once("../template/linkfooter.php") ?>
</body>

</html>