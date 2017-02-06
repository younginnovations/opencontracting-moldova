<?php

namespace App\Moldova\Service;

use App\Moldova\Repositories\Feedback\FeedbackRepository;
use App\User;

/**
 * Class FeedbackService
 * @package App\Moldova\Service
 */
class FeedbackService
{
    /**
     * @var FeedbackRepository
     */
    private $feedback;

    /**
     * FeedbackService constructor.
     *
     * @param FeedbackRepository $feedback
     */
    public function __construct(FeedbackRepository $feedback)
    {
        $this->feedback = $feedback;
    }

    /**
     * Get all the contracts title that has feedback or comments
     *
     * @param $params
     * @return mixed
     */
    public function getContractWithFeedback($params)
    {
        $comments = $this->feedback->getContractWithFeedback($params);

        foreach($comments as $key => $comment){
            $comments[$key]['user_name'] = User::getUserDetail($comment->user_id)->name;
        }

        return [
            'draw'            => (int) $params['draw'],
            'recordsTotal'    => $this->feedback->getContractWithFeedback(""),
            "recordsFiltered" => $this->feedback->getContractWithFeedback(""),
            'data'            => $comments
        ];
    }
}
