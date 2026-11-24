<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable = [
        'company_name',
        'contact_name',
        'email',
        'phone',
        'origin_country',
        'destination_port',
        'service_type',
        'cargo_details',
        'status',
        'admin_notes',
    ];
}
