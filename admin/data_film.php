<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah</title>
</head>

<body>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>

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
                <!-- NAVBAR -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    </form>


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
            <!-- TABEL -->
                <div class="container-fluid" style="color: black;">
                    <h2 class="mb-0">Data Film</h2>
                    <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#tambahFilmModal">Tambah Film</button>

                    <div class="table-responsive">
                        <?php
                        include '../koneksi.php'; // Koneksi database
                        $query = mysqli_query($conn, "SELECT * FROM film");
                        ?>

                        <table class="table table-bordered" style="color: black;">
                            <thead class="thead-light">
                                <tr>
                                    <th style="color: black;">No</th>
                                    <th style="color: black;">Poster</th>
                                    <th style="color: black;">Nama Film</th>
                                    <th style="color: black;">Deskripsi</th>
                                    <th style="color: black;">Genre</th>
                                    <th style="color: black;">Total Menit</th>
                                    <th style="color: black;">Usia</th>
                                    <th style="color: black;">Dimensi</th>
                                    <th style="color: black;">Producer</th>
                                    <th style="color: black;">Director</th>
                                    <th style="color: black;">Writter</th>
                                    <th style="color: black;">Cast</th>
                                    <th style="color: black;">Distributor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                while ($data = mysqli_fetch_assoc($query)): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><img src="../<?php echo $data['poster']; ?>" alt="Poster" width="50"></td>
                                        <td><?php echo $data['nama_film']; ?></td>
                                        <td><?php echo $data['judul']; ?></td>
                                        <td><?php echo $data['genre']; ?></td>
                                        <td><?php echo $data['total_menit']; ?></td>
                                        <td><?php echo $data['usia']; ?></td>
                                        <td><?php echo $data['dimensi']; ?></td>
                                        <td><?php echo $data['producer']; ?></td>
                                        <td><?php echo $data['Director']; ?></td>
                                        <td><?php echo $data['Writer']; ?></td>
                                        <td><?php echo $data['Cast']; ?></td>
                                        <td><?php echo $data['Distributor']; ?></td>
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
                <!--modal buat tambah film-->
                <div class="modal fade" id="tambahFilmModal" tabindex="-1" role="dialog" aria-labelledby="tambahFilmModal" aria-hidden="true" style="color: black;">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahFilmModal" style="color: black;">Tambah Film</h5>
                                <button type="button" class="close text-black" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="../proses_input.php" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-6" style="color: black;">
                                            <div class="form-group">
                                                <label for="poster">Upload Poster</label>
                                                <input type="file" class="form-control-file" id="poster" name="poster" accept="image/*" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="nama_film">Nama Film</label>
                                                <input type="text" class="form-control" name="nama_film" id="nama_film" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="genre">Genre</label>
                                                <div class="d-flex">
                                                    <select class="form-control mr-2" id="genreSelect">
                                                        <option value="" disabled selected>Pilih Genre</option>
                                                        <option value="Action">Action</option>
                                                        <option value="Adventure">Adventure</option>
                                                        <option value="Animation">Animation</option>
                                                        <option value="Biography">Biography</option>
                                                        <option value="Comedy">Comedy</option>
                                                        <option value="Crime">Crime</option>
                                                        <option value="Disaster">Disaster</option>
                                                        <option value="Documentary">Documentary</option>
                                                        <option value="Drama">Drama</option>
                                                        <option value="Epic">Epic</option>
                                                        <option value="Erotic">Erotic</option>
                                                        <option value="Experimental">Experimental</option>
                                                        <option value="Family">Family</option>
                                                        <option value="Fantasy">Fantasy</option>
                                                        <option value="Film-Noir">Film-Noir</option>
                                                        <option value="History">History</option>
                                                        <option value="Horror">Horror</option>
                                                        <option value="Martial arts">Martial arts</option>
                                                        <option value="Music">Music</option>
                                                        <option value="Musical">Musical</option>
                                                        <option value="Mystery">Mystery</option>
                                                        <option value="Political">Political</option>
                                                        <option value="Psychological">Psychological</option>
                                                        <option value="Romance">Romance</option>
                                                        <option value="Sci-Fi">Sci-Fi</option>
                                                        <option value="Sport">Sport</option>
                                                        <option value="Superhero">Superhero</option>
                                                        <option value="Survival">Survival</option>
                                                        <option value="Thriller">Thriller</option>
                                                        <option value="War">War</option>
                                                        <option value="Western">Western</option>
                                                    </select>
                                                    <button type="button" class="btn btn-primary" onclick="addGenre()">Tambah</button>
                                                </div>
                                                <ul id="selectedGenres" class="mt-3 list-group d-flex flex-wrap" style="max-height: 200px; overflow-y: auto;"></ul>
                                                <input type="hidden" id="genreInput" name="genre">
                                            </div>
                                            <div class="form-group">
                                                <label for="banner">Upload Banner</label>
                                                <input type="file" class="form-control-file" name="banner" id="banner" accept="image/*" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="menit">Durasi (menit)</label>
                                                <input type="number" class="form-control" name="menit" id="menit" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="usia">Rating Usia</label>
                                                <select class="form-control" name="usia" id="usia" required>
                                                    <option value="" disabled selected>Pilih Usia</option>
                                                    <option value="13">13+</option>
                                                    <option value="17">17+</option>
                                                    <option value="SU">SU</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="cast">Cast</label>
                                                <input type="text" class="form-control" id="cast" name="cast" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="harga">Harga Tiket</label>
                                                <input type="number" class="form-control" name="harga" id="harga" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="trailer">Upload Trailer</label>
                                                <input type="file" class="form-control-file" id="trailer" name="trailer" accept="video/*">
                                            </div>
                                            <div class="form-group">
                                                <label for="judul">Deskripsi</label>
                                                <textarea class="form-control" id="judul" name="judul" rows="2" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="dimensi">Dimensi</label>
                                                <select class="form-control" name="dimensi" id="dimensi" required>
                                                    <option value="" disabled selected>Pilih Dimensi</option>
                                                    <option value="2D">2D</option>
                                                    <option value="3D">3D</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="producer">Producer</label>
                                                <input type="text" class="form-control" id="producer" name="producer" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="director">Director</label>
                                                <input type="text" class="form-control" id="director" name="director" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="writer">Writer</label>
                                                <input type="text" class="form-control" id="writer" name="writer" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="distributor">Distributor</label>
                                                <input type="text" class="form-control" id="distributor" name="distributor" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>



                <script>
                    const selectedGenres = new Set(); // Perbaikan nama variabel dan deklarasi set

                    function addGenre() {
                        const genreSelect = document.getElementById('genreSelect');
                        const selectedValue = genreSelect.value;

                        if (selectedValue && !selectedGenres.has(selectedValue)) {
                            selectedGenres.add(selectedValue);

                            // Menambahkan genre ke daftar tampilan
                            const listItem = document.createElement('li');
                            listItem.className = 'list-group-item d-flex justify-content-between align-items-center';
                            listItem.textContent = selectedValue;

                            // Tombol untuk menghapus genre
                            const removeBtn = document.createElement('button');
                            removeBtn.className = 'btn btn-sm btn-danger';
                            removeBtn.textContent = 'Hapus';
                            removeBtn.onclick = () => {
                                selectedGenres.delete(selectedValue);
                                listItem.remove();
                                updateHiddenInput();
                            };

                            listItem.appendChild(removeBtn);
                            document.getElementById('selectedGenres').appendChild(listItem);

                            // Memperbarui input tersembunyi
                            updateHiddenInput();
                        }

                        genreSelect.value = '';
                    }

                    function updateHiddenInput() {
                        document.getElementById('genreInput').value = Array.from(selectedGenres).join(',');
                    }
                </script>
            </div>
        </div>
    </div>
    </div>


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