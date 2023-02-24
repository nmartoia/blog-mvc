<?php
ob_start();
?>

<section class="create">
    <h1><i class="fas fa-list-alt"></i> Création Todolist :</h1>

    <div>
        <div class="list">
            <div class="top">
                <form action="/dashboard/nouveau" method="post" enctype="multipart/form-data">
                    <input type="text" name="name" value="<?php echo old("name"); ?>" placeholder="titre">
                    <input type="text" name="com" value="<?php echo old("com"); ?>" placeholder="description">
                    <button type="submit" name="button"><i class="fas fa-plus"></i></button>

                    <span class="error"><?php echo error("name"); ?></span>
            </div>
            <p style="color: white;">* photo de moin de 2Mo : </p>
            <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
            <input type="file" name="fille" style="color: white;" required>
            </form>
        </div>


    </div>

</section>

<?php
$content = ob_get_clean();
require VIEWS . 'layout.php';
