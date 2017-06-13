<?php

namespace Drupal\Tests\eventer\Kernel;

use Drupal\eventer_test\Events\DeathStarWasDestroyed;
use Drupal\KernelTests\KernelTestBase;

/**
 * Class EventerTest.
 *
 * @package Drupal\Tests\eventer\Kernel
 */
class EventerTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = [
    'system',
    'eventer',
    'eventer_test',
  ];

  /**
   * Tests that custom events are handled by custom event listeners.
   */
  public function testEventListenerReactsToEvent() {
    $event = new DeathStarWasDestroyed();

    /** @var \Drupal\eventer\Service\EventDispatcher $dispatcher */
    $dispatcher = \Drupal::service('eventer.event_dispatcher');
    $dispatcher->dispatch($event);

    $this->assertSame(FALSE, $event->darthVaderIsHappy);
    $this->assertSame(TRUE, $event->lukeIsHappy);
  }

}
