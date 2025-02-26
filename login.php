<?php
session_start();
$conn = new mysqli("localhost", "root", "", "db_bioskop");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($name, $hashed_password);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $name;
            header("Location: index2.php");
            exit();
        } else {
            $error_message = "Password salah.";
        }
    } else {
        $error_message = "Email tidak terdaftar.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                        <div class="col-lg-6 d-none d-lg-block text-center">
                         <img src="cozacinema.webp" alt="Login Image" class="img-fluid w-100 h-100" style="object-fit: cover;">
                         </div>
 

                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form method="POST" action="login.php">
<div class="mb-3">
<label for="exampleInputEmail1" class="form-label">Email</label>
<input type="email" class="form-control"
id="exampleInputEmail1" name="email" required>
</div>
                                   <div class="mb-4">
                                  <label for="exampleInputPassword1" class="form-label">Password</label>
                                  <input type="password" class="form-control" id="exampleInputPassword1" name="password" required>
                                  </div>
<div class="d-flex align-items-center justify-content-between mb-4">
<div class="form-check">
<label class="form-check-label text-dark"
for="flexCheckChecked">
</label>
</div>
<a class="text-primary fw-bold" href="register.php">Create an Account!</a>
</div>
<button type="submit" name="login" class="btn btn-primary w-100 py-8 fs-4 mb-4">Sign In</button>
<?php if (isset($error_message)): ?>
<div class="alert alert-danger" role="alert">
<?php echo $error_message; ?>
</div>
<?php endif; ?>
</form>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>