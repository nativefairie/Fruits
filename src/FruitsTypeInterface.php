<?php

namespace Drupal\fruits;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface defining a fruits type entity.
 */
interface FruitsTypeInterface extends ConfigEntityInterface {

  /**
   * Determines whether the fruits type is locked.
   *
   * @return string|false
   *   The module name that locks the type or FALSE.
   */
  public function isLocked();

  /**
   * Gets whether 'Submitted by' information should be shown.
   *
   * @return bool
   *   TRUE if the submitted by information should be shown.
   */
  public function displaySubmitted();

  /**
   * Sets whether 'Submitted by' information should be shown.
   *
   * @param bool $display_submitted
   *   TRUE if the submitted by information should be shown.
   */
  public function setDisplaySubmitted($display_submitted);

  /**
   * Gets the description.
   *
   * @return string
   *   The description of this fruits type.
   */
  public function getDescription();
}