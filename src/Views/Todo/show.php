<?php

use Blog\Models\Todo;

ob_start();
?>

<section class="sectionView">

    <div id="modalDelete" class="modal">
        <div>
            <p>Voulez-vous vraiment suprimer votre liste ?</p>
            <p>Vous allez perdre toute vos tâches associées !</p>
            <div>
                <button type="button" id="btnUndoDel" name="button">Annuler</button>
                <form class="formDelete" action="/dashboard/<?php echo escape($todo->getName()); ?>/delete" method="post">
                    <input type="hidden" name="idList" value="<?php echo escape($todo->getId()); ?>">
                    <button type="submit" name="button">Supprimer</button>
                </form>
            </div>
        </div>
    </div>

    <div class="viewList">
        <div class="top">
            <div class="enleveTodolist">
                <div <?php
                        if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] == $todo->getUser_id()) {
                        ?>class="
                            showEdit
                            " <?php
                            }
                                ?>>
                    <p class="nameList">
                        <span title="Edit Titre">Titre : <?php echo escape($todo->getName()); ?></span>
                        <span title="Edit Description">. Description : <?php echo escape($todo->getCom()); ?></span>
                        <?php
                        if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] == $todo->getUser_id()) {
                        ?>
                        <?php
                        }
                        ?>
                    <p class="hoverInfo">Edit Article</p>
                    </p>
                    <?php
                    if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] == $todo->getUser_id()) {
                    ?>
                    <?php
                    }
                    ?>
                </div>
                <div>
                    <p>
                        <span>Le : <?php echo escape($todo->getDate()); ?></span>
                        <span>. De : <?php echo $todo->getUsername($todo->getUser_id()); ?></span>
                    </p>
                    <p>Image : </p>
                    <img style="width: 100px;display: block; margin: 0 auto;" src="../img/<?php echo $todo->getImg(); ?>" alt="img du blog">
                </div>
            </div>

            <div class="afficheInput hiddenEdit">
                <form class="formEdit" action="/dashboard/<?php echo escape($todo->getName()) . '/';
                                                            echo escape($todo->getCom()); ?>" method="post">
                    <div class="labelInput">
                        <label for="nameTodo"><i class="fas fa-pen"></i></label>
                        <input type="text" name="nameTodo" value="<?php echo old("nameTodo") ? old("nameTodo") : escape($todo->getName()); ?>" placeholder="edit Titre">
                        <input type="text" name="desc" value="<?php echo old("nameDesc") ? old("nameDesc") : escape($todo->getCom()); ?>" placeholder="edit Description">
                    </div>
                    <button type="submit" name="button"><i class="fas fa-check"></i></button>
                    <p id="btnDeleteList" title="Suprimer Article"><i class="fas fa-trash"></i></p>
                </form>
            </div>

            <span class="error"><?php echo error("nameTodo"); ?></span>
        </div>

        <div class="separateur"></div>

        <div class="bottom">
            <?php
            if (isset($_SESSION["user"]["username"])) {
            ?>
                <div class="blockForm">
                    <form action="/dashboard/task/nouveau" method="post">
                        <i class="iconTask fas fa-tasks"></i>
                        <input type="text" name="nameTask" value="<?php echo old("nameTask"); ?>" placeholder="commentaire">
                        <input type="hidden" name="nameList" value="<?php echo $todo->getName(); ?>">
                        <input type="hidden" name="list_id" value="<?php echo $todo->getId(); ?>">
                        <button type="submit" name="button"><i class="fas fa-plus"></i></button>
                    </form>
                </div>
            <?php
            }
            ?>
            <span class="error" style="text-align: center;"><?php echo error("name"); ?></span>
            <div class="tache">
                <?php
                foreach ($todo->tasks() as $taches) {
                ?>
                    <div class="blockCard">
                        <div class="card">
                            <div>
                                <p>
                                    <span>Le : <?php echo escape($taches->getDate()); ?></span>
                                    <span>. De : <?php echo $taches->getUsername($taches->getUser_id()); ?></span>
                                </p>
                                <p class="commentaire">commentaire : <?php echo escape($taches->getNames()); ?></p>
                            </div>
                            <div class="top">

                                <?php
                                if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] == $taches->getUser_id()) {
                                ?>
                                    <a href="/dashboard/<?php echo escape($todo->getName()); ?>/task/<?php echo escape($taches->getNames()); ?>/<?php echo escape($taches->getId()); ?>/delete"><i class="fas fa-trash"></i></a>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>



<script>
    let showEdit = document.getElementsByClassName('showEdit');
    let body = document.querySelector('body');
    body.style.overflow='hidden'
    let enleveTodolist = document.getElementsByClassName('enleveTodolist');
    let afficheInput = document.getElementsByClassName('afficheInput');
    <?php
    if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] == $todo->getUser_id()) {
    ?>
        Array.from(showEdit).map(function(element, index) {
            element.addEventListener('click', function() {
                enleveTodolist[index].style.display = 'none';
                afficheInput[index].style.display = 'flex';
            })
        })
    <?php
    }
    ?>
    let btnDelete = document.getElementById('btnDeleteList');
    let btnUndoDel = document.getElementById('btnUndoDel');
    let modalDelete = document.getElementById('modalDelete');
    <?php
    if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] == $todo->getUser_id()) {
    ?>
        btnDelete.addEventListener('click', function() {



            console.log(2);
            modalDelete.style.display = 'flex';
        });
    <?php
    }
    if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] == $todo->getUser_id()) {
    ?>
        btnUndoDel.addEventListener('click', function() {
            console.log(2);
            modalDelete.style.display = 'none';
        });
    <?php
    }
    ?>
</script>

<?php

$content = ob_get_clean();
require VIEWS . 'layout.php';
