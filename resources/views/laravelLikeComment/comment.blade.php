<?php
$GLOBALS['commentDisabled'] = "";
if (!Auth::check())
    $GLOBALS['commentDisabled'] = "disabled";
    $GLOBALS['commentClass'] = -1;
?>

<div class="laravelComment" id="laravelComment-{{ $comment_item_id }}">
    <h3 class="ui dividing header">Comments</h3>
    <div class="comment-section box-comment">
        <form class="ui laravelComment-form form" id="{{ $comment_item_id }}-comment-form" data-parent="0"
              data-item="{{ $comment_item_id }}">
            <div class="field">
                <textarea id="0-textarea" rows="2" {{ $GLOBALS['commentDisabled'] }} placeholder="Write your comment"></textarea>
                @if(!Auth::check())
                    <small>Please Log in with <a href="javascript:void(0)" class="facebook-login">facebook</a>/<a href="javascript:void(0)
" class="google-login">google</a> to comment.
                    </small>
                @endif
            </div>
            <input type="submit" class="ui basic small submit button" value="Comment" {{ $GLOBALS['commentDisabled'] }}>
        </form>
    </div>

    <div class="comment-section">
        <div class="ui threaded comments" id="{{ $comment_item_id }}-comment-0">

            <?php
            $GLOBALS['commentVisit'] = array();

            function dfs($comments, $comment){

            $GLOBALS['commentVisit'][$comment->id] = 1;
            $GLOBALS['commentClass']++;
            ?>

            <div class="comment show-{{ $comment->item_id }}-{{ (int)($GLOBALS['commentClass'] / 5) }}"
                 id="comment-{{ $comment->id }}">
                <a class="avatar">
                    <img src="{{ $comment->avatar }}">
                </a>

                <div class="content">
                    <a class="author" url="{{ $comment->url or '' }}"> {{ $comment->name }} </a>

                    <div class="metadata">
                        <span class="date">{{ $comment->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="text">
                        {{ $comment->comment }}
                    </div>

                    <div class="actions">
                        <a class="{{ $GLOBALS['commentDisabled'] }} reply reply-button"
                           data-toggle="{{ $comment->id }}-reply-form">Reply</a>
                    </div>
                    {{ \App\Http\Controllers\CommentController::viewLike('comment-'.$comment->id) }}
                    <form id="{{ $comment->id }}-reply-form" class="ui laravelComment-form form"
                          data-parent="{{ $comment->id }}"
                          data-item="{{ $comment->item_id }}" style="display: none;">
                        <div class="field">
                            <textarea id="{{ $comment->id }}-textarea"
                                      rows="2" {{ $GLOBALS['commentDisabled'] }}></textarea>
                            @if(!Auth::check())
                                <small>Please Log in with <a href="javascript:void(0)"
                                                             class="facebook-login">facebook</a>/<a href="javascript:void(0)
" class="google-login">google</a> to comment.
                                </small>
                            @endif
                        </div>
                        <input type="submit" class="ui basic small submit button"
                               value="Comment" {{ $GLOBALS['commentDisabled'] }}>
                    </form>
                </div>

                <div class="comments" id="{{ $comment->item_id }}-comment-{{ $comment->id }}">
                    <?php
                    foreach ($comments as $child) {
                        if ($child->parent_id == $comment->id && !isset($GLOBALS['commentVisit'][$child->id])) {
                            dfs($comments, $child);
                        }
                    }
                    echo "</div>";
                    echo "</div>";
                    }
                    $comments = App\Http\Controllers\CommentController::getComments($comment_item_id);

                    foreach ($comments as $comment) {
                        if (!isset($GLOBALS['commentVisit'][$comment->id])) {
                            dfs($comments, $comment);
                        }
                    }
                    ?>
                </div>
                @if(0 == count($comments))
                    <p>No comments</p>
                @elseif(5 <= count($comments))
                    <button class="ui basic button" id="showComment" data-show-comment="0"
                            data-item-id="{{ $comment_item_id }}">Show more comments
                    </button>
                @endif
            </div>
        </div>
    </div>

    @section('script')
        @parent
        <script src="{{ asset('js/comment.js') }} " type="text/javascript"></script>
        <script>
            var commentCount = '{{ count($comments) }}';
        </script>
        <script src="{{ asset('/vendor/laravelLikeComment/js/script.js') }}" type="text/javascript"></script>
        <script>
            autosize($('.laravelComment textarea'));
            var commentCount = '{{ count($comments) }}';
        </script>
@endsection
