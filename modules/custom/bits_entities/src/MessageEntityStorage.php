<?php

namespace Drupal\bits_entities;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
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
class MessageEntityStorage extends SqlContentEntityStorage implements MessageEntityStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(MessageEntityInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {bits_entities_message_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {bits_entities_message_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(MessageEntityInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {bits_entities_message_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('bits_entities_message_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
