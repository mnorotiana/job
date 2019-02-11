<?php

namespace AppBundle\Need;

use RecruitmentBundle\Entity\Offre;

class offerUpdate
{
  protected $mailer;

  public function __construct(\Swift_Mailer $mailer)
  {
    $this->mailer = $mailer;
  }

  // Méthode pour notifier par e-mail un administrateur
  public function notifyOffreEmail(Offre $offre)
  {
    $message = \Swift_Message::newInstance()
      ->setSubject("Nouvelle offre pour vous")
      ->setFrom('admin@votresite.com')
      ->setTo('admin@votresite.com')
      ->setBody("L'utilisateur surveillé '".$user->getUsername()."' a posté le message suivant : '".$message."'");

    $this->mailer->send($message);
  }

  // Méthode pour notifier par e-mail un administrateur
  public function notifySuiviEmail(Offre $offre)
  {
    $message = \Swift_Message::newInstance()
      ->setSubject("Suivi de votre candidature")
      ->setFrom('admin@votresite.com')
      ->setTo('admin@votresite.com')
      ->setBody("L'utilisateur surveillé '".$user->getUsername()."' a posté le message suivant : '".$message."'");

    $this->mailer->send($message);
  }
}