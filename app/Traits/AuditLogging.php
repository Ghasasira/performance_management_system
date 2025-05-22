<?php

namespace App\Traits;

use App\Models\Action;

trait AuditLogging
{
    public function logTaskAction($type, $description = null, $metadata = null)
    {
        Action::log($type, $this, $description, $metadata);
    }
}
