<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
//Periksa apakah id kontak ada, misalnya update.php?id=1 akan mendapatkan kontak dengan id 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // Bagian ini mirip dengan create.php, tetapi sebagai gantinya untuk memperbarui catatan dan tidak menyisipkan
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $merk_handphone = isset($_POST['merk_handphone']) ? $_POST['merk_handphone'] : '';
        $tipe = isset($_POST['tipe']) ? $_POST['tipe'] : '';
        $rilis = isset($_POST['rilis']) ? $_POST['rilis'] : '';
        
        // Update the record
        $stmt = $pdo->prepare('UPDATE handphone SET id = ?, merk_handphone = ?, tipe = ?, rilis = ? WHERE id = ?');
        $stmt->execute([$id, $merk_handphone, $tipe, $rilis, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    $stmt = $pdo->prepare('SELECT * FROM handphone WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $electronic = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$electronic) {
        exit('Elektronik tidak ada dengan ID itu!');
    }
} else {
    exit('Tidak ada ID yang ditentukan!');
}
?>



<?=template_header('Read')?>

<div class="content update">
	<h2>Update Electronic #<?=$electronic['id']?></h2>
    <form action="update.php?id=<?=$electronic['id']?>" method="post">
        <label for="id">ID</label>
        <input type="text" name="id" value="<?=$electronic['id']?>" id="id">
        <label for="merk_handphone">Merk Handphone</label>
        <input type="text" name="merk_handphone" value="<?=$electronic['merk_handphone']?>" id="merk_handphone">
        <label for="tipe">Tipe</label>
        <input type="text" name="tipe" value="<?=$electronic['tipe']?>" id="tipe">
        <label for="rilis">Rilis</label>
        <input type="text" name="rilis" value="<?=$electronic['rilis']?>" id="rilis">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>