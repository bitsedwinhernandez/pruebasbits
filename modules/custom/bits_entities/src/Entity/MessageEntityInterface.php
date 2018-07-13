<?php

namespace Drupal\bits_entities\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Message entity entities.
 *
 * @ingroup bits_entities
 */
interface MessageEntityInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Message entity name.
   *
   * @return string
   *   Name of the Message entity.
   */
  public function getName();

  /**
   * Sets the Message entity name.
   *
   * @param string $name
   *   The Message entity name.
   *
   * @return \Drupal\bits_entities\Entity\MessageEntityInterface
   *   The called Message entity entity.
   */
  public function setName($name);

  /**
   * Gets the Message entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Message entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Message entity creation timestamp.
   *
   * @param int $timestamp
   *   The Message entity creation timestamp.
   *
   * @return \Drupal\bits_entities\Entity\MessageEntityInterface
   *   The called Message entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Message entity published status indicator.
   *
   * Unpublished Message entity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Message entity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Message entity.
   *
   * @param bool $published
   *   TRUE to set this Message entity to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\bits_entities\Entity\MessageEntityInterface
   *   The called Message entity entity.
   */
  public function setPublished($published);

  /**
   * Gets the Message entity revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Message entity revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\bits_entities\Entity\MessageEntityInterface
   *   The called Message entity entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Message entity revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Message entity revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\bits_entities\Entity\MessageEntityInterface
   *   The called Message entity entity.
   */
  public function setRevisionUserId($uid);

}
