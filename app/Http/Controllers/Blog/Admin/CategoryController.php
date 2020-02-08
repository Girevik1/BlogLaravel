<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $pagination = BlogCategory::paginate(5);

        return view('blog.admin.categories.index', compact('pagination'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        //dd(__METHOD__);
        $item = new BlogCategory();
        $categoryList = BlogCategory::all();

        return \view('blog.admin.categories.edit',
            compact('item', 'categoryList'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return RedirectResponse
     */
    public function store(BlogCategoryCreateRequest $request)
    {
        $data = $request->input();
        if (empty($data['slug'])) {
            $data['slug'] = str_slug($data['title']);
        }
        // создаст объект, но не добавит в БД
//        $item = new BlogCategory($data);
//        $item->save();

        // создаст объект и добавит в БД
        $item = (new BlogCategory())->create($data);

        if($item) {
            return redirect()->route('blog.admin.categories.edit', [$item->id])
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Factory|View
     */
    public function edit($id)
    {
        $item = BlogCategory::FindOrFail($id);
        $categoryList = BlogCategory::all();

        return view('blog.admin.categories.edit',
            compact('item', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BlogCategoryUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(BlogCategoryUpdateRequest $request, $id)
    {
        /* $rules = [
             'title'       => 'required|min:5|max:200',
             'slug'        => 'max:200',
             'description' => 'string|max:500|min:3',
             'parent_id'   => 'required|integer|exists:blog_categories,id',
         ]; */

        // 1й способ валидации
        //$validatedData = $this->validate($request, $rules);

        // 2й способ валидации
        //$validatedData = $request->validate($rules);

        // 3й способ валидации
        /* $validator = \Validator::make($request->all(), $rules);
         $validatedData[] = $validator->passes();
         //$validatedData[] = $validator->validate();
         $validatedData[] = $validator->valid();
         $validatedData[] = $validator->failed();
         $validatedData[] = $validator->errors();
         $validatedData[] = $validator->fails(); */

        $item = BlogCategory::find($id);
        if (empty($item)) {
            return back()
                ->withErrors(['msg' => "Запись id=[{$id}] не найдена"])
                ->withInput();
        }

        $data = $request->all();

        if (empty($data['slug'])) {
            $data['slug'] = str_slug($data['title']);
        }
          // Сохранение для изучения, что можно было так
//        $result = $item
//            ->fill($data)
//            ->save();

        $result = $item->update($data);

        if ($result) {
            return redirect()
                ->route('blog.admin.categories.edit', $item->id)
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }
}
