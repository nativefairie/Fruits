<?php
/**
 * @file
 * Contains \Drupal\fruits\FruitsAccessControlHandler.
 */
namespace Drupal\fruits;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * @see \Drupal\comment\Entity\Comment.
 */
class FruitsAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */

  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'View fruit');

      case 'edit':
        return AccessResult::allowedIfHasPermission($account, 'Edit fruit');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'Delete Fruit');
    }
    return AccessResult::allowed();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'Add fruit');
  }

}
?>