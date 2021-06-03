<?php


namespace App\Controller;


use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class AbstractController extends Controller
{
    const ITEMS_PER_PAGE = 10;

    public function paginate($query, $page, &$pages, $limit = self::ITEMS_PER_PAGE)
    {
        $offset = ($page - 1) * $limit;
        $paginator = new Paginator($query, false);

        $pages = intval(ceil( count($paginator) / $limit));
        $paginator->getQuery()
            ->setFirstResult($offset)
            ->setMaxResults($limit);
        return $paginator;
    }

}