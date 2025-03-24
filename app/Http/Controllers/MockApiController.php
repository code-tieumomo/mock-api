<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MockApiController extends Controller
{
    public function create()
    {
        return view('mock-apis.create');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'resource_prefix' => 'required|string|regex:/^\/[a-zA-Z0-9\/]*$/',
            'description' => 'nullable|string',
        ]);

        $name = $request->name;
        $resourcePrefix = $request->resource_prefix;
        $description = $request->description;

        return view('mock-apis.generate', compact([
            'name',
            'resourcePrefix',
            'description',
        ]));
    }
}
