<?php

namespace app\behaviors;

use yii\base\Behavior;

class TimeBehavior extends Behavior
{
    /**
     * @param int $time
     *
     * @return string
     */
    public function getTimeDiff(int $time): string
    {
        if ($time >= 60) {
            if ($time >= 1440) {
                $days = round($time / 1440);
                return "$days days ago";
            } else {
                $hours = round($time / 60);
                $minutes = $time - $hours * 60;

                return $hours . "hr " . $minutes . "min ago";
            }
        }

        return "$time min ago";
    }
}
