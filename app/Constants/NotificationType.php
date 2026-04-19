<?php

namespace App\Constants;

class NotificationType
{
    const GENERAL = 'general';
    const NEW_REQUEST = 'new_request';
    const REQUEST_ACCEPTED = 'request_accepted';
    const REQUEST_COMPLETED = 'request_completed';
    const REQUEST_REJECTED = 'request_rejected';
    const NEW_BOND = 'new_bond';
    const BOND_STATUS_UPDATED = 'bond_status_updated';
    const POINTS_RECEIVED = 'points_received';
    const ADMIN_MSG = 'admin_message';
    const COMPLAINT_UPDATE = 'complaint_update';
}
