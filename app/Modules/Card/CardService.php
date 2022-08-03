<?php

namespace App\Modules\Card;

use App\Libraries\Crud\CrudService;

class CardService extends CrudService
{
    protected array $allowedRelations = [];

    public function __construct(CardRepository $repo)
    {
        parent::__construct($repo);
    }
}
