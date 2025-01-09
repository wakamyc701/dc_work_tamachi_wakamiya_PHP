<header>
    <ul class="header-box">
        <li><h1>ECサイト！！！！！</h1></li>
        <?php
        foreach ($links as $link_title => $link_url){
            echo '<li><a href="' . $link_url .'">' . $link_title . '</a></li>';
        }
        ?>
    </div>
</header>