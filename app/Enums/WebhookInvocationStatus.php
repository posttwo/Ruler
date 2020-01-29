<?php

namespace App\Enums;

final class WebhookInvocationStatus
{
    const UNKNOWN = 0;
    const ADDED = 201;
    const QUEUED = 202;
    const WORKING = 203;
    const COMPLETED = 200;

    const FAILED = 500;
}