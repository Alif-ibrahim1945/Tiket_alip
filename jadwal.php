<?php
include 'koneksi.php';
session_start();
// Mengambil ID film dari URL
$id_film = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Query untuk mengambil data film berdasarkan ID (termasuk harga tiket)
$sql = "SELECT * FROM film WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_film);
$stmt->execute();
$result = $stmt->get_result();

// Memeriksa apakah film ditemukan
if ($result->num_rows > 0) {
    $film = $result->fetch_assoc();
    $harga_tiket = $film['harga']; // Mengambil harga tiket dari tabel film
} else {
    echo "Film tidak ditemukan.";
    exit;
}

// Query untuk mengambil data jadwal film berdasarkan ID film
$sql_jadwal = "
    SELECT jadwal_film.*, akun_mall.nama_mall
    FROM jadwal_film
    INNER JOIN akun_mall ON jadwal_film.mall_id = akun_mall.id
    WHERE jadwal_film.film_id = ? AND CURDATE() BETWEEN jadwal_film.tanggal_tayang AND jadwal_film.tanggal_akhir_tayang
";
$stmt_jadwal = $conn->prepare($sql_jadwal);
$stmt_jadwal->bind_param("i", $id_film);
$stmt_jadwal->execute();
$jadwal_result = $stmt_jadwal->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Home</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/linearicons-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/slick/slick.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/MagnificPopup/magnific-popup.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!--===============================================================================================-->

</head>
<body class="animsition">

		<?php include"componen/navbar.php"; 
			$showUsername = false; // Menampilkan nama user di index2.php

		?>

	
	<!-- Cart -->
	<section class="bg0 p-t-23 p-b-140" style="padding-top: 80px; margin-top: 0px;">
	<style>
        .btn-primary {
    background-color: blue;
    color: white;
}

.btn-outline-primary {
    border-color: blue;
    color: blue;
}

.btn-danger {
    background-color: red;
    color: white;
}

.disabled {
    pointer-events: none;
    opacity: 0.6;
}
body {
    background-color: #f5f5f5;
}

.card {
    border: none;
    background-color: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.card-body {
    padding: 20px;
}

.showtime-btn {
    border: 1px solid #d1d1d1;
    border-radius: 5px;
    padding: 5px 10px;
    margin-top: 10px;
    display: inline-block;
}

.showtime-btn:hover {
    background-color: #f0f0f0;
}

.cinema-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-top: 1px solid #d1d1d1;
}

.cinema-info:first-child {
    border-top: none;
}

.cinema-info {
    display: flex;
    margin-right: 45px;
    flex-direction: column; /* Ubah menjadi kolom untuk menampilkan elemen vertikal */
    gap: 15px; /* Jarak antara setiap jadwal */
}

.showtime-btn {
    display: inline-block; /* Pertahankan agar tombol tampil sebagai blok terpisah */
    margin-right: 10px; /* Tambahkan jarak antar waktu tayang */
}
</style>
<?php
        $username = isset($_SESSION['email']) ? $_SESSION['email'] : "";
        ?>
<div class="container mt-5">
    
    <div class="card">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="<?php echo $film['poster']; ?>" class="img-fluid rounded-start" alt="Film Poster">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $film['nama_film']; ?></h5>
                    <p class="card-text"><i class="fas fa-clock"></i> <?php echo $film['total_menit']; ?> Minutes</p>
					<br>
                    <div class="mb-3">
                        <button type="button" class="btn btn-outline-secondary btn-sm"><?php echo $film['dimensi']; ?></button>
                        <button type="button" class="btn btn-outline-secondary btn-sm"><?php echo $film['usia']; ?></button>
                    </div>
                    <?php if ($jadwal_result->num_rows > 0): ?>
                        <?php while ($jadwal = $jadwal_result->fetch_assoc()): ?>
                            <?php
                            $today = date("Y-m-d");
                            $tanggal_tayang = date("Y-m-d", strtotime($jadwal['tanggal_tayang']));
                            $tanggal_akhir_tayang = date("Y-m-d", strtotime($jadwal['tanggal_akhir_tayang']));
                            ?>
                            <?php if ($tanggal_tayang <= $today && $tanggal_akhir_tayang >= $today): ?>
                                <h5 class="mt-3"><?php echo $jadwal['nama_mall']; ?></h5>
								<br>
                                <p><?php echo "$tanggal_tayang - $tanggal_akhir_tayang"; ?></p>

                                <?php if ($jadwal['jam_tayang_1']): ?>
                                    <button type="button" class="btn btn-primary showtime-btn"
                                        data-bs-time="<?php echo date("H:i", strtotime($jadwal['jam_tayang_1'])); ?>"
                                        data-bs-mall="<?php echo $jadwal['nama_mall']; ?>"
                                        data-bs-toggle="modal" data-bs-target="#ticketModal">
                                        <?php echo date("H:i", strtotime($jadwal['jam_tayang_1'])); ?>
                                    </button>
                                <?php endif; ?>

                                <?php if ($jadwal['jam_tayang_2']): ?>
                                    <button type="button" class="btn btn-primary showtime-btn"
                                        data-bs-time="<?php echo date("H:i", strtotime($jadwal['jam_tayang_2'])); ?>"
                                        data-bs-mall="<?php echo $jadwal['nama_mall']; ?>"
                                        data-bs-toggle="modal" data-bs-target="#ticketModal">
                                        <?php echo date("H:i", strtotime($jadwal['jam_tayang_2'])); ?>
                                    </button>
                                <?php endif; ?>

                                <?php if ($jadwal['jam_tayang_3']): ?>
                                    <button type="button" class="btn btn-primary showtime-btn"
                                        data-bs-time="<?php echo date("H:i", strtotime($jadwal['jam_tayang_3'])); ?>"
                                        data-bs-mall="<?php echo $jadwal['nama_mall']; ?>"
                                        data-bs-toggle="modal" data-bs-target="#ticketModal">
                                        <?php echo date("H:i", strtotime($jadwal['jam_tayang_3'])); ?>
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <?php
                        $id_film = isset($_GET['id']) ? intval($_GET['id']) : 0;
                        $jadwal_film = $conn->query("SELECT MIN(tanggal_tayang) as tanggal_terdekat FROM jadwal_film WHERE film_id = {$id_film}");
                        $row = $jadwal_film->fetch_assoc();
                        $tanggal_terdekat = $row['tanggal_terdekat'] ? $row['tanggal_terdekat'] : null;

                        if ($tanggal_terdekat) {
                            echo "<p>Jadwal akan tersedia pada tanggal: " . date('d-m-Y', strtotime($tanggal_terdekat)) . "</p>";
                        } else {
                            echo "<p>Belum Ada Jadwal</p>";
                        }
                        ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

		<style>
    .card-text, 
    .card-body p {
        color: #6c757d !important; /* Warna abu-abu */
    }

	h5.mt-3 {
    color:rgb(51, 57, 61) !important;
}
	h5.card-title {
		color:rgb(70, 77, 83) !important;
	}

	.btn-outline-secondary {
    color: #0d6efd !important; /* Warna biru */
    border-color: #0d6efd !important; /* Warna border biru */
}

.btn-outline-secondary:hover,
.btn-outline-secondary:focus {
    background-color: #0d6efd !important; /* Warna biru saat hover */
    color: #fff !important; /* Warna teks putih saat hover */
    border-color: #0d6efd !important; /* Warna border tetap biru */
}
</style>

<div class="modal fade" id="ticketModal" tabindex="-1" role="dialog" aria-labelledby="ticketModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ticketModalLabel" style="color: black;">Pilih Tiket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="color: black;">
                <p><strong >Nama Film: </strong><span><?php echo $film['nama_film']; ?></span></p>
                <p><strong>Nama Mall: </strong><span id="mallName"></span></p>
                <p><strong>Jam Tayang: </strong><span id="showtime"></span></p>

                <p><strong>Harga Per Tiket: </strong>Rp <span id="ticketPrice"><?php echo number_format($harga_tiket, 0, ',', '.'); ?></span></p>

                <div class="form-group">
                    <label for="ticketCount">Jumlah Tiket</label>
                    <input type="number" class="form-control" id="ticketCount" readonly value="0">
                </div>

                <div class="form-group">
                    <label for="ticketCount">Total Harga Tiket</label>
                    <input type="text" class="form-control" id="hargatiket" readonly>
                </div>

                <div class="form-group">
                    <label for="seatSelection">Pilih Kursi</label>
                    <div id="seatSelection" class="d-flex flex-wrap gap-2"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="bookTicket">Pesan Tiket</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-s3jsqngS36Rs9AqB"></script>

<script>
    var username = "<?php echo $username; ?>"; // Username dari PHP session


    if (!username) {
        Swal.fire({
            icon: 'warning',
            title: 'Anda belum login',
            text: 'Login terlebih dahulu untuk melanjutkan.',
            confirmButtonText: 'Ke Halaman Login'
        }).then(() => {
            window.location.href = "login.php"; // Redirect ke halaman login
        });
    } else {
        document.addEventListener('DOMContentLoaded', function() {

            var ticketModal = document.getElementById('ticketModal');

            if (ticketModal) {
                var modalShown = false;

                ticketModal.addEventListener('show.bs.modal', function(event) {
    var button = event.relatedTarget; // Tombol yang diklik
    var mallName = button.getAttribute('data-bs-mall'); // Ambil nama mall
    var showtime = button.getAttribute('data-bs-time'); // Ambil jam tayang

    // Tampilkan data di modal
    var mallNameElement = ticketModal.querySelector('#mallName');
    var showtimeElement = ticketModal.querySelector('#showtime');

    if (mallNameElement && showtimeElement) {
        mallNameElement.textContent = mallName;
        showtimeElement.textContent = showtime; // Tampilkan jam tayang
    }
                    let seatContainer = document.getElementById("seatSelection");
                    seatContainer.innerHTML = "";

                    let seatWrapper = document.createElement("div");
                    seatWrapper.classList.add("seat-wrapper", "d-flex", "flex-column", "align-items-center");

                    let seatRows = [{
                            row: "A",
                            seats: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        },
                        {
                            row: "B",
                            seats: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        },
                        {
                            row: "C",
                            seats: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        },
                        {
                            row: "D",
                            seats: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        },
                        {
                            row: "E",
                            seats: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        },
                        {
                            row: "F",
                            seats: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        },
                        {
                            row: "G",
                            seats: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        },
                        {
                            row: "H",
                            seats: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        }
                    ];

                    seatRows.forEach(group => {
                        let row = document.createElement("div");
                        row.classList.add("d-flex", "justify-content-center", "mb-3");

                        // Kelompok pertama: A1, A2, A3
                        for (let i = 0; i < 3; i++) {
                            let seatDiv = document.createElement("div");
                            seatDiv.classList.add("seat", "btn", "btn-outline-primary", "m-1", "btn-sm");
                            seatDiv.setAttribute("data-seat", `${group.row}${group.seats[i]}`);
                            seatDiv.textContent = `${group.row}${group.seats[i]}`;
                            seatDiv.addEventListener("click", function() {
    if (!this.classList.contains("btn-danger")) {
        this.classList.toggle("btn-primary");
        this.classList.toggle("btn-outline-primary");
        updatePrice();
    }
});
                            row.appendChild(seatDiv);
                        }

                        // Tambahkan spacer setelah kelompok pertama
                        let spacer1 = document.createElement("div");
                        spacer1.classList.add("mx-4"); // Atur jarak sesuai kebutuhan
                        row.appendChild(spacer1);

                        // Kelompok kedua: A4, A5, A6, A7
                        for (let i = 3; i < 7; i++) {
                            let seatDiv = document.createElement("div");
                            seatDiv.classList.add("seat", "btn", "btn-outline-primary", "m-1", "btn-sm");
                            seatDiv.setAttribute("data-seat", `${group.row}${group.seats[i]}`);
                            seatDiv.textContent = `${group.row}${group.seats[i]}`;
                            seatDiv.addEventListener("click", function() {
                                if (!this.classList.contains("btn-danger")) {
                                    this.classList.toggle("btn-primary");
                                    updatePrice();
                                }
                            });
                            row.appendChild(seatDiv);
                        }

                        // Tambahkan spacer setelah kelompok kedua
                        let spacer2 = document.createElement("div");
                        spacer2.classList.add("mx-4"); // Atur jarak sesuai kebutuhan
                        row.appendChild(spacer2);

                        // Kelompok ketiga: A8, A9, A10
                        for (let i = 7; i < 10; i++) {
                            let seatDiv = document.createElement("div");
                            seatDiv.classList.add("seat", "btn", "btn-outline-primary", "m-1", "btn-sm");
                            seatDiv.setAttribute("data-seat", `${group.row}${group.seats[i]}`);
                            seatDiv.textContent = `${group.row}${group.seats[i]}`;
                            seatDiv.addEventListener("click", function() {
                                if (!this.classList.contains("btn-danger")) {
                                    this.classList.toggle("btn-primary");
                                    updatePrice();
                                }
                            });
                            row.appendChild(seatDiv);
                        }

                        seatWrapper.appendChild(row);
                    });

                    seatContainer.appendChild(seatWrapper);

                    seatContainer.appendChild(seatWrapper);
                    let ticketPriceElement = document.getElementById("ticketPrice");
                    let ticketCountInput = document.getElementById("ticketCount");
                    let totalPriceInput = document.getElementById("hargatiket"); // Ambil input form total harga tiket

                    if (ticketPriceElement && totalPriceInput) {
                        let ticketPrice = parseInt(ticketPriceElement.textContent.replace(/\./g, ""));

                        function updatePrice() {
    let selectedSeats = document.querySelectorAll(".seat.btn-primary");
    let totalTickets = selectedSeats.length;
    let totalPrice = totalTickets * ticketPrice;

    ticketCountInput.value = totalTickets;
    totalPriceInput.value = "Rp " + totalPrice.toLocaleString("id-ID");
}
                    }
                    let filmName = document.querySelector("#ticketModal span").textContent.trim();
                    fetch(`fetch_seats.php?mall_name=${encodeURIComponent(mallName)}&film_name=${encodeURIComponent(filmName)}`)
                        .then(response => response.json())
                        .then(data => {
                            let occupiedSeats = data.occupiedSeats || [];
                            seatRows.forEach(group => {
                                group.seats.forEach(seat => {
                                    let seatNumber = `${group.row}${seat}`;
                                    let seatDiv = document.querySelector(`[data-seat='${seatNumber}']`);

                                    if (occupiedSeats.includes(seatNumber)) {
                                        seatDiv.classList.add("btn-danger", "disabled");
                                    }
                                });
                            });
                        })
                        .catch(error => console.error("Error fetching seat status:", error));
                });

            }

            document.getElementById("bookTicket").addEventListener("click", function() {
    let mallName = document.getElementById("mallName").textContent.trim();
    let filmName = document.querySelector("#ticketModal span").textContent.trim();
    let showtime = document.getElementById("showtime").textContent.trim();
    let price = parseInt(document.getElementById("ticketPrice").textContent.replace(/\./g, ""));
    let selectedSeats = document.querySelectorAll(".seat.btn-primary");
    let ticketCount = selectedSeats.length;
    let totalPrice = price * ticketCount;

    if (ticketCount === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Pilih Kursi',
            text: 'Silakan pilih kursi terlebih dahulu.',
            confirmButtonText: 'Tutup'
        });
        return;
    }

    let seatNumbers = Array.from(selectedSeats).map(seat => seat.getAttribute("data-seat")).join(",");

    fetch("insert_seat.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `seat_number=${seatNumbers}&mall_name=${mallName}&film_name=${filmName}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                selectedSeats.forEach(seat => {
                    seat.classList.remove("btn-outline-primary");
                    seat.classList.add("btn-danger", "disabled");
                });

                // Proceed to payment
                $.ajax({
                    url: "process_transaction.php",
                    type: "POST",
                    data: {
                        mall_name: mallName,
                        showtime: showtime,
                        ticket_count: ticketCount,
                        total_price: totalPrice,
                        seat_number: seatNumbers,
                        username: username
                    },
                    success: function(response) {
                        console.log("Response from process_transaction.php: ", response);
                        let data = JSON.parse(response);
                        if (data.snap_token) {
                            window.snap.pay(data.snap_token, {
                                onSuccess: function(result) {
                                    console.log("Payment Success Result: ", result);
                                    saveTransaction(result, seatNumbers, username);
                                },
                                onPending: function(result) {
                                    console.log("Payment Pending Result: ", result);
                                    saveTransaction(result, seatNumbers, username);
                                },
                                onError: function(result) {
                                    console.log("Payment Error Result: ", result);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Pembayaran Gagal',
                                        text: 'Ada masalah dengan pembayaran.',
                                        confirmButtonText: 'Coba Lagi'
                                    });
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Token Pembayaran Gagal',
                                text: 'Gagal mendapatkan token pembayaran.',
                                confirmButtonText: 'Tutup'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("Error in AJAX request: ", error);
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Memesan Tiket',
                    text: 'Terjadi kesalahan saat memesan tiket.',
                    confirmButtonText: 'Coba Lagi'
                });
            }
        })
        .catch(error => console.error("Error inserting seat:", error));
});
        });

        function saveTransaction(transactionData, seatNumber, username) {
    let filmName = document.querySelector("#ticketModal span").textContent.trim();
    transactionData.seat_number = seatNumber;
    transactionData.film_name = filmName; // Menambahkan nama film ke dalam data transaksi
    transactionData.username = username;

    console.log("Saving transaction: ", transactionData); // Debugging log untuk memeriksa data yang dikirim
    console.log("dnakwnkd Name: ", filmName);
    $.ajax({
        url: "save_transaction.php",
        type: "POST",
        data: transactionData,
        success: function(response) {
            console.log("Response from save_transaction.php: ", response);
            // Setelah berhasil, lakukan update kursi menjadi 'occupied'
            $.ajax({
                url: "update_seat_status.php",
                type: "POST",
                data: {
                    seat_number: seatNumber,
                    transactionData,
                    filmName // Pastikan filmName juga dikirim ke update_seat_status.php
                },
                success: function(updateResponse) {
                    console.log("Seat status updated: ", updateResponse);
                    Swal.fire({
                        icon: 'success',
                        title: 'Pembayaran Berhasil',
                        text: 'Tiket dan kursi Anda sudah dipesan.',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload(); // Reload halaman setelah berhasil
                    });
                },
                error: function(xhr, status, error) {
                    console.log("Error in updating seat status: ", error);
                }
            });
        },
        error: function(xhr, status, error) {
            console.log("Error in saving transaction: ", error); // Debugging error log
        }
    });
}

    }
</script>

</section>

	<!-- Back to top -->
	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
		</span>
	</div>

		

<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
	<script>
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		})
	</script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/slick/slick.min.js"></script>
	<script src="js/slick-custom.js"></script>
<!--===============================================================================================-->
	<script src="vendor/parallax100/parallax100.js"></script>
	<script>
        $('.parallax100').parallax100();
	</script>
<!--===============================================================================================-->
	<script src="vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
	<script>
		$('.gallery-lb').each(function() { // the containers for all your galleries
			$(this).magnificPopup({
		        delegate: 'a', // the selector for gallery item
		        type: 'image',
		        gallery: {
		        	enabled:true
		        },
		        mainClass: 'mfp-fade'
		    });
		});
	</script>
<!--===============================================================================================-->
	<script src="vendor/isotope/isotope.pkgd.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/sweetalert/sweetalert.min.js"></script>
	<script>
		$('.js-addwish-b2').on('click', function(e){
			e.preventDefault();
		});

		$('.js-addwish-b2').each(function(){
			var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");

				$(this).addClass('js-addedwish-b2');
				$(this).off('click');
			});
		});

		$('.js-addwish-detail').each(function(){
			var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");

				$(this).addClass('js-addedwish-detail');
				$(this).off('click');
			});
		});

		/*---------------------------------------------*/

		$('.js-addcart-detail').each(function(){
			var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to cart !", "success");
			});
		});
	
	</script>
<!--===============================================================================================-->
	<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script>
		$('.js-pscroll').each(function(){
			$(this).css('position','relative');
			$(this).css('overflow','hidden');
			var ps = new PerfectScrollbar(this, {
				wheelSpeed: 1,
				scrollingThreshold: 1000,
				wheelPropagation: false,
			});

			$(window).on('resize', function(){
				ps.update();
			})
		});
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>