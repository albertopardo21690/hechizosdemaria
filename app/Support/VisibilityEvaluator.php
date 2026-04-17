<?php

namespace App\Support;

class VisibilityEvaluator
{
    public static function shouldShow(array $visibility): bool
    {
        if (empty($visibility)) {
            return true;
        }

        if (! empty($visibility['logged_in_only']) && ! auth()->check()) {
            return false;
        }
        if (! empty($visibility['guest_only']) && auth()->check()) {
            return false;
        }

        $days = $visibility['days'] ?? [];
        if (is_array($days) && count($days) > 0) {
            $today = (int) now()->dayOfWeekIso % 7;
            $allowed = array_map('intval', $days);
            if (! in_array($today, $allowed, true)) {
                return false;
            }
        }

        $from = $visibility['date_from'] ?? null;
        if ($from && now()->lt($from)) {
            return false;
        }

        $to = $visibility['date_to'] ?? null;
        if ($to && now()->gt($to.' 23:59:59')) {
            return false;
        }

        return true;
    }
}
