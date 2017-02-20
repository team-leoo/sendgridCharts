<?php

/** Namespace */
namespace LeooTeam\SendgridChartsBundle\Manager;

/** Usages */
use LeooTeam\SendgridChartsBundle\Services\SendgridApi;

/**
 * Class CategoryManager
 * @package LeooTeam\SendgridChartsBundle\Manager
 */
class CategoryManager
{
    const URI_LIST  = '/categories';
    const URI_STATS = '/categories/stats';

    /**
     * @var SendgridApi $sendgrid
     */
    private $sendgrid;

    public function __construct($sendgrid)
    {
        $this->sendgrid = $sendgrid;
    }

    /**
     * @param array $filters
     * @return string
     */
    public function getList(array $filters = [])
    {
        return $this->sendgrid->get(self::URI_LIST, $filters);
    }

    /**
     * @param array $filters
     * @return string
     */
    public function getStats(array $filters = [])
    {
        $statsByDate = $this->sendgrid->get(self::URI_STATS, $filters);
        $statsByCategory = [];

        foreach ($statsByDate as $statData) {
            foreach ($statData->stats as $statItem) {
                $statsByCategory[$statItem->name][$statData->date] = $statItem->metrics;
            }
        }

        return [
            'statsByDate'     => $statsByDate,
            'statsByCategory' => $statsByCategory,
        ];
    }
}
