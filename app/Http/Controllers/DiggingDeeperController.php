<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DiggingDeeperController extends Controller
{
    public function collection()
    {
        $eloquentCollection = BlogPost::withTrashed()->get();

//        dd(__METHOD__,$eloquentCollection,$eloquentCollection->toArray());
        /**
         * @var Collection $collection
         */
        $collection = collect($eloquentCollection->toArray());

//        dd(
//            get_class($eloquentCollection),
//            get_class($collection),
//            $collection
//        );

//        $result['first'] = $collection->first();
//        $result['last'] = $collection->last();

        $result['where']['data'] = $collection
            ->where('category_id', 10)
            ->values()
            ->keyBy('id');

//        $result['where']['count'] = $result['where']['data']->count();
//        $result['where']['isEmpty'] = $result['where']['data']->isEmpty();
//        $result['where']['isNotEmpty'] = $result['where']['data']->isNotEmpty();

//        dd($result);
////        // Не очень красиво
////        if ($result['where']['count']) {
////            //....
////        }
////        // Так лучше
////        if ($result['where']['data']->isNotEmpty()) {
////            //....
////        }
///
//        $result['where_first'] = $collection
//            ->firstWhere('created_at','>','2019-01-17 01:35:11');

        // Базовая переменная не изменится. Просто вернутся измененная версия.
//        $result['map']['all'] = $collection->map(function (array $item) {
//            $newItem = new \stdClass();
//            $newItem->item_id = $item['id'];
//            $newItem->item_name = $item['title'];
//            $newItem->exists = is_null($item['deleted_at']);
//
//            return $newItem;
//        });
//        // получить удаленные записи
//        $result['map']['not_exists'] = $result['map']['all']
//            ->where('exists', '=', false)
//            ->values() //обнулить ключи
//            ->keyBy('id'); //сделать ключем номер id записи

        // проходить по коллекции и делает мутацию - изменение как нам надо
        $collection->transform(function (array $item) {
            $newItem = new \stdClass();
            $newItem->item_id = $item['id'];
            $newItem->item_name = $item['title'];
            $newItem->exists = is_null($item['deleted_at']);
            $newItem->created_at = Carbon::parse($item['created_at']);
            return $newItem;
        });
//        dd($collection);
//        $newItem = new \stdClass();
//        $newItem->id = 9999;
//
//        $newItem2 = new \stdClass();
//        $newItem2->id = 8888;
//        dd($newItem, $newItem2)

        // Установить элемент в начало коллекции
//        $newItemFirst = $collection->prepend($newItem)->first();//в самое начало
//        $newItemLast = $collection->push($newItem2)->last(); //в самый конец
//        $pulledItem = $collection->pull(1); // забрать id 1 элемент
//
//        dd(compact('collection', 'newItemFirst', 'newItemLast', 'pulledItem'));

        // Фильтрация. Замена orWhere
//        $filtered = $collection->filter(function ($item) {
//            $byDay = $item->created_at->isFriday();
//            $byDate = $item->created_at->day == 29;
//
//           // $result = $item->created_at->isFriday() && $item->created_at->day == 13;
//
//            $result = $byDay && $byDate;
//            return $result;
//        });
//        dd(compact('byDay','collection','filtered', 'result'));

        $sortedSimpleCollection = collect([5,3,1,2,4])->sort()->values();
        $sortedAscCollection = $collection->sortBy('created_at');
        $sortedDescCollection = $collection->sortByDesc('item_id');

        dd(compact('sortedSimpleCollection','sortedAscCollection','sortedDescCollection'));
    }

}
