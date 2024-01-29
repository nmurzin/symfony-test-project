<?php

namespace App\EventSubscriber;

use App\Event\GamePlayedEvent;
use App\Game\Game as GameService;
use App\Game\GameType\GameTypeFactory;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class GamePlayedSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly GameTypeFactory $gameTypeFactory
    )
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            GamePlayedEvent::class => 'onGamePlayed',
        ];
    }

    public function onGamePlayed(GamePlayedEvent $event): void
    {
        $gameType = $this->gameTypeFactory->getGameType($event->getGame()->getRound());
        $gameType->handle($event->getGame());
    }
}
