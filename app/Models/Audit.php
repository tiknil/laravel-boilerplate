<?php

namespace App\Models;

use OwenIt\Auditing\Models\Audit as BaseAudit;

class Audit extends BaseAudit
{
    public function copeEvent($query, string $event)
    {
        return $query->where('event', $event);
    }
}
