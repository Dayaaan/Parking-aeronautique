<?php 
namespace App\Service;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Error\Base;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManagerInterface;

class StripeClient
{
  private $config;
  private $em;
  private $logger;
  
  public function __construct($secretKey, array $config, EntityManagerInterface $em, LoggerInterface $logger)
  {
    \Stripe\Stripe::setApiKey($secretKey);
    $this->config = $config;
    $this->em = $em;
    $this->logger = $logger;
  }
  public function createPremiumCharge(Commande $commande, $token)
  {
    try {
      $charge = \Stripe\Charge::create([
        'amount' => $this->config['decimal'] ? $commande->getTotalAmount() * 100 : $commande->getTotalAmount(),
        'currency' => $this->config['currency'],
        'description' => 'Shoppers',
        'source' => $token,
        'receipt_email' => $commande->getEmail(),
      ]);
    } catch (\Stripe\Error\Base $e) {
      $this->logger->error(sprintf('%s exception encountered when creating a premium payment: "%s"', get_class($e), $e->getMessage()), ['exception' => $e]);
      throw $e;
    }
    $commande->setChargeId($charge->id);
    $commande->setPaiementStatus($charge->paid);
    dump($charge);
    //$user->setPremium($charge->paid);
    $this->em->flush();
  }
}