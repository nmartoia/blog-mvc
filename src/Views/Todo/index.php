<?php
ob_start();

?>

<section class="dashboard">
    <div class="topDashBoard">
        <h1><i class="fas fa-list-alt"></i> Blog :</h1>
        <?php
        if (isset($_SESSION["user"]["username"])) {
        ?>
            <a href="/dashboard/nouveau">
                <i class="fas fa-plus-circle"></i>
            </a>
        <?php
        }
        ?>
    </div>

    <div class="blockAllList" id="masonry">

        <?php
        foreach ($todos as $todo) {
        ?>
            <div class="blockCard">
                <div class="card index">
                    <div class="top">
                        <div class="flex">
                            <p class="titre">Titre : <?php echo escape($todo->getName()); ?></p>
                            <p class="titre">Description : <?php echo escape($todo->getCom()); ?></p>
                            <p class="titre">Le : <?php echo $todo->getDate(); ?></p>
                            <p class="titre">De : <?php echo $todo->getUsername($todo->getUser_id()); ?></p>
                            <p>Image : </p>
                        </div>
                        <a class="oeil" href="/dashboard/<?php echo escape($todo->getName()); ?>"><i class="fas fa-eye"></i></a>
                    </div>
                    <img style="width: 100px; margin: 0 auto;" src="img/<?php echo $todo->getImg(); ?>" alt="img du blog">
                    <div class="separateur"></div>
                    <div class="bottom">
                        <?php
                        foreach ($todo->taskslimite(3) as $taches) {
                        ?>
                            <div class="card comment">
                                <div>
                                    <p>
                                        <span>Le : <?php echo escape($taches->getDate()); ?></span>
                                        <span>. De : <?php echo $taches->getUsername($taches->getUser_id()); ?></span>
                                    </p>
                                    <p class="commentaire">commentaire : <?php echo escape($taches->getNames()); ?></p>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        <a class="aligne"href="/dashboard/<?php echo escape($todo->getName());?>">voir plus</a>
                    </div>
                </div>
            </div>

        <?php
        }
        ?>

    </div>


</section>

<script>
    let container = document.getElementById('masonry');

    let nb_col = window.innerWidth > 1024 ? 3 : window.innerWidth > 768 ? 3 : 1;

    let col_height = [];

    for (var i = 0; i <= nb_col; i++) {
        col_height.push(0);
    }

    for (var i = 0; i < container.children.length; i++) {
        let order = (i + 1) % nb_col || nb_col;
        container.children[i].style.order = order;
        col_height[order] += container.children[i].clientHeight;
    }
    container.style.height = Math.max.apply(Math, col_height) + 50 + 'px';
</script>
<?php

$content = ob_get_clean();
require VIEWS . 'layout.php';
