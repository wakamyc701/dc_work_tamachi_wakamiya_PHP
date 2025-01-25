<header>
    <ul class="header_upper">
        <li><h1>わぁ！菓子屋さん本舗</h1></li>
        <?php
        foreach ($links as $link_title => $link_url){
            echo '<li><a href="' . $link_url .'">' . $link_title . '</a></li>';
        }
        ?>
    </ul>
    <?php
    if (!empty($_SESSION['user_name'])) {
        echo '<p class="header_lower">' . $_SESSION['user_name'] . 'さん、ようこそ！</p>';
    }
    ?>
</header>