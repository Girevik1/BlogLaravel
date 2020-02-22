<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Управления категориями блога
 *
 * @package App\Http\controllers\Blog\Admin
 */
class CategoryController extends  AdminBaseController
{
    /**
     * @var BlogCategoryRepository
     */
    private $blogCategoryRepository;

    public function __construct()
    {
        parent::__conctruct();

        $this->blogCategoryRepository = app(BlogCategoryRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$pagination = BlogCategory::paginate(15);
        $pagination = $this->blogCategoryRepository->getAllWithPaginate(25);

        return view('blog.admin.categories.index', compact('pagination'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $item = new BlogCategory();

        //$categoryList = BlogCategory::all();
        $categoryList = $this->blogCategoryRepository->getForComboBox();


        return view('blog.admin.categories.edit',
            compact('item', 'categoryList'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function store(BlogCategoryCreateRequest $request)
    {
        $data = $request->input();
        /*
         * //Ушло в обсервер
        if (empty($data['slug'])) {
            $data['slug'] = str_slug($data['title']);
        }*/

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

        $data = $request->all();
        $result = $item->update($data);

        if($result) {
            return redirect();
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
//        $item = BlogCategory::FindOrFail($id);
//        $categoryList = BlogCategory::all();


        $item =$this->blogCategoryRepository->getEdit($id);
        if (empty($item)) {
            abort(404);
        }

        $categoryList = $this->blogCategoryRepository->getForComboBox();

        return view('blog.admin.categories.edit',
            compact('item', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BlogCategoryUpdateRequest $request
     * @param int $id
     *
     * @return Response
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

        //$item = BlogCategory::find($id);
        $item = $this->blogCategoryRepository->getEdit($id);
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
