<?php

namespace App\Moldova\Repositories\Feedback;

use App\Moldova\Entities\Comment;
use App\Moldova\Entities\OcdsRelease;

/**
 * Repository for feedback from custom users
 *
 * Class FeedbackRepository
 * @package App\Moldova\Repositories\Feedback
 */
class FeedbackRepository implements FeedbackRepositoryInterface
{
    /**
     * @var Comment
     */
    private $comment;
    /**
     * @var OcdsRelease
     */
    private $ocdsRelease;

    /**
     * FeedbackRepository constructor.
     *
     * @param Comment     $comment
     * @param OcdsRelease $ocdsRelease
     */
    public function __construct(Comment $comment, OcdsRelease $ocdsRelease)
    {
        $this->comment     = $comment;
        $this->ocdsRelease = $ocdsRelease;
    }

    /**
     * Get all the contract id and title that has comments
     *
     * @return array
     */
    public function getContractWithFeedback($params)
    {
        if ($params === "") {
            return $this->comment->count();
        }

        $orderIndex = $params['order'][0]['column'];
        $ordDir     = $params['order'][0]['dir'];
        $column     = $this->getColumn($params['columns'][$orderIndex]['data']);
        $startFrom  = $params['start'];
        $ordDir     = (strtolower($ordDir) == 'asc') ? 1 : - 1;
        $search     = $params['search']['value'];

        $result = $this->comment
            ->where(function ($query) use ($search) {

                if (!empty($search)) {
                    return $query->where('comment', 'like', '%' . $search . '%');
                }

                return $query;
            })
            ->take((int) $params['length'])
            ->skip($startFrom)
            ->orderBy($column, $ordDir)
            ->get(['_id','item_id', 'comment', 'created_at', 'user_id','status']);

        return ($result);
    }

    private function getColumn($column)
    {
        switch ($column) {
            case '2':
                $column = 'created_at';
                break;
            case '0':
                $column = 'comment';
                break;
            default :
                break;
        }

        return $column;
    }
}
