<?php

namespace Drupal\bits_entities;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\bits_entities\Entity\MessageEntityInterface;

/**
 * Defines the storage handler class for Message entity entities.
 *
 * This extends the base storage class, adding required special handling for
 * Message entity entities.
 *
 * @ingroup bits_entities
 */
interface MessageEntityStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Message entity revision IDs for a specific Message entity.
   *
   * @param \Drupal\bits_entities\Entity\MessageEntityInterface $entity
   *   The Message entity entity.
   *
   * @return int[]
   *   Message entity revision IDs (in ascending order).
   */
  public function revisionIds(MessageEntityInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Message entity author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Message entity revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\bits_entities\Entity\MessageEntityInterface $entity
   *   The Message entity entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(MessageEntityInterface $entity);

  /**
   * Unsets the language for all Message entity with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
