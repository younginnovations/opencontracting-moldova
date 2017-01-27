<?php

namespace App\Moldova\Service;

use App\Moldova\Repositories\Feedback\FeedbackRepository;

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
     * @return mixed
     */
    public function getContractWithFeedback()
    {
        return $this->feedback->getContractWithFeedback();
    }
}
