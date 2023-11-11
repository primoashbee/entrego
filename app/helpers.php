<?php

use App\Models\AuditLog;

function auditLog($user_id, $event)
{
    return AuditLog::log($user_id, $event);
}