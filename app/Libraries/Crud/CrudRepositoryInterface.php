<?php

namespace App\Libraries\Crud;

// Will implement later, using trait
interface CrudRepositoryInterface
{
    public function allowedRelations(CrudModel $entity);
}
