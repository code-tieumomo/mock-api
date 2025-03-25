<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Prism;

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

        $structurePrompt = '
            Create an example of JSON structure for a mock API resource with the following details:

            - **Resource Name**: ' . $name . '
            - **Resource Prefix**: ' . $resourcePrefix . '
            - **Description**: ' . $description . '

            Ensure the JSON structure includes:
            - All needle properties (e.g., name, email, and ID for users)
            - Each property have an example value
            - All nessesary propperty to match with description

            Example:

            In case of a user resource, the JSON structure should look like:

            {
                "id": 1,
                "name": "John Doe",
                "email": "example@user.com"
            }

            The JSON structure should be valid and follow the JSON format.

            Only return the JSON structure, do not include any other information or "```json".
        ';

        $structureResponse = Prism::text()
            ->using(Provider::XAI, 'grok-2-latest')
            ->withPrompt($structurePrompt)
            ->generate();
        $rawStructure = $structureResponse->text;
        $structure = json_decode($rawStructure, true);

        return view('mock-apis.generate', compact([
            'name',
            'resourcePrefix',
            'description',
            'structure',
        ]));
    }
}
