<?php

namespace Drupal\Tests\eventer\Unit;

use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\eventer\Service\EventDispatcher;
use Drupal\eventer_test\Events\DeathStarWasDestroyed;
use Drupal\Tests\UnitTestCase;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class EventDispatcherTest.
 *
 * @package Drupal\Tests\eventer\Unit
 */
class EventDispatcherTest extends UnitTestCase {

  /**
   * Mock for EventDispatcherInterface.
   *
   * @var \PHPUnit_Framework_MockObject_MockObject
   *
   * @see \Symfony\Component\EventDispatcher\EventDispatcherInterface
   */
  protected $systemDispatcher;

  /**
   * Mock for LoggerChannelFactoryInterface.
   *
   * @var \PHPUnit_Framework_MockObject_MockObject
   *
   * @see \Drupal\Core\Logger\LoggerChannelFactoryInterface
   */
  protected $logger;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    $this->systemDispatcher = $this->getMock(EventDispatcherInterface::class);

    $logChannel = $this->getMock(LoggerChannelInterface::class);
    $logChannel->expects($this->once())->method('notice');

    $logger = $this->getMock(LoggerChannelFactoryInterface::class);
    $logger->expects($this->once())->method('get')->willReturn($logChannel);

    $this->logger = $logger;
  }

  /**
   * Ensures that the event is dispatched with an expected name.
   */
  public function testEventIsDispatchedWithCorrectName() {
    $event = new DeathStarWasDestroyed();
    $this->setExpectedEvent('test_event_occurred', $event);

    $dispatcher = new EventDispatcher($this->systemDispatcher, $this->logger);
    $dispatcher->dispatch($event);

    $this->verifyMockObjects();
  }

  /**
   * Sets an event name expectation on the event dispatcher.
   *
   * @param string $name
   *   Event name.
   * @param \Symfony\Component\EventDispatcher\Event $event
   *   Event object.
   */
  protected function setExpectedEvent($name, Event $event) {
    $this->systemDispatcher->expects($this->once())->method('dispatch')->with($name, $event);
  }

}
