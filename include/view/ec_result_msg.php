<?php
if (!empty($result_msg['err_msg'])) {
    echo '<p class="err_msg">' . $result_msg['err_msg'] . '</p>';
}

if (!empty($result_msg['suc_msg'])) {
    echo '<p class="suc_msg">' . $result_msg['suc_msg'] . '</p>';
}

