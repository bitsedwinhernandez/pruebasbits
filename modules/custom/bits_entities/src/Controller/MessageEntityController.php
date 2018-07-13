<?php

namespace Drupal\bits_entities\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\bits_entities\Entity\MessageEntityInterface;

/**
 * Class MessageEntityController.
 *
 *  Returns responses for Message entity routes.
 */
class MessageEntityController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Message entity  revision.
   *
   * @param int $bits_entities_message_revision
   *   The Message entity  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($bits_entities_message_revision) {
    $bits_entities_message = $this->entityManager()->getStorage('bits_entities_message')->loadRevision($bits_entities_message_revision);
    $view_builder = $this->entityManager()->getViewBuilder('bits_entities_message');

    return $view_builder->view($bits_entities_message);
  }

  /**
   * Page title callback for a Message entity  revision.
   *
   * @param int $bits_entities_message_revision
   *   The Message entity  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($bits_entities_message_revision) {
    $bits_entities_message = $this->entityManager()->getStorage('bits_entities_message')->loadRevision($bits_entities_message_revision);
    return $this->t('Revision of %title from %date', ['%title' => $bits_entities_message->label(), '%date' => format_date($bits_entities_message->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Message entity .
   *
   * @param \Drupal\bits_entities\Entity\MessageEntityInterface $bits_entities_message
   *   A Message entity  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(MessageEntityInterface $bits_entities_message) {
    $account = $this->currentUser();
    $langcode = $bits_entities_message->language()->getId();
    $langname = $bits_entities_message->language()->getName();
    $languages = $bits_entities_message->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $bits_entities_message_storage = $this->entityManager()->getStorage('bits_entities_message');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $bits_entities_message->label()]) : $this->t('Revisions for %title', ['%title' => $bits_entities_message->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all message entity revisions") || $account->hasPermission('administer message entity entities')));
    $delete_permission = (($account->hasPermission("delete all message entity revisions") || $account->hasPermission('administer message entity entities')));

    $rows = [];

    $vids = $bits_entities_message_storage->revisionIds($bits_entities_message);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\bits_entities\MessageEntityInterface $revision */
      $revision = $bits_entities_message_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $bits_entities_message->getRevisionId()) {
          $link = $this->l($date, new Url('entity.bits_entities_message.revision', ['bits_entities_message' => $bits_entities_message->id(), 'bits_entities_message_revision' => $vid]));
        }
        else {
          $link = $bits_entities_message->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.bits_entities_message.translation_revert', ['bits_entities_message' => $bits_entities_message->id(), 'bits_entities_message_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.bits_entities_message.revision_revert', ['bits_entities_message' => $bits_entities_message->id(), 'bits_entities_message_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.bits_entities_message.revision_delete', ['bits_entities_message' => $bits_entities_message->id(), 'bits_entities_message_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['bits_entities_message_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
