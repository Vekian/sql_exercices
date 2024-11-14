<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;

class AdController extends BaseController
{
    public function index(int $id): JsonResponse
    {
        /* $status = DB::table('add_moderation_locking_status')
        ->where('ad_id', '=', $id)
        ->get();

        if($status->status) {
            return new JsonResponse("L'annonce est déjà en cours de modification");
        }

        $statusId = DB::table('add_moderation_locking_status')
        ->insertGetId([
            'ad_id' => $id,
            'user_id' => 1,
            'status' => 1,
            'created_at' => Carbon::now()
        ]);
        DB::table('add_moderation_locking_status')
        ->where('id', '=', $statusId)
        ->update([
            'id' => $statusId
        ]); */
        return new JsonResponse("L'annonce a été modifiée");
    }
}
