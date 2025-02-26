<?php
// Header untuk respons JSON
header("Content-Type: application/json; charset=UTF-8");

// Include file koneksi database
include 'koneksi.php';

// Periksa koneksi database
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil query pencarian
$query = isset($_GET['q']) ? $_GET['q'] : '';

// Query SQL untuk mencari film
$sql = "SELECT id, nama_film FROM film WHERE nama_film LIKE '%$query%' LIMIT 10";
$result = $conn->query($sql);

// Periksa apakah query berhasil
if ($result === false) {
    die("Error dalam query: " . $conn->error);
}

// Ambil data hasil query
$movies = [];
while ($row = $result->fetch_assoc()) {
    $movies[] = [
        "id" => $row['id'],
        "nama_film" => $row['nama_film']
    ];
}

// Tutup koneksi database
$conn->close();

// Kembalikan data dalam format JSON
echo json_encode($movies);
?>