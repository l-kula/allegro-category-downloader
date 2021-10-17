<?php

declare(strict_types=1);

namespace Lkula\AllegroCategories\Category;

use Lkula\AllegroCategories\AllegroClient\AllegroClient;
use Psr\Http\Message\ResponseInterface;

/**
 * Class CategoryClient
 *
 * @package Lkula\AllegroCategories\Category
 */
class CategoryClient extends AllegroClient
{
    public function getCategories($parentId = null): ResponseInterface
    {
        return $this->get('/sale/categories', $parentId ? ['parent.id' => $parentId] : []);
    }
}