<?php
// Database connection for vasanthamrealty.com
$con = mysqli_connect("localhost", "vasantha_remsdb", "ErHz77ncQwdzfKx8NsF3", "vasantha_remsdb");
if (mysqli_connect_errno()) {
    echo "Connection Fail: " . mysqli_connect_error();
}
?>