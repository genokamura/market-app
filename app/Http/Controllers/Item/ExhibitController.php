<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Http\Requests\Item\ExhibitItemRequest;
use App\Services\Item\ExhibitService;

class ExhibitController extends Controller
{
    protected $exhibitService;

    public function __construct()
    {
        $this->exhibitService = new ExhibitService();
    }

    public function exhibitItem(ExhibitItemRequest $request)
    {
        $result = $this->exhibitService->exhibitItem($request->validated());
        return redirect()->route('item.exhibit.complete', ['id' => strval($result['id'])]);
    }

    public function exhibitComplete($id)
    {
        return view('item.exhibit.complete', compact(['id']));
    }
}
