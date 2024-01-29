<?php

namespace App\EventSubscriber;

use App\Event\GamePlayedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class GamePlayedSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            GamePlayedEvent::class => 'onGamePlayed',
        ];
    }

    public function onGamePlayed(GamePlayedEvent $event): void
    {
        dd($event->getGame());
    }
}
