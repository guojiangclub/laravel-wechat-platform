<?php

/*
 * This file is part of ibrand/wechat-platform.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Platform\Repositories;

use Carbon\Carbon;
use iBrand\Wechat\Platform\Models\CodePublish;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CodePublishRepository.
 */
class CodePublishRepository extends BaseRepository
{
    public function model()
    {
        return CodePublish::class;
    }

    /**
     * @param $appid
     *
     * @return mixed
     */
    public function getAuditByAppID($appid)
    {
        return $this->model->where('appid', $appid)
            ->orderBy('audit_time', 'desc')->first();
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    public function getItemOrCreate($data)
    {
        $item = $this->model->where('appid', $data['appid'])
            ->where('auditid', $data['auditid'])->first();

        if ($item) {
            return $item;
        }

        return $this->model->create($data);
    }

    /**
     * @param $appid
     * @param null $auditid
     * @param int  $limit
     *
     * @return mixed
     */
    public function getListsByAppID($appid, $auditid = null, $limit = 20)
    {
        $query = $this->model->where('appid', $appid);

        if ($auditid) {
            $query->where('auditid', $auditid);
        }

        return $query->orderBy('audit_time', 'desc')->paginate($limit);
    }

    /**
     * @param $audit
     * @param $res_status
     * @param string $res_reason
     *
     * @return mixed
     */
    public function renew($audit, $res_status, $res_reason = '')
    {
        if (isset($audit->status) and $res_status != $audit->status and 2 == $audit->status) {
            $item = $this->model->find($audit->id);

            $item->reason = $res_reason;

            $item->status = $res_status;

            if (0 == $res_status) {
                $item->audit_success_time = date('Y-m-d H:s:i', Carbon::now()->timestamp);
            }

            $item->save();

            return $item;
        }

        return $audit;
    }
}
