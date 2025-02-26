<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="Viewport" content="width=device -width, initial-scale=1.0">
        <title>input film</title>
    </head>
    <body>
        <h1>Input film</h1>
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
        <form action="proses_input.php" method="POST" enctype="multipart/form-data">
            <div>
                <label for="poster">Upload poster</label>
                <input type="file" id="poster" name="poster" accept="image/*" required>
            </div>
            <div>
                <label for="nama_film">Nama film</label>
                <input type="text" name="nama_film" id="nama_film" required>
            </div>
            <div>
            <label for="genre">Genre</label>
            <select id="genreSelect">
                <option value="" disabled selected>Pilih genre</option>
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
            <button type="button" onclick="addGenre()">Tambah</button>
        </div>
            <ul id="selectedGenres" class="mt-3 list-group d-flex flex-wrap" style="max-height: 200px; overflow-y: auto;"></ul>
            <input type="hidden" id="genreInput" name="genre">
            <div>
                <label for="banner">Upload banner</label>
                <input type="file" name="banner" id="banner" accept="image/*" required>
            </div>
            <div>
                <label for="menit">Total menit</label>
                <input type="text" name="menit" id="menit" required>
            </div>
            <div>
                <label for="usia">usia</label>
            <select name="usia" id="usia" required>
                <option value="" disabled selected>Pilih usia</option>
                <option value="13">13+</option>
                <option value="17">17+</option>
                <option value="SU">SU+</option>
            </select>
            </div>
            <div>
                <label for="trailer">Upload trailer</label>
                <input type="file" id="trailer" name="trailer" accept="video/*">
            </div>
            <div>
                <label for="judul">Deksripsi</label>
                <input type="text" id="judul" name="judul" required>
            </div>
            <div>
                <label for="dimensi">Berapa dimensi</label>
                <select name="dimensi" id="dimensi" required>
                    <option value="" disabled selected>pilih dimensi</option>
                    <option value="2D">2D</option>
                    <option value="3D">3D</option>
                </select>
            </div>
            <div>
                <label for="producer">producer</label>
                <input type="text" id="producer" name="producer" required>
            </div>
            <div>
                <label for="director">Director</label>
                <input type="text" id="director" name="director" required>
            </div>
            <div>
                <label for="writer">Writer</label>
                <input type="text" id="writer" name="writer" required>
            </div>
            <div>
                <label for="cast">cast</label>
                <input type="text" id="cast" name="cast" required>
            </div>
            <div>
                <label for="distributor">distributor</label>
                <input type="text" id="distributor" name="distributor" required>
            </div>
            <div>
                <label for="harga">harga per tiket</label>
                <input type="number" name="harga" id="harga" required>
            </div>
            <button type="submit"> Simpan</button>
        </form>
    </body>
</html>