<?php
ob_start();
?>

<section class="homepage">
    <h1>blog</h1>
    <p>une embience café au lait</p>
</section>

<?php

$content = ob_get_clean();
require VIEWS . 'layout.php';
