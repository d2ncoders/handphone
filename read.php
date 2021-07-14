<?php
include 'functions.php';
// Hubungkan ke database MySQL
$pdo = pdo_connect_mysql();
// Dapatkan halaman melalui permintaan GET (param URL: halaman), jika tidak ada, default halaman ke 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Jumlah catatan untuk ditampilkan di setiap halaman
$records_per_page = 5;


$stmt = $pdo->prepare('SELECT * FROM handphone ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Ambil catatan sehingga untuk dapat menampilkannya di template.
$electronics = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Dapatkan jumlah total elektronik, ini agar kita dapat menentukan apakah harus ada tombol berikutnya dan sebelumnya
$num_electronics = $pdo->query('SELECT COUNT(*) FROM handphone')->fetchColumn();
?>


<?=template_header('Read')?>

<div class="content read">
	<h2>Read Handphone New</h2>
	<a href="create.php" class="create-electronic">Create Handphone</a>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Merk Handphone</td>
                <td>Tipe</td>
                <td>Rilis</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($electronics as $electronic): ?>
            <tr>
                <td><?=$electronic['id']?></td>
                <td><?=$electronic['merk_handphone']?></td>
                <td><?=$electronic['tipe']?></td>
                <td><?=$electronic['rilis']?></td>
                <td class="actions">
                    <a href="update.php?id=<?=$electronic['id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?id=<?=$electronic['id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_electronics): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>