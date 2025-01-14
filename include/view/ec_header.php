<header>
    <ul class="header-upper">
        <li><h1>わがしやさん！！！！！</h1></li>
        <?php
        foreach ($links as $link_title => $link_url){
            echo '<li><a href="' . $link_url .'">' . $link_title . '</a></li>';
        }
        ?>
    </ul>
    <?php
    if (!empty($_SESSION['user_name'])) {
        echo '<p class="header-lower">ようこそ！' . $_SESSION['user_name'] . 'さん</p>';
    }
    ?>
</header>