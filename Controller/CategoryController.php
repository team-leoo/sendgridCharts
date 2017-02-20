<?php
/** Namespace */
namespace LeooTeam\SendgridChartsBundle\Controller;

/** Usages */
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CategoryController
 * @package LeooTeam\SendgridChartsBundle\Controller
 */
class CategoryController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        return $this->render('LeooTeamSendgridChartsBundle:Category:list.html.twig', [
            'categories' => $this->container
                ->get('leoo_team_sendgrid_charts.manager.category')
                ->getList([
                    'category'  => $request->get('category') ?: null,
                    'limit'     => $request->get('limit')    ?: 50,
                    'offset'    => $request->get('offset')   ?: 0,
                ]),
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function statsAction(Request $request)
    {
        $startDate = $request->get('startDate');
        if (null == $startDate) {
            $startDate = date('Y-m-d', strtotime('first day of this month'));
        }

        $endDate = $request->get('endDate');
        if (null == $endDate) {
            $endDate = date('Y-m-d');
        }

        /** @var string $aggregatedBy */
        $aggregatedBy = $request->get('aggregatedBy');
        if (null == $aggregatedBy) {
            $aggregatedBy = 'month';
        }

        if (!in_array($aggregatedBy, ['day', 'week', 'month'])) {
            throw new \InvalidArgumentException('$aggregatedBy must be one of the following:'
                .' `day`, `week`, or `month`.');
        }

        return $this->render('LeooTeamSendgridChartsBundle:Category:stats.html.twig', [
            'stats' => $this->container
                ->get('leoo_team_sendgrid_charts.manager.category')
                ->getStats([
                    'start_date'    => $startDate,
                    'end_date'      => $endDate,
                    'categories'    => $request->get('categories') ?: null,
                    'limit'         => $request->get('limit')      ?: 500,
                    'offset'        => $request->get('offset')     ?: 0,
                    'aggregated_by' => $aggregatedBy,
                ]),
        ]);
    }

}
