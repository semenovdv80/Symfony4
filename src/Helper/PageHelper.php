<?php

namespace App\Helper;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\Templating\Helper\Helper;

class PageHelper extends Helper
{
    protected static $locale;

    public function getName()
    {
        return 'paginator';
    }

    /**
     * Paginate queries
     *
     * @param $query
     * @param $request
     * @param int $limit
     * @return Paginator
     */
    public static function paginate($query, $request, $limit = 25)
    {
        $paginator = new Paginator($query);
        $page = $request->get('page') ?? 1;

        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1)) // Offset
            ->setMaxResults($limit); // Limit

        $paginator->page = $page; //current page
        $paginator->maxPages = ceil($paginator->count() / $limit); //count of pages
        $paginator->onpage = $paginator->getIterator()->count(); //rows on page

        return $paginator;
    }
}