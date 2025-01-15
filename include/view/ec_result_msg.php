<?php
if (!empty($_SESSION['err_msg'])) {
    echo '<p class="err_msg">' . $_SESSION['err_msg'] . '</p>';
}

if (!empty($_SESSION['suc_msg'])) {
    echo '<p class="suc_msg">' . $_SESSION['suc_msg'] . '</p>';
}

