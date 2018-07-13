<?php

namespace Drupal\bits_pages\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Datetime\DateFormatter;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * Class CalculatorController.
 */
class CalculatorController extends ControllerBase {
  /**
   * Drupal\Core\Session\AccountProxyInterface definition.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;
  /**
   * Drupal\Core\Datetime\DateFormatter implements
   *
   * @var \Drupal\Core\Datetime\DateFormatter
   */
  protected $dateFormatter;
  /**
   * Constructs a new CalculatorController object.
   */
  public function __construct(
    DateFormatter $dateFormatter,
    AccountProxyInterface $current_user
  ) {
    $this->dateFormatter = $dateFormatter;
    $this->currentUser = $current_user;
  }
  /**
   * Calculator.
   *
   * @return string
   *   Return Hello string.
   */
  public function calculator($parameter1, $parameter2) {

    if(is_numeric($parameter1) && is_numeric($parameter2)){
      $suma = $parameter1 + $parameter2;
      $resta = $parameter1 - $parameter2;
      $multiplicacion = $parameter1 * $parameter2;
      if($parameter2 !== "0" ){
        $division = $parameter1 / $parameter2;
        $residuo = $parameter1 % $parameter2;
      }else{
        $division = 0;
        $residuo= 0;
      }
      $html = 'Suma: La suma entre ' . $parameter1 . ' y ' . $parameter2 . ' es ' . $suma . '</br>';
      $html .= 'Resta: La resta entre ' . $parameter1 . ' y ' . $parameter2 . ' es ' . $resta . '</br>';
      $html .= 'Multiplicación: La multiplicación entre ' . $parameter1 . ' y ' . $parameter2 . ' es ' . $multiplicacion . '</br>';
      $html .= 'División: La división entre ' . $parameter1 . ' y ' . $parameter2 . ' es ' . $division . '</br>';
      $html .= 'Residuo: El residuo entre ' . $parameter1 . ' y ' . $parameter2 . ' es ' . $residuo . '</br>';
      return [
        '#type' => 'markup',
        '#markup' => $html
      ];
    }else{
      return [
        '#type' => 'markup',
        '#markup' => $this->t('Calculadora')
      ];
    }
  }

}
