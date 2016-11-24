<?php

namespace App\Http\Controllers;

use App\Moldova\Entities\Comment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Mongodb\Eloquent\Model;

/**
 * Class CommentController
 * @package App\Http\Controllers
 */
class CommentController extends Controller
{
    /**
     * Get the like view
     *
     * @param int $id
     */
    public static function viewLike($id)
    {
        echo view('laravelLikeComment.like')
            ->with('like_item_id', $id);
    }

    /**
     * Get the comments
     *
     * @param int $itemId
     *
     * @return Collection
     */
    public static function getComments($itemId)
    {
        $comments = Comment::where('item_id', (string) $itemId)->orderBy('parent_id', 'asc')->get();

        foreach ($comments as $comment) {
            $userId         = $comment->user_id;
            $user           = self::getUser($userId);
            $comment->name  = $user['name'];
            $comment->email = $user['email'];
            $comment->url   = $user['url'];
            $randomHash     = str_random(32);

            if ($user['avatar'] == 'gravatar') {
                $hash            = md5(strtolower(trim($user['email'])));
                $comment->avatar = "http://www.gravatar.com/avatar/$hash?d=identicon";
            } else {
                $comment->avatar = "http://www.gravatar.com/avatar/$randomHash?d=identicon";
            }
        }

        return $comments;
    }

    /**
     * Get the user by user id
     *
     * @param int $userId
     *
     * @return Model
     */
    public static function getUser($userId)
    {
        $userModel = config('laravelLikeComment.userModel');

        return $userModel::getAuthor($userId);
    }

    /**
     * Add a comment
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        $userId      = Auth::user()->id;
        $parent      = $request->parent;
        $commentBody = $request->comment;
        $itemId      = $request->item_id;

        $user       = self::getUser($userId);
        $randomHash = str_random(32);
        $userPic    = "http://www.gravatar.com/avatar/$randomHash?d=identicon";

        if ($user['avatar'] == 'gravatar') {
            $hash    = md5(strtolower(trim($user['email'])));
            $userPic = "http://www.gravatar.com/avatar/$hash?d=identicon";
        }

        $comment            = new Comment;
        $comment->user_id   = $userId;
        $comment->parent_id = $parent;
        $comment->item_id   = $itemId;
        $comment->comment   = $commentBody;

        $comment->save();

        $id = $comment->id;

        return response()->json(
            ['flag' => 1, 'id' => $id, 'comment' => $commentBody, 'item_id' => $itemId, 'userName' => $user['name'], 'userPic' => $userPic]
        );
    }
}
