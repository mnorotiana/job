<?php

namespace RecruitmentBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use RecruitmentBundle\Entity\Offre;

class CloseOfferCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('close-offer')
            ->setDescription('Cloture les offres datées')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $_date = date('Y-m-d');
        $offres = $em->getRepository('RecruitmentBundle:Offre')->getClosed($_date);
        foreach ($offres as $key => $o) {
            $o->setStatut('closed');
            $em->persist($o);
            $em->flush();
            // envoie mail au recruteur pour leur notifier l'expiration de l'offre

        }

        $output->writeln('Command result.');
    }

}
?>