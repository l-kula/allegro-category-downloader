<?php

declare(strict_types=1);

namespace Lkula\AllegroCategories\Category;

use Lkula\AllegroCategories\AllegroClient\AllegroClient;
use Psr\Http\Message\ResponseInterface;

/**
 * Class CategoryChangesClient
 *
 * @package Lkula\AllegroCategories\Category
 */
class CategoryChangesClient extends AllegroClient
{
    public function getChanges($id = null): ResponseInterface
    {
        return $this->get('/sale/category-events', $id ? ['from' => $id] : []);
    }
}