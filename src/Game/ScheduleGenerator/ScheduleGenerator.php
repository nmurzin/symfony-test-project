<?php

namespace App\Game\ScheduleGenerator;

use Doctrine\Common\Collections\Collection;

interface ScheduleGenerator
{
    public function generate(Collection $divisions): void;
}
