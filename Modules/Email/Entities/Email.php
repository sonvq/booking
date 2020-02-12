<?php

namespace Modules\Email\Entities;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{

    protected $table = 'email__emails';
    protected $fillable = [
        'type',
        'subject',
        'content',
        'status'
    ];

    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISH = 'publish';

    const TYPE_BOOKING = 'booking';
}
