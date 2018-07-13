<?php

namespace Drupal\bits_entities\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Message entity type entity.
 *
 * @ConfigEntityType(
 *   id = "bits_entities_message_type",
 *   label = @Translation("Message entity type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\bits_entities\MessageEntityTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\bits_entities\Form\MessageEntityTypeForm",
 *       "edit" = "Drupal\bits_entities\Form\MessageEntityTypeForm",
 *       "delete" = "Drupal\bits_entities\Form\MessageEntityTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\bits_entities\MessageEntityTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "bits_entities_message_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "bits_entities_message",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/bits_entities_message_type/{bits_entities_message_type}",
 *     "add-form" = "/admin/structure/bits_entities_message_type/add",
 *     "edit-form" = "/admin/structure/bits_entities_message_type/{bits_entities_message_type}/edit",
 *     "delete-form" = "/admin/structure/bits_entities_message_type/{bits_entities_message_type}/delete",
 *     "collection" = "/admin/structure/bits_entities_message_type"
 *   }
 * )
 */
class MessageEntityType extends ConfigEntityBundleBase implements MessageEntityTypeInterface {

  /**
   * The Message entity type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Message entity type label.
   *
   * @var string
   */
  protected $label;

}
