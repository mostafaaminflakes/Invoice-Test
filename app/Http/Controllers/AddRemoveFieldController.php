<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrEditInvoiceRequest;
use Illuminate\Http\Request;
use App\Todo;
use Illuminate\Support\Facades\Validator;

class AddRemoveFieldController extends Controller
{
    public function index()
    {
        return view("add-remove-input-fields");
    }
    public function store(CreateOrEditInvoiceRequest $request)
    {
        return response()->json($request->all());
        $data = [];

        foreach ($request->input('title') as $key => $value) {
            $data["title.{$key}"] = 'required';
        }

        $validator = Validator::make($request->all(), $data);

        if ($validator->passes()) {

            foreach ($request->input('title') as $key => $value) {
                Todo::create(['title' => $value]);
            }

            return response()->json(['success' => 'true']);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }
}