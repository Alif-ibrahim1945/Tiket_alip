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

<?php
include 'koneksi.php';
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nama_film = $_POST['nama_film'];
    $judul = $_POST['judul'];
    $usia = $_POST['usia'];
    $genre = $_POST['genre'];
    $menit = $_POST['menit'];
    $dimensi = $_POST['dimensi'];
    $producer = $_POST['producer'];
    $director = $_POST['director'];
    $writer = $_POST['writer'];
    $cast = $_POST['cast'];
    $distributor = $_POST['distributor'];
    $harga = $_POST['harga'];

    $target_dir_poster = "upload/poster/";
    $target_file_poster = $target_dir_poster . basename($_FILES["poster"]["name"]);
    $uploadOK = 1;
    $imageFileType = strtolower(pathinfo($target_file_poster, PATHINFO_EXTENSION));

    if (!getimagesize($_FILES["poster"]["tmp_name"])) {
        echo "File yang diupload bukan gambar.";
        $uploadOK = 0;
    }
    if ($_FILES["poster"]["size"] > 500000) {
        echo "Maaf, ukuran file poster terlalu besar.";
        $uploadOK = 0;
    }
    if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
        echo "Maaf, hanya file JPG, PNG, JPEG, & GIF yang diperbolehkan.";
        $uploadOK = 0;
    }
    if ($uploadOK == 1 && move_uploaded_file($_FILES["poster"]["tmp_name"], $target_file_poster)) {
        $target_dir_banner = "upload/banner/";
        $target_file_banner = $target_dir_banner . basename($_FILES["banner"]["name"]);
        $uploadOKBanner = 1;
        $imageFileTypeBanner = strtolower(pathinfo($target_file_banner, PATHINFO_EXTENSION));

        if (!getimagesize($_FILES["banner"]["tmp_name"])) {
            echo "File yang diupload sebagai banner bukan gambar.";
            $uploadOKBanner = 0;
        }
        if ($_FILES["banner"]["size"] > 500000) {
            echo "Maaf, ukuran file banner terlalu besar.";
            $uploadOKBanner = 0;
        }
        if (!in_array($imageFileTypeBanner, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "Maaf, hanya file JPG, PNG, JPEG, & GIF yang diperbolehkan untuk banner.";
            $uploadOKBanner = 0;
        }
        if ($uploadOKBanner == 1 && move_uploaded_file($_FILES["banner"]["tmp_name"], $target_file_banner)) {
            $target_dir_trailer = "upload/trailer/";
            $target_file_trailer = $target_dir_trailer . basename($_FILES['trailer']['name']);
            $uploadOKTrailer = 1;
            $videoFileType = strtolower(pathinfo($target_file_trailer, PATHINFO_EXTENSION));

            if (!in_array($videoFileType, ['mp4', 'avi', 'mov', 'wmv'])) {
                echo "Maaf, hanya file MP4, AVI, MOV, & WMV yang diperbolehkan.";
                $uploadOKTrailer = 0;
            }
            if ($_FILES['trailer']['size'] > 50000000) {
                echo "Maaf, ukuran file trailer terlalu besar.";
                $uploadOKTrailer = 0;
            }
            if ($uploadOKTrailer == 1 && move_uploaded_file($_FILES["trailer"]["tmp_name"], $target_file_trailer)) {
                $stmt = $conn->prepare("INSERT INTO film (poster, trailer, banner, nama_film, judul, total_menit, usia, genre, dimensi, Producer, Director, Writer, Cast, Distributor, harga) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                if (!$stmt) {
                    die("Error pada prepare statement: " . $conn->error);
                }
                $stmt->bind_param("ssssssssssssssi", $target_file_poster, $target_file_trailer, $target_file_banner, $nama_film, $judul, $menit, $usia, $genre, $dimensi, $producer, $director, $writer, $cast, $distributor, $harga);
                if ($stmt->execute()) {
                    echo "<script>
                        Swal.fire({
                            title: 'BERHASIL!',
                            text: 'Data film berhasil ditambahkan!',
                            icon: 'success',
                            timer: 3000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = 'admin/data_film.php';
                        });
                    </script>";
                    exit;
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Maaf, terjadi kesalahan saat mengupload file trailer.";
            }
        } else {
            echo "Maaf, terjadi kesalahan saat mengupload file banner.";
        }
    } else {
        echo "Maaf, terjadi kesalahan saat mengupload file poster.";
    }
}
$conn->close();
?>
