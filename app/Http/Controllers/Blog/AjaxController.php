<?php

namespace App\Http\Controllers\Blog;

use App\Models\Grocery;
use Illuminate\Http\Request;

class AjaxController extends BaseController
{

    public function sendmail(Request $request)
    {

        if ($request->post()) {
            $grocery = new Grocery();
            $grocery->name = $request->name;
            $grocery->type = $request->type;
            $grocery->price = $request->price;

            $grocery->save();
            return response()->json(['success'=>'Data is successfully added']);
        }

        return view('blog.ajax.index');
    }


}
