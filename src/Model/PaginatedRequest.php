<?php

namespace App\Model;
use Symfony\Component\HttpFoundation\Request;

/**
 * This is a class that will be passed to repositories that return paginated results
 */
class PaginatedRequest
{
    private $limit;
    private $page;

    private function __construct(int $limit = 10, int $page = 1)
    {
        $this->limit = $limit;
        $this->page = $page;
    }

    public static function parseRequest(Request $request)
    {
        $limit = 10;
        $page = 1;

        if ($request->query->has('limit')) {
            $limit = $request->query->get('limit');
        }

        if ($request->query->has('page')) {
            $page = $request->query->get('page');
        }

        return self::newInstance($limit, $page);
    }

    public static function newInstance(int $limit, int $page)
    {
        return new PaginatedRequest($limit, $page);
    }

    /**
     * Get limit
     *
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * Get a page we're currently in
     *
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * Get actual offset that is passed to the database
     *
     * @return int
     */
    public function getOffset(): int
    {
        return ($this->page - 1) * $this->limit;
    }
}