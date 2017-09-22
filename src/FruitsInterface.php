<?php

namespace Drupal\fruits;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a Fruit entity.
 * @ingroup fruits
 */
interface FruitsInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}

?>