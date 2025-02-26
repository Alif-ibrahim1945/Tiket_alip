<?php
// Menyertakan autoloader Composer
require '../vendor/autoload.php'; // Pastikan pathnya sesuai dengan struktur project Anda
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
// Inisialisasi variabel untuk menyimpan input
$name = '';
$email = '';
$password = '';
if (isset($_POST['send_otp'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    // Simpan password di session
    $_SESSION['password'] = $password;
    // Generate OTP
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['email'] = $email;
    $_SESSION['name'] = $name;
    $_SESSION['otp_sent_time'] = time(); // Store the time OTP was sent
    // Kirim email OTP
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'storealipp22@gmail.com';
        $mail->Password = 'ajqg abpv vyuo tcxm'; // Gunakan App Password jika 2FA aktif
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Untuk port 465
        $mail->Port = 465; // Port untuk SSL
        $mail->setFrom('storealipp22@gmail.com', 'COZACINEMA');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'OTP Verifikasi Akun';
        $mail->Body = "Hai $name, <br> Berikut adalah kode OTP Anda: 
<b>$otp</b>.<br>Kode ini berlaku selama 15 menit.";
        $mail->send();
        $otp_sent = true; // Set flag untuk menampilkan SweetAlert
    } catch (Exception $e) {
        echo "Gagal mengirim email: {$mail->ErrorInfo}";
    }
}
if (isset($_POST['verify_otp'])) {
    $otp_input = $_POST['otp'];
    // Check if OTP is valid and not expired (15 minutes)
    if ($otp_input == $_SESSION['otp'] && (time() - $_SESSION['otp_sent_time'] <
        900)) {
        // OTP valid, simpan data pengguna ke database
        $name = $_SESSION['name'];
        $email = $_SESSION['email'];
        $password = password_hash($_SESSION['password'], PASSWORD_DEFAULT); // Hash password
        // Koneksi ke database dan insert data pengguna
        $conn = new mysqli("localhost", "root", "", "db_bioskop");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Use prepared statement
        $stmt = $conn->prepare("INSERT INTO admin (name, email, password) VALUES
(?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);
        if ($stmt->execute()) {
            $registration_success = true; // Set flag untuk menampilkan SweetAlert
            // Hapus session setelah verifikasi
            unset($_SESSION['otp']);
            unset($_SESSION['otp_sent_time']);
            unset($_SESSION['password']); // Hapus password dari session
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "OTP salah atau kadaluarsa.";
    }
}
?>
<?php ?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include "componen/sidebar.php"; ?>
        <!-- Sidebar -->

        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    </form>

                
                    

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?= $_SESSION['name'] ?? 'Admin'; ?>
                                    <img class="img-profile rounded-circle" src="img/undraw_profile.svg" alt="User Image">
                                </span>

                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php" onclick="return confirm('Apa kamu yakin ingin logout?')">

                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="row">
                        <!-- Area Chart -->
                        <div class="container-fluid" style="color: black;">
    <h2 class="mb-4">Akun Admin</h2>
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahAkunModal">Tambah Akun</button>

    <div class="table-responsive">
        <?php 
        include '../koneksi.php'; // Koneksi database
        $query = mysqli_query($conn, "SELECT * FROM admin");
        ?>

        <table class="table table-bordered" style="color: black;">
            <thead class="thead-light">
                <tr >
                    <th style="color: black;">No</th>
                    <th style="color: black;">Email</th>
                    <th style="color: black;">Nama</th>
                    <th style="color: black;">Password</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while($data = mysqli_fetch_assoc($query)): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $data['email']; ?></td>
                        <td><?php echo $data['name']; ?></td>
                        <td>******</td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between">
        <p>Showing 1 to 1 of 1 entries</p>
        <nav>
            <ul class="pagination">
                <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>
</div>


                        <!-- Modal Tambah Akun -->
                        <div class="modal fade" id="tambahAkunModal" tabindex="-1" role="dialog" aria-labelledby="tambahAkunModalLabel" aria-hidden="true" style="color: black;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahAkunModalLabel" style="color: black;">Tambah Akun Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="container">
                <form action="akun_admin.php" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label" style="color: black;">Nama</label>
                        <input type="text" class="form-control" name="name" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label" style="color: black">Email</label>
                        <input type="email" class="form-control" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label" style="color: black">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="modal-footer d-flex justify-content-start">
                        <button type="submit" name="send_otp" class="btn btn-primary">Kirim OTP</button>
                    </div>
                </form>

                <?php if (isset($_SESSION['otp'])): ?>
                    <form action="akun_admin.php" method="POST">
                        <div class="mb-3">
                            <label for="otp" class="form-label">Masukkan OTP</label>
                            <input type="text" class="form-control" name="otp" required>
                        </div>
                        <div class="d-flex justify-content-start">
                            <button type="submit" name="verify_otp" class="btn btn-success">Verifikasi OTP</button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-6 mb-4">

                        </div>

                    </div>
                    <!-- /.container-fluid -->

                </div>



            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="index.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>
        <script>
    // Menampilkan SweetAlert setelah mengirim OTP
    <?php if (isset($otp_sent) && $otp_sent): ?>
      Swal.fire({
        title: 'OTP Terkirim!',
        text: 'Kode OTP telah dikirim ke email Anda.',
        icon: 'success',
        confirmButtonText: 'OK'
        
      }).then((result) => {
            if (result.isConfirmed) {
                var myModal = new bootstrap.Modal(document.getElementById('tambahAkunModal'));
                myModal.show();
            }
        });
    <?php endif; ?>

    // // Menampilkan SweetAlert setelah pendaftaran berhasil
    <?php if (isset($registration_success) && $registration_success): ?>
    Swal.fire({
      title: 'Pendaftaran Berhasil!',
      text: 'Anda telah berhasil mendaftar. Silakan masuk.',
      icon: 'success',
      confirmButtonText: 'OK'
    }).then(() => {
      // Mengarahkan pengguna ke register.php setelah menekan OK
      window.location.href = 'akun_admin.php'; // Ganti dengan path yang sesuai
    });
  <?php endif; ?>
  </script>
        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="vendor/chart.js/Chart.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="js/demo/chart-area-demo.js"></script>
        <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>