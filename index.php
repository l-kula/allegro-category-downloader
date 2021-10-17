<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Exception\GuzzleException;
use Lkula\AllegroCategories\Authorization\AuthorizationManager;
use Lkula\AllegroCategories\Category\CategoryChangesMapper;
use Lkula\AllegroCategories\Category\CategoryMapper;

$directoryResults = '/cgi-bin/allegro/results/';

$authorizationManager = new AuthorizationManager();
try {
    $authorizationData = $authorizationManager->authorize();
} catch (GuzzleException $exception) {
    echo 'Authorization error: ' . $exception->getMessage();
    die;
}
// ================================== Kategorie ===================================================================== //
$categoryXml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><data></data>');

$categoryMapper = new CategoryMapper($authorizationData->getAccessToken());
$categoryMapper->arrayToXml($categoryXml);

$result = $categoryXml->asXML($directoryResults . 'categories.xml');

// ================================== Zmiany Kategorii ============================================================== //
$changesXml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><data></data>');

$categoryMapper = new CategoryChangesMapper($authorizationData->getAccessToken());
$categoryMapper->arrayToXml($changesXml);

$result = $changesXml->asXML($directoryResults . 'changes.xml');
