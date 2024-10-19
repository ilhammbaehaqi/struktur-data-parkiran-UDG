<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_data";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$message = '';
if (isset($_POST['submit'])) {
    $no_plat = $_POST['no_plat'];
    $type_kendaraan = $_POST['type_kendaraan'];
    $keterangan = $_POST['keterangan'];
    $waktu = date('Y-m-d H:i:s');

    // Generate kode unik
    $kode_unik = uniqid('PKR_');

    $stmt = $conn->prepare("INSERT INTO parkir (no_plat, type_kendaraan, keterangan, waktu, kode_unik) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $no_plat, $type_kendaraan, $keterangan, $waktu, $kode_unik);

    if ($stmt->execute()) {
        $message = 'Data berhasil ditambahkan!';
    } else {
        $message = 'Error: ' . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Parkir</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../CSS/view.css"> 
</head>
<body>

<div class="menu-container">
    <div class="logo-container">
        <img src="logo2udg.png" alt="Logo">
    </div>
    <h2 style="color: white;">Menu</h2>
    <button class="accordion active" onclick="navigateTo('add.php', this)">Tambah Data</button>
    <button class="accordion inactive" onclick="navigateTo('view.php', this)">Lihat Data</button>

       <!-- Ganti dengan path logo anda -->
       <button class="logout" onclick="logout()">Logout</button>
</div>

<div class="content-container">
    <h2>Form Tambah Data Parkir</h2>
    <form method="post" action="">
        <input type="text" name="no_plat" placeholder="No Plat" required>
        <input type="text" name="type_kendaraan" placeholder="Type Kendaraan" required>
        <input type="text" name="keterangan" placeholder="Keterangan" required>
        <input type="datetime-local" name="waktu" value="<?php echo date('Y-m-d\TH:i'); ?>" required>
        <input type="submit" name="submit" value="Tambah Data">
    </form>
    <?php if ($message): ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
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
