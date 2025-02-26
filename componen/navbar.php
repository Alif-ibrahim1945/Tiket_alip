<?php
$username = isset($_SESSION['name']) ? $_SESSION['name'] : '';

// Pastikan role adalah user sebelum menampilkan nama
$showUsername = isset($showUsername) ? $showUsername : false;
if (isset($_SESSION['role']) && $_SESSION['role'] == 'user') {
    $showUsername = true;
}
?>

<header style="z-index: 1000; position: relative;">

    <div class="container-menu-desktop">
        <div class="wrap-menu-desktop">
            <nav class="limiter-menu-desktop container">
                <a href="#" class="logo" style="font-size: 24px; color: blue; text-decoration: none; font-weight: bold;">COZA CINEMA</a>
                <div class="menu-desktop">
                    <ul class="main-menu">
                        <li><a href="index2.php">Home</a></li>
                        <li><a href="upcoming.php">Upcoming</a></li>
                        <li><a href="teater.php">Theater</a></li>
                        <li>
                            <a href="#">Usia</a>
                            <ul class="sub-menu">
                                <li><a href="usia.php?usia=SU" class="dropdown-item">SU</a></li>
                                <li><a href="usia.php?usia=13" class="dropdown-item">13</a></li>
                                <li><a href="usia.php?usia=17" class="dropdown-item">17</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">Genre</a>
                            <ul class="sub-menu" style="max-height: 200px; overflow-y: auto; border: 1px solid #ccc; padding: 5px;">
                                <li><a class="dropdown-item" href="genre.php?genre=Adventure">Adventure</a></li>
                                <li><a class="dropdown-item" href="genre.php?genre=Action">Action</a></li>
                                <li><a class="dropdown-item" href="genre.php?genre=Animation">Animation</a></li>
                                <li><a class="dropdown-item" href="genre.php?genre=Biography">Biography</a></li>
                                <li><a class="dropdown-item" href="genre.php?genre=Cartoon">Cartoon</a></li>
                                <li><a class="dropdown-item" href="genre.php?genre=Comedy">Comedy</a></li>
                                <li><a class="dropdown-item" href="genre.php?genre=Crime">Crime</a></li>
                                <li><a class="dropdown-item" href="genre.php?genre=Disaster">Disaster</a></li>
                                <li><a class="dropdown-item" href="genre.php?genre=Documentary">Documentary</a></li>
                                <li><a class="dropdown-item" href="genre.php?genre=Drama">Drama</a></li>
                                <li><a class="dropdown-item" href="genre.php?genre=Epic">Epic</a></li>
                                <li><a class="dropdown-item" href="genre.php?genre=Erotic">Erotic</a></li>
                                <li><a class="dropdown-item" href="genre.php?genre=Experimental">Experimental</a></li>
                                <li><a class="dropdown-item" href="genre.php?genre=Family">Family</a></li>
                                <li><a class="dropdown-item" href="genre.php?genre=Fantasy">Fantasy</a></li>
                                <li><a class="dropdown-item" href="genre.php?genre=Film-Noir">Film-Noir</a></li>
                                <li><a class="dropdown-item" href="genre.php?genre=History">History</a></li>
                                <li><a class="dropdown-item" href="genre.php?genre=Horror">Horror</a></li>
                                <li><a class="dropdown-item" href="genre.php?genre=Martial Arts">Martial Arts</a></li>
                                <li><a class="dropdown-item" href="genre.php?genre=Music">Music</a></li>
                                <li><a class="dropdown-item" href="genre.php?genre=Musical">Musical</a></li>
                                <li><a class="dropdown-item" href="genre.php?genre=Mystery">Mystery</a></li>
                                <li><a class="dropdown-item" href="genre.php?genre=Political">Political</a></li>
                                <li><a class="dropdown-item" href="genre.php?genre=Psychological">Psychological</a></li>
                                <li><a class="dropdown-item" href="genre.php?genre=Romance">Romance</a></li>
                                <li><a class="dropdown-item" href="genre.php?genre=Sci-Fi">Sci-Fi</a></li>
                                <li><a class="dropdown-item" href="genre.php?genre=Sport">Sport</a></li>
                                <li><a class="dropdown-item" href="genre.php?genre=Superhero">Superhero</a></li>
                                <li><a class="dropdown-item" href="genre.php?genre=Survival">Survival</a></li>
                                <li><a class="dropdown-item" href="genre.php?genre=Thriller">Thriller</a></li>
                                <li><a class="dropdown-item" href="genre.php?genre=War">War</a></li>
                                <li><a class="dropdown-item" href="genre.php?genre=Western">Western</a></li>


                            </ul>
                        </li>
                    </ul>

                </div>
                <div>

                </div>
                <div class="wrap-icon-header flex-w flex-r-m" style="display: flex; align-items: center; gap: 10px;">
                <div style="display: flex; gap: 5px; align-items: center;">
    <input type="text" id="searchMovie" name="searchMovie" placeholder="Cari film..." 
        style="padding: 5px 10px; border: 1px solid #ccc; border-radius: 5px; outline: none; width: 200px;">
    <button id="searchButton" style="padding: 5px 10px; border: none; background-color: #007bff; color: white; border-radius: 5px; cursor: pointer;">
        Cari
    </button>
</div>

<!-- Dropdown hasil pencarian -->
<ul id="movieResults"></ul>


    <?php if (!$username): ?>
        <a href="login.php" class="btn btn-primary" style="padding: 5px 10px; border-radius: 5px; background-color: #007bff; color: white; text-decoration: none;">
            Login
        </a>
    <?php endif; ?>

    <!-- Dropdown User -->
    <div class="dropdown" style="margin-left: 15px; position: relative; display: inline-block; text-align: center;">
        <button style="background: none; border: none; cursor: pointer; font-size: 18px; display: flex; flex-direction: column; align-items: center;">
            <i class="zmdi zmdi-account" style="font-size: 40px;"></i>
            <?php if ($username): ?>
                <span style="margin-top: 5px; font-size: 16px; font-weight: bold;"><?php echo htmlspecialchars($username); ?></span>
            <?php endif; ?>
        </button>
        <div class="dropdown-content" style="display: none; position: absolute; background-color: white; min-width: 120px; box-shadow: 0px 8px 16px rgba(0,0,0,0.2); z-index: 1;">
            <?php if (!$username): ?>
                <a href="login.php" style="padding: 8px 12px; display: block; text-decoration: none; color: black;">Login</a>
            <?php else: ?>
                <a href="logout.php" style="padding: 8px 12px; display: block; text-decoration: none; color: black;">Logout</a>
                <a class="dropdown-item" href="riwayat.php?username=<?php echo $_SESSION['email']; ?>" style="padding: 8px 12px; display: block; text-decoration: none; color: black;">Riwayat Transaksi</a>
            <?php endif; ?>
        </div>
    </div>
</div>


            </nav>
        </div>
    </div>
</header>
<style>
    #movieResults {
    display: none;
    position: absolute;
    background-color: white;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 215px;
    margin-top: 5px;
    padding: 0;
    list-style: none;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
    max-height: 200px;
    overflow-y: auto;
    z-index: 50;
}

#movieResults li {
    padding: 8px 12px;
    cursor: pointer;
}

#movieResults li:hover {
    background-color: #f0f0f0;
}
</style>
<script>
  document.getElementById("searchButton").addEventListener("click", function () {
    handleSearch();
});

document.getElementById("searchMovie").addEventListener("keydown", function (e) {
    if (e.key === "Enter") {
        handleSearch();
    }
});

function handleSearch() {
    const query = document.getElementById("searchMovie").value.trim();
    const resultsList = document.getElementById("movieResults");

    if (query.length > 0) {
        fetch(`get_movies.php?q=${query}`)
            .then(response => response.json())
            .then(data => {
                resultsList.innerHTML = ""; // Hapus hasil lama

                if (data.length === 1) {
                    // Jika hasil pencarian hanya satu, langsung arahkan ke halaman film
                    window.location.href = `film.php?id=${data[0].id}`;
                } else if (data.length > 1) {
                    // Jika hasil pencarian lebih dari satu, tampilkan dropdown
                    data.forEach(movie => {
                        const li = document.createElement("li");
                        li.textContent = movie.nama_film;
                        li.className = "p-2 hover:bg-blue-100 cursor-pointer transition-all duration-200";

                        // Redirect ke film.php saat hasil diklik
                        li.onclick = () => {
                            window.location.href = `film.php?id=${movie.id}`;
                        };

                        resultsList.appendChild(li);
                    });

                    resultsList.style.display = "block"; // Tampilkan dropdown
                } else {
                    resultsList.style.display = "none"; // Sembunyikan dropdown jika tidak ada hasil
                    alert("Film tidak ditemukan!"); // Tampilkan pesan jika tidak ada hasil
                }
            })
            .catch(error => console.error("Error fetching data:", error));
    } else {
        resultsList.style.display = "none"; // Sembunyikan dropdown jika query kosong
        alert("Masukkan nama film!"); // Tampilkan pesan jika query kosong
    }
}

document.addEventListener("click", function (e) {
    const searchInput = document.getElementById("searchMovie");
    const resultsList = document.getElementById("movieResults");

    if (!searchInput.contains(e.target) && !resultsList.contains(e.target)) {
        resultsList.style.display = "none"; // Sembunyikan dropdown
    }
});
</script>

<script>
    document.querySelector('.dropdown button').addEventListener('click', function() {
        let dropdown = document.querySelector('.dropdown-content');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', function(event) {
        if (!event.target.closest('.dropdown')) {
            document.querySelector('.dropdown-content').style.display = 'none';
        }
    });
</script>