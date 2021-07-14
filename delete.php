<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Periksa apakah ID elektronik ada
if (isset($_GET['id'])) {
    // Pilih record yang akan dihapus
    $stmt = $pdo->prepare('SELECT * FROM handphone WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $electronic = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$electronic) {
        exit('Elektronik tidak ada dengan ID itu!');
    }
    // Pastikan pengguna mengonfirmasi sebelum penghapusan
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'ya') {
            // Pengguna mengklik tombol "Ya", hapus catatan
            $stmt = $pdo->prepare('DELETE FROM handphone WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'Anda telah menghapus elektronik!';
        } else {
            // Pengguna mengklik tombol "Tidak", mengarahkan mereka kembali ke halaman baca
            header('Location: read.php');
            exit;
        }
    }
} else {
    exit('Tidak ada ID yang ditentukan!');
}
?>

<?=template_header('Delete')?>

<div class="content delete">
	<h2>Delete Electronic #<?=$electronic['id']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Anda yakin ingin menghapus Electronic Handphone ini #<?=$electronic['id']?>?</p>
    <div class="yatidak">
        <a href="delete.php?id=<?=$electronic['id']?>&confirm=ya">Ya</a>
        <a href="delete.php?id=<?=$electronic['id']?>&confirm=tidak">Tidak</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>