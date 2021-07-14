<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $merk_handphone = isset($_POST['merk_handphone']) ? $_POST['merk_handphone'] : '';
    $tipe = isset($_POST['tipe']) ? $_POST['tipe'] : '';
    $rilis = isset($_POST['rilis']) ? $_POST['rilis'] : '';

    // Insert new record into the handphone table
    $stmt = $pdo->prepare('INSERT INTO handphone VALUES (?, ?, ?, ?)');
    $stmt->execute([$id, $merk_handphone, $tipe, $rilis]);
    // Output message
    $msg = 'Created Successfully!';
}
?>


<?=template_header('Create')?>

<div class="content update">
	<h2>Create Handphone</h2>
    <form action="create.php" method="post">
        <label for="id">ID</label>
        <input type="text" name="id" value="auto" id="id">
        <label for="merk_handphone">Merk Handphone</label>
        <input type="text" name="merk_handphone" id="merk_handphone">
        <label for="tipe">Tipe</label>
        <input type="text" name="tipe" id="tipe">
        <label for="rilis">Rilis</label>
        <input type="text" name="rilis" id="rilis">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>