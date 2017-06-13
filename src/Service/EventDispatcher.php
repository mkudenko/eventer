<?php

namespace Drupal\eventer\Service;

use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\eventer\Contracts\DispatcherInterface as DispatcherInterface;
use Stringy\Stringy as S;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class EventDispatcher.
 */
class EventDispatcher implements DispatcherInterface {

  /**
   * The dispatcher instance.
   *
   * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
   */
  protected $dispatcher;

  /**
   * The logger instance.
   *
   * @var \Drupal\Core\Logger\LoggerChannelInterface
   */
  protected $log;

  /**
   * Create a new EventDispatcher instance.
   *
   * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $dispatcher
   *   Event dispatcher.
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $loggerFactory
   *   Logger factory.
   */
  public function __construct(EventDispatcherInterface $dispatcher, LoggerChannelFactoryInterface $loggerFactory) {
    $this->dispatcher = $dispatcher;
    $this->log = $loggerFactory->get('eventer');
  }

  /**
   * Dispatch all raised events.
   *
   * @param \Symfony\Component\EventDispatcher\Event $event
   *   Event object.
   */
  public function dispatch(Event $event) {
    $eventName = $this->getEventName($event);

    $this->dispatcher->dispatch($eventName, $event);

    $this->log->notice("{$eventName} was fired.");
  }

  /**
   * Make the fired event name look more object-oriented.
   *
   * @param \Symfony\Component\EventDispatcher\Event $event
   *   Event object.
   *
   * @return string
   *   Event name.
   */
  protected function getEventName(Event $event) {
    $oClass = new \ReflectionClass($event);

    return S::create($oClass->getShortName())
      ->underscored()
      ->__toString();
  }

}
