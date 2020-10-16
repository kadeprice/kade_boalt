<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Aerni\Spotify\Spotify;
use Illuminate\Support\Facades\Validator;

class SpotifyController extends Controller
{

    private $spotify;
    /**
     * SpotifyController constructor.
     */
    public function __construct(Spotify $spotify)
    {
        $this->spotify = $spotify;
    }

    /*
     * Created by: Kade Price
     * Purpose: Using Spotify API, search for an Tracks, and return results in JSON
     */
    public function searchTracks(Request $request)
    {
        /**Validate the data using validation rules*/
        $validator = Validator::make($request->all(), [
            'tracks'     => 'required',
        ]);

        /**Check the validation becomes fails or not */
        if ($validator->fails()) {
            /**Return error message */
            return response()->json(['error' => $validator->errors()], 400);
        }

        $tracks = $request->tracks;
        if($request->has('limit')) $limit = $request->limit;
        else $limit = 50;

        if($request->has('offset')) $offset = $request->offset;
        else $offset = 0;

        $result = $this->spotify->searchTracks($tracks)->limit($limit)->offset($offset)->get();
        return response()->json(['success' => $result], 200);

    }

    /*
     * Created by: Kade Price
     * Purpose: Using Spotify API, search for an artist, and return results in JSON
     */
    public function searchArtists(Request $request)
    {
        /**Validate the data using validation rules*/
        $validator = Validator::make($request->all(), [
            'artists'     => 'required',
        ]);

        /**Check the validation becomes fails or not */
        if ($validator->fails()) {
            /**Return error message */
            return response()->json(['error' => $validator->errors()], 400);
        }

        $artists = $request->artists;
        if($request->has('limit')) $limit = $request->limit;
        else $limit = 50;

        if($request->has('offset')) $offset = $request->offset;
        else $offset = 0;

        $result = $this->spotify->searchArtists($artists)->limit($limit)->offset($offset)->get();
        return response()->json(['success' => $result], 200);

    }


}
