<?php

declare(strict_types=1);

require_once __DIR__ . '/../php/Config.php';
require_once __DIR__ . '/../php/HtmlBuilder.php';
require_once __DIR__ . '/../php/ProjectGallery.php';
require_once __DIR__ . '/../php/XegoNexSpecConfig.php';
require_once __DIR__ . '/../php/XegoNexSpecSite.php';

header('Content-Type: text/html; charset=UTF-8');

$page = new XegoNexSpecSite();
echo $page->render();
