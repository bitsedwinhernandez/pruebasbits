<?php

namespace Drupal\bits_pages\Controller;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Datetime\DateFormatter;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class SimpleController.
 */
class SimpleController extends ControllerBase {
  /**
   * Content.
   *
   * @return string
   *   Return Hello string.
   */
  public function content() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Página con mensaje simple')
    ];
  }

}
