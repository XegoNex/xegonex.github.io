<?php

declare(strict_types=1);

require_once __DIR__ . '/../php/Config.php';
require_once __DIR__ . '/../php/HtmlBuilder.php';
require_once __DIR__ . '/../php/ProjectGallery.php';
require_once __DIR__ . '/../php/XegoSpecialConfig.php';
require_once __DIR__ . '/../php/XegoSpecialSite.php';

header('Content-Type: text/html; charset=UTF-8');

$page = new XegoSpecialSite();
echo $page->render();
