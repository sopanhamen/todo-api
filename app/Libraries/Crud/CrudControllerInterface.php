<?php

namespace App\Libraries\Crud;

use App\Http\Requests\FormRequest;
use Illuminate\Http\Request;

interface CrudControllerInterface
{
    public function index(Request $request);
    public function show($id);
    public function store(object $request);
    public function update(object $request, $id);
    public function delete($id);
    public function forceDelete($id);
}
