<?php
foreach (["admins.php","users.php"] as  $value) {
    require_once(module_path('User', 'Routes/dashboard/'.$value));
}
