<?php

/*
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ReportModel
 * 
 * Interface to reporting management
 */
class ReportModel extends Model
{
    use HasFactory;

    /**
     * Add reporting
     * 
     * @param $reporterId
     * @param $targetId
     * @param $reason
     * @return void
     * @throws \Exception
     */
    public static function add($reporterId, $targetId, $reason = null)
    {
        try {
            $item = new self();
            $item->reporterId = $reporterId;
            $item->targetId = $targetId;
            $item->reason = $reason;
            $item->save();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Indicate if a user has reported another one
     * 
     * @param $reporterId
     * @param $targetId
     * @return bool
     * @throws \Exception
     */
    public static function hasReported($reporterId, $targetId)
    {
        try {
            $result = static::where('reporterId', '=', $reporterId)->where('targetId', '=', $targetId)->count();

            return $result > 0;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get pack of reports to work on
     * 
     * @return mixed
     * @throws \Exception
     */
    public static function getReportPack()
    {
        try {
            return static::orderBy('id', 'asc')->limit(env('APP_REPORTPACKCOUNT', 30))->get();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Set a user safe
     * 
     * @param $targetId 
     * @return void
     * @throws \Exception
     */
    public static function setSafe($targetId)
    {
        try {
            $items = static::where('targetId', '=', $targetId)->get();
            foreach ($items as &$item) {
                $item->delete();
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
