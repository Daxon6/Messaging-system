<?php

namespace App\Models;

use Vista\Model\Model;

class Messages extends Model
{
    protected string $table = 'messages';
    protected array $columns = ['id', 'sender_id', 'recipient_id', 'title', 'body',
        'urgency', 'sent_at', 'is_read'];

}