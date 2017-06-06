<?php
if (preg_match("/^(\d+)/", phpversion(), $m)) {
    if (intval($m[0]) < 5) {
        ?>
        <h1>Cyberspace-Networks > CoreSystem requires PHP5</h1>

        <p>Your web server is running PHP version <b><?php echo phpversion(); ?></b>.  Unfortunately, Cyberspace-Networks > CoreSystem requires PHP5 or later.</p>

        <p><a href="https://github.com/Cyberspace-Networks/CoreSystem/wiki/PHP5">Click here for some information on installing or enabling PHP5 on typical web servers</a> (on the Cyberspace-Networks Wiki).</p>

        <?php
        exit;
    }
}