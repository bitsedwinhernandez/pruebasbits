<?php

namespace Drupal\bits_pages\Controller;
use Drupal\menu_link_content\Entity\MenuLinkContent;
use Drupal\Core\Controller\ControllerBase;

/**
 * Class LinksController.
 */
class LinksController extends ControllerBase {

  /**
   * Content.
   *
   * @return string
   *   Return Hello string.
   */
  public function content() {

    return [
      '#type' => 'markup',
      '#markup' =>$menu_bits
    ];
  }

}
