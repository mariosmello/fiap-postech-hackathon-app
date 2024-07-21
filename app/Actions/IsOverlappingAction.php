<?php

namespace App\Actions;

use App\Models\UserAvailability;

class IsOverlappingAction
{
    public function handler($userId, $date, $startTime, $endTime, $excludeId = null)
    {
        $query = UserAvailability::where('user_id', $userId)
            ->where('date', $date)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where('start_time', '<', $endTime)
                    ->where('end_time', '>', $startTime);
            });

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
