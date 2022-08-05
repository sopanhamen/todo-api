<?php

namespace App\Modules\Card;

use App\Libraries\Crud\CrudRepository;
use App\Modules\Card\Card;

class CardRepository extends CrudRepository
{
    public function __construct(Card $card)
    {
        parent::__construct($card);
    }
}
