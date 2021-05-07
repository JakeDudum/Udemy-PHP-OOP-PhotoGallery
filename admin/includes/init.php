<?php

defined("SITE_ROOT") ? null : define("SITE_ROOT", $_SERVER['DOCUMENT_ROOT'] . '/Udemy-PHP-OOP-PhotGallery');

defined("INCLUDES_PATH") ? null : define("INCLUDES_PATH", SITE_ROOT . '/admin/includes');

require_once("functions.php");
require_once("config.php");
require_once("database.php");
require_once("db_object.php");
require_once("user.php");
require_once("photo.php");
require_once("session.php");
