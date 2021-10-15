<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TagController extends Controller
{

    public function index(Request $request)
    {

        $campaign = Campaign::find($request->id);

        $tags = Tag::all();

        $campaign->load('tags');

        return view('tag.index', compact('campaign', 'tags'));

    }

    public function storeTag(Request $request)
    {
        try {
            $campaign = Campaign::find($request->campaignId);

            $campaign->tags()->syncWithoutDetaching($request->tagId);

            $response = ['status' => 'success'];

        }catch (\Throwable $t){
            Log::error('[TagController storeTag] error occurred while adding the tag. Error: '.$t->getMessage());

            $response = ['status' => 'error', 'msg'=>'Error occurred while storing the tag. Check the log file'];

        }

        return response()->json($response);
    }

    public function removeTag(Request $request)
    {
        try {
            $campaign = Campaign::find($request->campaignId);

            $campaign->tags()->detach($request->tagId);

            $response = ['status' => 'success'];
        }catch (\Throwable $t){
            Log::error('[TagController removeTag] error occurred while removing the tag. Error: '.$t->getMessage());
            $response = ['status' => 'error', 'msg'=>'Error occurred while removing the tag. Check the log file'];
        }

        return response()->json($response);
    }
}
