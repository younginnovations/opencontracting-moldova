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
        $this->comment = $comment;
        $this->ocdsRelease = $ocdsRelease;
    }

    /**
     * Returns all the unique contracts that has  comments
     *
     * @return array
     */
    public function getUniqueContractsWithFeedback()
    {
        $comment = $this->comment->distinct('item_id')->get();

        return $comment;
    }

    /**
     * Get all the contract id and title that has comments
     *
     * @return array
     */
    public function getContractWithFeedback()
    {
        $contractIds = $this->getUniqueContractsWithFeedback();
        $comments=[];
        foreach($contractIds as $key => $contractId){
            $result= $this->ocdsRelease->where('contracts.id', (int) $contractId[0])->project([
                                                                                                  'contracts.$'=>1,
                                                                                                  'awards' => 1,
                                                                                                  'tender.id' => 1,
                                                                                                  'tender.title' => 1,
                                                                                                  'buyer.name' => 1
                                                                                              ])->first();
            $comments[$key]['id']=$contractId[0];
            $comments[$key]['title']=$result['contracts'][0]['title'];
        }

        return $comments;
    }
}
