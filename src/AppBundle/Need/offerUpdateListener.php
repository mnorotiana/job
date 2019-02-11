<?php
namespace AppBundle\Need;

class offerUpdateListener
{
  protected $offerUpd;

  public function __construct(offerUpdate $offerUpd)
  {
    $this->offerUpd = $offerUpd;
  }

  public function processMessage(MessagePostEvent $event)
  {   
    $this->offerUpd->notifyOffreEmail($event->getOffre());
  }
}