<?php
if (!isset($_COOKIE['mode'])) {
    setcookie('mode', 'light', time() + (10 * 365 * 24 * 60 * 60), "/");
    return @$_COOKIE['mode'];
} else {
    return @$_COOKIE['mode'];
}
