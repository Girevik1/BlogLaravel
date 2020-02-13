<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Blog\BaseController as GuestBaseController;

/**
 * Базовый контроллер для всех контроллеров управления
 * блогом в панели администрирования.
 *
 * Должен быть родителем всех контроллеров управления блогом
 *
 * @package App\Http\Controllers\Blog\Admin
 */
abstract class AdminBaseController extends GuestBaseController
{
    /**
     * BaseController constructor.
     */
    public function __conctruct()
    {
        // Для иницифдизции общих моментов для админки
    }
}
