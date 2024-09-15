<?php

namespace app\traits;

trait StationConditionsTrait
{
    private array $surface = [
        'No' => ['not in', 'type', ['Planetary Port', 'Planetary Outpost', 'Odyssey Settlement']],
        'Yes' => ['!=', 'type', 'Odyssey Settlement'],
        'Odyssey' => ['!=', 'type', '']
    ];

    private function padCondition(string $pad): string
    {
        return $pad === 'L' ? "<>Outpost" : '';
    }

    private function surfaceCondition(string $incl)
    {
        return $this->surface[$incl];
    }
}
