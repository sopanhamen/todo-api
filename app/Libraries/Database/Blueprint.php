<?php

namespace App\Libraries\Database;

use Illuminate\Database\Schema\Blueprint as BaseBlueprint;

class Blueprint extends BaseBlueprint
{
    public function authors($createdBy = 'created_by', $updatedBy = 'updated_by')
    {
        parent::uuid($createdBy)->nullable()->comment('User who created the record');
        parent::uuid($updatedBy)->nullable()->comment('User who updated the record');

        parent::foreign($createdBy)->references('id')->on('users');
        parent::foreign($updatedBy)->references('id')->on('users');
    }

    public function dropAuthors($createdBy = 'created_by', $updatedBy = 'updated_by')
    {
        parent::dropColumn($createdBy);
        parent::dropColumn($updatedBy);
    }
}
