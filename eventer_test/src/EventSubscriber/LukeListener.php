<?php

namespace Drupal\eventer_test\EventSubscriber;

use Drupal\eventer\EventListener;
use Drupal\eventer_test\Events\DeathStarWasDestroyed;

/**
 * Class LukeListener.
 */
class LukeListener extends EventListener {

  /**
   * Event handler.
   *
   * @param \Drupal\eventer_test\Events\DeathStarWasDestroyed $event
   *   Event.
   */
  public function whenDeathStarWasDestroyed(DeathStarWasDestroyed $event) {
    $event->lukeIsHappy = TRUE;
  }

}
