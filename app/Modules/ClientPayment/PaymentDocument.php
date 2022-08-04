<?php

namespace App\Modules\ClientPayment;

use Illuminate\Database\Eloquent\Model;
use App\Libraries\Database\Traits\UuidPrimaryKey;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentDocument extends Model
{
    use UuidPrimaryKey;

    public $fillable = ['client_payment_id', 'file_path', 'file_type', 'file_name', 'storage_disk'];

    public function clientPayment(): BelongsTo
    {
        return $this->belongsTo(ClientPayment::class, 'client_payment_id');
    }
}
