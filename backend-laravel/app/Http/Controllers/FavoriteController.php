<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $uid = $request->query('uid');
        return DB::select("SELECT *, recipes.id as id FROM recipes INNER JOIN favorites WHERE favorites.uid =" . $uid . " AND recipes.id = favorites.rid");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(array $info)
    {
        $favorite = new Favorite;
        $favorite->uid = $info['uid'];
        $favorite->rid = $info['rid'];
        $favorite->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $uid = $request->query('uid');
        $rid = $request->query('rid');
        $favorite = Favorite::where([
            ['uid', '=', $uid],
            ['rid', '=', $rid],
        ])->first();
        return empty($favorite) ? $this->create(['uid' => $uid, 'rid' => $rid]) : $this->destroy($favorite['id']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $favorite = Favorite::find($id);
        $favorite->delete();
    }
}
