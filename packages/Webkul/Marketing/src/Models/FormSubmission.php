<?php

namespace Webkul\Marketing\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Marketing\Contracts\FormSubmission as FormSubmissionContract;

class FormSubmission extends Model implements FormSubmissionContract
{
    protected $fillable = [
        'type',
        'name',
        'email',
        'phone',
        'subject',
        'message',
    ];
}
