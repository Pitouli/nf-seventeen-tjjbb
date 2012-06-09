<?php

if(isset($_POST['password']) && $_POST['password'] == PASSWORD) $_SESSION['connected'] = true;
else $_SESSION['connected'] = false;

