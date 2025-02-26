<?php
// Menyertakan autoloader Composer
require 'vendor/autoload.php'; // Pastikan pathnya sesuai dengan struktur project Anda
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
$stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                <div class="col-lg-5 d-none d-lg-block text-center">
    <img src="cozacinema.webp" alt="" class="img-fluid w-100 h-100" style="object-fit: cover;">
                    </div>

                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 style="color: black">Form registrasi!</h1>
                            </div>
                            <div class="container">
    <form action="register.php" method="POST">
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
        <button type="submit" name="send_otp" class="btn btn-primary">Kirim OTP</button>
    </form>

    <?php if (isset($_SESSION['otp'])): ?>
    <form action="register.php" method="POST">
        <div class="mb-3">
            <label for="otp" class="form-label">Masukkan OTP</label>
            <input type="text" class="form-control" name="otp" required>
        </div>
        <button type="submit" name="verify_otp" class="btn btn-success">Verifikasi OTP</button>
    </form>
    <?php endif; ?>
</div>

<script>
// Menampilkan SweetAlert setelah mengirim OTP
<?php if (isset($otp_sent) && $otp_sent): ?>
Swal.fire({
title: 'OTP Terkirim!',
text: 'Kode OTP telah dikirim ke email Anda.',
icon: 'success',
confirmButtonText: 'OK'
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
// // Mengarahkan pengguna ke register.php setelah menekan OK
window.location.href = 'login.php'; // Ganti dengan 
});
<?php endif; ?>
</script>
                            <div class="text-center">
                                <a class="small" href="login.php">Already have an account? Login!</a>
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