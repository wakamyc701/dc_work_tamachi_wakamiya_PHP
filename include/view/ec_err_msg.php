<?php
if (!empty($_SESSION['err_msg'])) {
    echo '<p class="err_msg">' . $_SESSION['err_msg'] . '</p>';
}
