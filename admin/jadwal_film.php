<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Popper.js (dibutuhkan untuk modal Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- Custom fonts for this template-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

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

                    <!-- Topbar Navbar -->

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
            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <div class="container-fluid" style="color: black;">
                    <h2 class="mb-4">Jadwal Film</h2>
                    <!-- Button to open the "Tambah Film" modal -->
                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalTambahJadwal">
                        Tambah Jadwal Film
                    </button>

                    <div class="table-responsive">
                        <table class="table table-bordered" style="color: black;">
                            <thead class="thead-light">
                                <tr style="color:black">
                                    <!-- Table Headers -->
                                    <th style="color:black">No</th>
                                    <th style="color:black">Nama mall</th>
                                    <th style="color:black">poster</th>
                                    <th style="color:black">Nama film</th>
                                    <th style="color:black">Total menit</th>
                                    <th style="color:black">tanggal tayang</th>
                                    <th style="color:black">Tanggal akhir tayang</th>
                                    <th style="color:black">jam tayang 1</th>
                                    <th style="color:black">jam tayang 2</th>
                                    <th style="color:black">jam tayang 3</th>
                                    <th style="color:black">studio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include '../koneksi.php'; // Menghubungkan ke database
                                // Query untuk mengambil data film, nama mall, dan poster
                                $sql = "SELECT
jadwal_film.id, 
akun_mall.nama_mall, 
film.nama_film, 
film.poster, 
jadwal_film.total_menit, 
jadwal_film.tanggal_tayang, 
jadwal_film.tanggal_akhir_tayang ,
jadwal_film.jam_tayang_1, 
jadwal_film.jam_tayang_2, 
jadwal_film.jam_tayang_3,
jadwal_film.studio
FROM jadwal_film 
JOIN akun_mall ON jadwal_film.mall_id = akun_mall.id
JOIN film ON jadwal_film.film_id = film.id
ORDER BY akun_mall.nama_mall ASC, jadwal_film.id ASC";
                                $result = $conn->query($sql);
                                // Array untuk menyimpan data film berdasarkan mall
                                $filmsByMall = [];
                                // Memasukkan data film ke dalam array berdasarkan mall
                                while ($row = $result->fetch_assoc()) {
                                    $filmsByMall[$row['nama_mall']][] = $row;
                                }
                                ?>

                                <?php
                                $no = 1;
                                foreach ($filmsByMall as $mallName => $films) {
                                    foreach ($films as $film) {
                                        // Debugging: Menampilkan data film
                                        // Konversi tanggal ke format DateTime
                                        $expired_date = new DateTime($film['tanggal_akhir_tayang']);
                                        $current_date = new DateTime();
                                        // Debugging: Menampilkan tanggal akhir tayang & tanggal sekarang
                                        // Cek apakah sudah kadaluarsa
                                        $is_expired = $expired_date < $current_date;
                                        echo "<tr " . ($is_expired ? "style='background-color: red 
!important;'" : "") . ">
<td " . ($is_expired ? "style='background-color: red 
!important;'" : "") . " >{$no}</td>
<td " . ($is_expired ? "style='background-color: red 
!important;'" : "") . " >{$film['nama_mall']}</td>
<td " . ($is_expired ? "style='background-color: red 
!important;'" : "") . " ><img src='../{$film['poster']}' alt='Poster' 
width='100'></td>
<td " . ($is_expired ? "style='background-color: red 
!important;'" : "") . " >{$film['nama_film']}</td>
<td " . ($is_expired ? "style='background-color: red 
!important;'" : "") . " >{$film['total_menit']}</td>
<td " . ($is_expired ? "style='background-color: red 
!important;'" : "") . " >{$film['tanggal_tayang']}</td>
<td " . ($is_expired ? "style='background-color: red 
!important;'" : "") . " >{$film['tanggal_akhir_tayang']}</td>
<td " . ($is_expired ? "style='background-color: red 
!important;'" : "") . " >{$film['jam_tayang_1']}</td>
<td " . ($is_expired ? "style='background-color: red 
!important;'" : "") . " >{$film['jam_tayang_2']}</td>
<td " . ($is_expired ? "style='background-color: red 
!important;'" : "") . " >{$film['jam_tayang_3']}</td>
<td " . ($is_expired ? "style='background-color: red 
!important;'" : "") . " >{$film['studio']}</td>
</tr>";
                                        $no++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
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
                <!--MODAL BUAT TAMBAH JADWAL FILM-->
                <div class="modal fade" id="modalTambahJadwal" tabindex="-1" aria-labelledby="modalTambahJadwalLabel" aria-hidden="true" style="color: black;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTambahJadwalLabel">Tambah Jadwal Film</h5>
                                <!-- Close Button with X -->
                                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>

                            </div>
                            <div class="modal-body">
                                <form id="formTambahJadwal" style="color: black;">
                                    <!-- Nama Mall -->
                                    <div class="mb-3">
                                        <label for="namaMall" class="form-label">Nama Mall</label>
                                        <select class="form-select" id="namaMall" name="namaMall" required>
                                            <option value="">Pilih Mall</option>
                                        </select>
                                    </div>
                                    <!-- Nama Film -->
                                    <div class="mb-3">
                                        <label for="namaFilm" class="form-label">Nama Film</label>
                                        <select class="form-select" id="namaFilm" name="namaFilm" required>
                                            <option value="">Pilih Film</option>
                                        </select>
                                    </div>
                                    <!-- Poster -->
                                    <div class="mb-3">
                                        <label for="posterFilm" class="form-label">Poster</label>
                                        <img id="posterFilm" src="" alt="Poster Film" class="img-thumbnail" style="display: none; max-height: 200px;">
                                    </div>
                                    <!-- Total Menit -->
                                    <div class="mb-3">
                                        <label for="totalMenit" class="form-label">Total Menit</label>
                                        <input type="text" class="form-control" id="totalMenit" name="totalMenit" readonly>
                                    </div>
                                    <!-- Tanggal Tayang -->
                                    <div class="mb-3">
                                        <label for="tanggalTayang" class="form-label">Tanggal Tayang</label>
                                        <input type="date" class="form-control" id="tanggalTayang" name="tanggalTayang" required>
                                    </div>
                                    <!-- Tanggal Akhir Tayang -->
                                    <div class="mb-3">
                                        <label for="tanggalAkhirTayang" class="form-label">Tanggal Akhir Tayang</label>
                                        <input type="date" class="form-control" id="tanggalAkhirTayang" name="tanggalAkhirTayang" required>
                                    </div>
                                    <!-- Jam Tayang 1 -->
                                    <div class="mb-3">
                                        <label for="jamTayang1" class="form-label">Jam Tayang 1</label>
                                        <input type="time" class="form-control" id="jamTayang1" name="jamTayang1" required>
                                    </div>
                                    <!-- Jam Tayang 2 -->
                                    <div class="mb-3">
                                        <label for="jamTayang2" class="form-label">Jam Tayang 2</label>
                                        <input type="time" class="form-control" id="jamTayang2" name="jamTayang2">
                                    </div>
                                    <!-- Jam Tayang 3 -->
                                    <div class="mb-3">
                                        <label for="jamTayang3" class="form-label">Jam Tayang 3</label>
                                        <input type="time" class="form-control" id="jamTayang3" name="jamTayang3">
                                    </div>
                                    <!-- Pilih Studio -->
                                    <div class="mb-3">
                                        <label for="studio" class="form-label">Pilih Studio</label>
                                        <select class="form-select" id="studio" name="studio" required>
                                            <option value="">Pilih Studio</option>
                                            <option value="Studio 1">Studio 1</option>
                                            <option value="Studio 2">Studio 2</option>
                                            <option value="Studio 3">Studio 3</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary" id="submitBtn">Simpan</button>
                                </form>
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
            <!-- End of Main Content -->


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
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Fetch mall data
            $.ajax({
                url: 'api.php?endpoint=mall',
                method: 'GET',
                success: function(data) {
                    data.forEach(function(mall) {
                        $('#namaMall').append(`<option 
value="${mall.id}">${mall.nama_mall}</option>`);
                    });
                },
            });
            // Fetch film data
            $.ajax({
                url: 'api.php?endpoint=film',
                method: 'GET',
                success: function(data) {
                    data.forEach(function(film) {
                        $('#namaFilm').append(`<option 
value="${film.id}">${film.nama_film}</option>`);
                    });
                },
            });
            // Handle film selection
            $('#namaFilm').change(function() {
                const filmId = $(this).val();
                if (filmId) {
                    $.ajax({
                        url: `api.php?endpoint=film_detail&id=${filmId}`,
                        method: 'GET',
                        success: function(film) {
                            $('#posterFilm').attr('src', `../${film.poster}`).show();
                            $('#totalMenit').val(film.total_menit);
                        },
                        error: function() {
                            $('#posterFilm').hide().attr('src', '');
                            $('#totalMenit').val('');
                        },
                    });
                } else {
                    $('#posterFilm').hide().attr('src', '');
                    $('#totalMenit').val('');
                }
            });
            // Handle form submission
            $('#formTambahJadwal').submit(function(e) {
                e.preventDefault();
                // Get form data
                const formData = $(this).serialize();
                // Send data to server
                $.ajax({
                    url: 'api.php?endpoint=tambah_jadwal',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            // Show SweetAlert2 on success
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Jadwal Film berhasil disimpan!',
                                icon: 'success',
                                confirmButtonText: 'OK',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Redirect to jadwal.php
                                    window.location.href = 'jadwal_film.php';
                                }
                            });
                        } else {
                            // Show SweetAlert2 on failure
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Gagal menyimpan jadwal film.',
                                icon: 'error',
                                confirmButtonText: 'OK',
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Terjadi kesalahan!',
                            text: 'Tidak dapat menyimpan jadwal film.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                        });
                    },
                });
            });
        });
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