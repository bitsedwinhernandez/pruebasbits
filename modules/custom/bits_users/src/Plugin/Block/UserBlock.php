<?php

namespace Drupal\bits_users\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Session\AccountProxyInterface;

/**
 * Provides a 'UserBlock' block.
 *
 * @Block(
 *  id = "user_block",
 *  admin_label = @Translation("usuario actual"),
 * )
 */
class UserBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\Core\Session\AccountProxyInterface definition.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;
  /**
   * Constructs a new UserBlock object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    AccountProxyInterface $current_user
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->currentUser = $current_user;
  }
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user')
    );
  }
  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $html = 'Su id: ' . $this->currentUser->id() . '</br>';
    $html.= 'Su Display name' . $this->currentUser->getUsername() . '</br>';
    $html.= 'Su Email' . $this->currentUser->getEmail() . '</br>';
    $build['user_block']['#markup'] = $html;

    return $build;
  }


  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    if (in_array('gestor', $account->getRoles())) {
      return AccessResult::allowed();
    }
    return AccessResult::forbidden();
  }
}
