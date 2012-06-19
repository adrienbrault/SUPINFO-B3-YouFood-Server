<?php

namespace YouFood\MainBundle\Block;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

use Doctrine\ORM\EntityManager;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Admin\Pool;

use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BaseBlockService;

use SaadTazi\GChartBundle\DataTable;

use YouFood\MainBundle\Repository\OrderRepository;

class ChartsBlockService extends BaseBlockService
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct($name, EngineInterface $templating, EntityManager $em)
    {
        parent::__construct($name, $templating);

        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $form, BlockInterface $block)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockInterface $block, Response $response = null)
    {
        $orderRepository = $this->em->getRepository('YouFoodMainBundle:Order');

        $restaurants = $this->em->getRepository('YouFoodMainBundle:Restaurant')->findAll();

        $chart1Data = array_map(function ($restaurant) use ($orderRepository) {
            return array(
                'label' => sprintf('%s - %s', $restaurant->getCity(), $restaurant->getAddress()),
                'data' => array(
                    array(
                        0,
                        (int) $orderRepository->getPaidOrdersCountByRestaurantAndPeriod($restaurant) + 1,
                    ),
                ),
            );
        }, $restaurants);

        $categories = $this->em->getRepository('YouFoodMainBundle:Category')->findAll();

        $chart2Data = array_map(function ($category) use ($orderRepository) {
            return array(
                'label' => $category->getName(),
                'data' => array(
                    array(
                        0,
                        (int) $orderRepository->getPaidOrdersCountByCategoryAndPeriod($category) + 1,
                    ),
                ),
            );
        }, $categories);

        return $this->renderResponse('YouFoodMainBundle:Block:charts.html.twig', array(
            'chart1_data' => $chart1Data,
            'chart2_data' => $chart2Data,
        ), $response);
    }

    /**
     * {@inheritdoc}
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function getJavacripts($media)
    {
        return array('a');
    }
}
