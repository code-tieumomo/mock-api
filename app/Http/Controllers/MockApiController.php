<?php

namespace App\Http\Controllers;

use App\Models\MockApi;
use App\Models\User;
use Arr;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
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
            'prefix' => [
                'required',
                'string',
                'regex:/^\/[a-zA-Z0-9\/]*$/',
                Rule::unique('mock_apis')
                    ->where(fn (Builder $query) => $query->where('user_id', Auth::id())->where('status', 'published')),
            ],
            'description' => 'nullable|string',
        ]);

        $name = $request->name;
        $prefix = $request->prefix;
        $description = $request->description;

        $mockApi = MockApi::create([
            'user_id' => Auth::id(),
            'name' => $name,
            'prefix' => $prefix,
            'description' => $description,
        ]);

        $structurePrompt = '
            Create an example of JSON structure for a mock API resource with the following details:

            - **Resource Name**: ' . $name . '
            - **Resource Prefix**: ' . $prefix . '
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

        $mockApi->update([
            'structure' => $structure,
        ]);

        return redirect()->route('mock-apis.publish', $mockApi);
    }

    public function publish(MockApi $mockApi)
    {
        return view('mock-apis.publish', compact('mockApi'));
    }

    public function regenerate(MockApi $mockApi, Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'prefix' => [
                'required',
                'string',
                'regex:/^\/[a-zA-Z0-9\/]*$/',
                Rule::unique('mock_apis')
                    ->where(fn (Builder $query) => $query->where('user_id', Auth::id())->where('status', 'published')),
            ],
            'description' => 'nullable|string',
        ]);

        $name = $request->name;
        $prefix = $request->prefix;
        $description = $request->description;

        $mockApi->update([
            'name' => $name,
            'prefix' => $prefix,
            'description' => $description,
        ]);

        $structurePrompt = '
            Create an example of JSON structure for a mock API resource with the following details:

            - **Resource Name**: ' . $name . '
            - **Resource Prefix**: ' . $prefix . '
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

        $mockApi->update([
            'structure' => $structure,
        ]);

        return redirect()->route('mock-apis.publish', $mockApi);
    }

    public function publishApi(MockApi $mockApi, Request $request)
    {
        ini_set('max_execution_time', 300);
        
        $request->validate([
            'json_structure' => 'required|json',
        ]);

        $jsonStructure = json_decode($request->json_structure, true);

        $mockApi->update([
            'structure' => $jsonStructure,
        ]);

        $dataPrompt = '
            Create an array with 10 objects that match the JSON structure for the mock API resource with the following details:

            - **Resource Name**: ' . $mockApi->name . '
            - **Resource Prefix**: ' . $mockApi->prefix . '
            - **Description**: ' . $mockApi->description . '
            - **JSON Structure**: ' . json_encode($mockApi->structure) . '

            Ensure the array includes:
            - 10 objects
            - Each object has all needle properties
            - Each property has an example value
            - All necessary properties to match with the description

            Example:

            In case of a user resource, the array should look like:

            [
                {
                    "id": 1,
                    "name": "John Doe",
                    "email": "user@example.com"
                },
                {
                    "id": 2,
                    "name": "Jane Doe",
                    "email": "user2@example.com"
                },
                ...
            ]

            The array should be valid and follow the JSON format.

            Only return the array, do not include any other information or "```json".
        ';

        $dataResponse = Prism::text()
            ->using(Provider::XAI, 'grok-2-latest')
            ->withMaxTokens(130000)
            ->withPrompt($dataPrompt)
            ->asText();
        $rawData = $dataResponse->text;
        $data = json_decode($rawData, true);

        $mockApi->update([
            'storage' => $data,
            'status' => 'published',
        ]);

        Auth::user()->mockApis()
            ->where('prefix', $mockApi->prefix)
            ->where('id', '!=', $mockApi->id)
            ->delete();

        return redirect()->route('mock-apis.show', $mockApi)
            ->with('success', 'Mock API published successfully.');
    }

    public function show(MockApi $mockApi)
    {
        return view('mock-apis.show', compact('mockApi'));
    }

    public function update(MockApi $mockApi, Request $request)
    {
        $request->validate([
            'storage' => 'required|json',
        ]);

        $storage = json_decode($request->storage, true);
        
        $mockApi->update([
            'storage' => $storage,
        ]);

        return redirect()->route('mock-apis.show', $mockApi)
            ->with('success', 'Mock API updated successfully.');
    }

    // API

    public function apiIndex(string $providerId, string $prefix)
    {
        $user = User::where('provider_id', $providerId)->first();
        $userId = $user->id;

        $mockApi = MockApi::where('user_id', $userId)
            ->where('prefix', '/' . $prefix)
            ->where('status', 'published')
            ->first();
        $storage = $mockApi->storage;

        // Paginate
        $page = request()->query('page', 1);
        $perPage = request()->query('per_page', 10);
        $offset = ($page - 1) * $perPage;
        $total = count($storage);
        $data = array_slice($storage, $offset, $perPage);

        // Query
        $query = request()->query('query');
        $queryField = request()->query('query_field');
        if ($query && $queryField) {
            $data = array_filter($data, function ($item) use ($query, $queryField) {
                $needleValue = Arr::get($item, $queryField);
                return strpos($needleValue, $query) !== false;
            });
        } else if ($query) {
            $data = array_filter($data, function ($item) use ($query) {
                return strpos(json_encode($item), $query) !== false;
            });
        }

        return response()->json([
            'data' => $data,
            'meta' => [
                'count' => count($data),
                'page' => $page,
                'per_page' => $perPage,
                'total' => $total,
            ],
        ]);
    }
}
