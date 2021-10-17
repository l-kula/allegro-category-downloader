<?php

declare(strict_types=1);

namespace Lkula\AllegroCategories\Category;

use SimpleXMLElement;

/**
 * Class CategoryChangesMapper
 *
 * @package Lkula\AllegroCategories\Category
 */
class CategoryChangesMapper
{
    private const LAST_CHANGE_FILE_PATH = './var/last_change.txt';

    private const CATEGORY = 'category';
    private const ID = 'id';
    private const NAME = 'name';
    private const PARENT_ID = 'parentId';
    private const PARENT = 'parent';
    private const CHANGE = 'change';
    private const EVENTS = 'events';
    private const CHANGES = 'changes';
    private const REDIRECT_CATEGORY = 'redirectCategory';

    private CategoryChangesClient $categoryChangesClient;

    public function __construct(string $accessToken)
    {
        $this->categoryChangesClient = new CategoryChangesClient($accessToken);
    }

    private function getChanges(): array
    {
        $lastId = file_get_contents(self::LAST_CHANGE_FILE_PATH);
        $response = $this->categoryChangesClient->getChanges($lastId);
        $contents = $response->getBody()->getContents();

        return json_decode($contents, true);
    }

    public function arrayToXml(SimpleXMLElement $data, array $arrayData = null): void
    {
        $arrayData = $arrayData ?? $this->getChanges();

        $changesNode = $data->addChild(self::CHANGES);
        $allEvents = $arrayData[self::EVENTS];
        $numberOfEvents = count($allEvents);
        foreach ($allEvents as $idx => $events) {
            $changeNode = $changesNode->addChild(self::CHANGE . $idx);

            foreach ($events as $label => $value) {
                switch ($label) {
                    case self::CATEGORY:
                        $this->mapCategories($changeNode, $value);
                        break;
                    case self::REDIRECT_CATEGORY:
                        break;
                    default:
                        $changeNode->addChild($label, htmlspecialchars($value));
                }
            }

            if ($idx === $numberOfEvents - 1) {
                file_put_contents(self::LAST_CHANGE_FILE_PATH, $events[self::ID]);
            }
        }
    }

    private function mapCategories(SimpleXMLElement $node, array $data): void
    {
        $categoryChild = $node->addChild(self::CATEGORY);

        $categoryChild->addChild(self::ID, $data[self::ID]);
        $categoryChild->addChild(self::NAME, $data[self::NAME]);
        $categoryChild->addChild(self::PARENT_ID, $data[self::PARENT][self::ID]);
    }
}