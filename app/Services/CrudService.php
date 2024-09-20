<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Pagination\LengthAwarePaginator;

interface CrudService
{
    const PER_PAGE = 20;

    public function search(FormRequest $request): LengthAwarePaginator;

    public function store(FormRequest $request): ?Model;
}
