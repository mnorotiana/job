<?php
// myapplication/src/sandboxBundle/Command/SocketCommand.php
// Change the namespace according to your bundle
namespace RecruitmentBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Ratchet\App;

// Include ratchet libs
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

// Change the namespace according to your bundle
use RecruitmentBundle\Sockets\Chat;

class recupOffersCommand extends ContainerAwareCommand 
{
    protected function configure()
    {
        $this->setName('recup-offers')           
            ->setHelp("Récupère toutes les offres validées")
            // the full command description shown when running the command with
            ->setDescription('Récupère toutes les offres validées')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Recupération des offres');
        $em = $this->getContainer()->get('doctrine')->getManager();
        $url = "http://0x5afe.me:1414/api/offers";
        $offres = $this->check($url);
    }
}