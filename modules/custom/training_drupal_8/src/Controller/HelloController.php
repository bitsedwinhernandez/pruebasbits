<?php

namespace Drupal\training_drupal_8\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class HelloController.
 */
class HelloController extends ControllerBase {

  /**
   * Hello.
   *
   * @return string
   *   Return Hello string.
   */
  public function hello() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Hello bro')
    ];
  }

}
