<?php

declare(strict_types=1);

namespace Lkula\AllegroCategories\Category;

use SimpleXMLElement;

/**
 * Class CategoryMapper
 *
 * @package Lkula\AllegroCategories\Category
 */
class CategoryMapper
{
    private const ID = 'id';
    private const NAME = 'name';
    private const LEAF = 'leaf';
    private CategoryClient $categoryClient;
    private int $deep = 0;

    public function __construct(string $accessToken)
    {
        $this->categoryClient = new CategoryClient($accessToken);
    }

    private function getCategories($parentId = null): array
    {
        $response = $this->categoryClient->getCategories($parentId);
        $contents = $response->getBody()->getContents();

        return json_decode($contents, true);
    }

    public function arrayToXml(SimpleXMLElement $data, array $arrayData = null): void
    {
        $arrayData = $arrayData ?? $this->getCategories();

        $categoriesNode = $data->addChild('categories');
        foreach ($arrayData['categories'] as $idx => $category) {
            $categoryNode = $categoriesNode->addChild('category' . $idx);

            $categoryNode->addChild(self::ID, $category[self::ID]);
            $categoryNode->addChild(self::NAME, htmlspecialchars($category[self::NAME]));

            if ($category[self::LEAF] === false) {
                $this->arrayToXml($categoryNode, $this->getCategories($category[self::ID]));
            }
        }
    }
}