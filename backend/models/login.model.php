<?php

$file_path = getcwd() . "/models/users.json";

$users = json_decode(file_get_contents($file_path), true);
