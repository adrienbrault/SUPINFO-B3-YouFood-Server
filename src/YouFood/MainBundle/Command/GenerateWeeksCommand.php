<?php

namespace YouFood\MainBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use YouFood\MainBundle\Entity\Week;

/**
 * GenerateWeeksCommand
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 */
class GenerateWeeksCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('youfood:generate:weeks')
            ->setDescription('Create weeks. Be carefull, weeks table should be empty!!!')
            ->addOption('from', null, InputOption::VALUE_OPTIONAL, '', 2012)
            ->addOption('to', null, InputOption::VALUE_OPTIONAL, '', 2030)
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fromValue = $input->getOption('from') * 52;
        $toValue = $input->getOption('to') * 52;

        $em = $this->getContainer()->get('doctrine')->getEntityManager(); /** @var $em \Doctrine\ORM\EntityManager */

        for ($currentValue = $fromValue; $currentValue < $toValue; $currentValue++) {
            $year = floor($currentValue / 52);
            $weekNumber = $currentValue % 52 + 1; // Weeks are in [1, 52]

            $week = $this->createWeek($year, $weekNumber);
            $em->persist($week);
        }

        $em->flush();
    }

    /**
     * @param int $year       The year
     * @param int $weekNumber The week number
     *
     * @return Week
     */
    protected function createWeek($year, $weekNumber)
    {
        $week = new Week();

        $week->setYear($year);
        $week->setWeekNumber($weekNumber);

        return $week;
    }
}
