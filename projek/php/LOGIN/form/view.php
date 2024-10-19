<?php
//Koneksi ke database
$servername = "localhost";
$username = "root"; // biasanya 'root' tanpa password
$password = ""; // biasanya kosong
$dbname = "db_data";

//Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

//Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

//Inisialisasi variabel pencarian
$search = "";
$result = null;


// Jika ada pencarian
if (isset($_POST['search'])) {
    $search = $conn->real_escape_string($_POST['search']);
    $sql = "SELECT * FROM parkir WHERE kode_unik LIKE '%$search%'";
    $result = $conn->query($sql);
}



$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Data Parkir</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/view.css"> 

</head>
<body >

<div class="menu-container">
    <div class="logo-container">
        <img src="logo2udg.png" alt="Logo"> <!-- Ganti dengan path logo Anda -->
    </div>
    <h2 style="color: white;">Menu</h2>
    <button class="accordion inactive" onclick="navigateTo('add.php', this)">Tambah Data</button>
    <button class="accordion active" onclick="navigateTo('view.php', this)">Lihat Data</button>

    <!-- Ganti dengan path logo anda -->
    <button class="logout" onclick="logout()">Logout</button>
</div>

<div class="data-container" background="Desain tanpa judul.png">
    <h2>Data Parkir</h2>
    
    <!-- Form Pencarian -->
    <form method="POST" action="">
    <input type="text" name="search" placeholder="Cari berdasarkan ID (kode_unik) atau No Plat..." value="<?php echo htmlspecialchars($search); ?>">

        <button class="cari" type="submit">Cari</button>
    </form>
    
    <table>
        <tr>
            <th>ID</th>
            <th>No Plat</th>
            <th>Type Kendaraan</th>
            <th>Keterangan</th>
            <th>Waktu</th>
        </tr>
        <?php
        // Tampilkan data jika ada hasil pencarian
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["kode_unik"] . "</td>
                        <td>" . $row["no_plat"] . "</td>
                        <td>" . $row["type_kendaraan"] . "</td>
                        <td>" . $row["keterangan"] . "</td>
                        <td>" . $row["waktu"] . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Tidak ada data ditemukan.</td></tr>";
        }
        ?>
    </table>
</div>

<script>
    function navigateTo(url, button) {
        var buttons = document.getElementsByClassName("accordion");
        for (let i = 0; i < buttons.length; i++) {
            buttons[i].classList.remove("active");
            buttons[i].classList.add("inactive");
        }
        button.classList.add("active");
        button.classList.remove("inactive");
        window.location.href = url;
    }

    function logout() {
        // Redirect to login.php
        window.location.href = '../Login.php'; // Ganti dengan path login Anda
    }
</script>

</body>
</html>
