<?php

namespace App\Repositories;

use App\Models\BlogPost as Model;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\User;

class BlogPostRepository extends CoreRepository
{
    /**
     * @return string
     */
    public function getModelClass()
    {
        return Model::class;
    }

    /**
     * Получить список статей  для вывода в списке
     * (админка)
     *
     * @return LengthAwarePaginator
     */
    public function getAllWithPaginate()
    {
        $columns = [
            'id',
            'title',
            'slug',
            'is_published',
            'published_at',
            'user_id',
            'category_id',
        ];

        $result = $this->startConditions()
            ->select($columns)
            ->orderBy('id','DESC')
            //->with(['category', 'user'])
                ->with([
                    // можно так
                    'category' => function ($query) {
                    $query->select(['id', 'title']);
                    },
                // или так
                'user:id,name',
            ])
            ->paginate(25);

        return $result;
    }

}

