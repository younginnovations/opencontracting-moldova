<?php
$GLOBALS['commentDisabled'] = "";
if (!Auth::check())
    $GLOBALS['commentDisabled'] = "disabled";
$GLOBALS['commentClass'] = - 1;
?>
<div class="laravelComment" id="laravelComment-{{ $comment_item_id }}">
    <h3 class="ui dividing header">Comments</h3>

    <div class="ui threaded comments" id="{{ $comment_item_id }}-comment-0">
        <form class="ui laravelComment-form form" id="{{ $comment_item_id }}-comment-form" data-parent="0"
              data-item="{{ $comment_item_id }}">
            <div class="field">
                <textarea id="0-textarea" rows="2" {{ $GLOBALS['commentDisabled'] }}></textarea>
                @if(!Auth::check())
                    <small>Please <a href="javascript:" id="showLoginModal">Log in</a> to comment.</small>
                @endif
            </div>
            <input type="submit" class="ui basic small submit button" value="Comment" {{ $GLOBALS['commentDisabled'] }}>
        </form>

<?php
$GLOBALS['commentVisit'] = array();

function dfs($comments, $comment){
$GLOBALS['commentVisit'][$comment->id] = 1;
$GLOBALS['commentClass'] ++;
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
            <a class="{{ $GLOBALS['commentDisabled'] }} reply reply-button" data-toggle="{{ $comment->id }}-reply-form">Reply</a>
        </div>
        {{ \App\Http\Controllers\CommentController::viewLike('comment-'.$comment->id) }}
        <form id="{{ $comment->id }}-reply-form" class="ui laravelComment-form form" data-parent="{{ $comment->id }}"
              data-item="{{ $comment->item_id }}" style="display: none;">
            <div class="field">
                <textarea id="{{ $comment->id }}-textarea" rows="2" {{ $GLOBALS['commentDisabled'] }}></textarea>
                @if(!Auth::check())
                    <small>Please <a href="{{Url('/login')}}">Log in</a> to comment.</small>
                @endif
            </div>
            <input type="submit" class="ui basic small submit button" value="Comment" {{ $GLOBALS['commentDisabled'] }}>
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
    <button class="ui basic button" id="showComment" data-show-comment="0" data-item-id="{{ $comment_item_id }}">Show
        comments
    </button>
</div>


<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="closeLoginModal">×</span>

        <div class="modal__content">
            <div class="background">
                <form class="custom-form" role="form" method="POST" action="{{ url('/login') }}">
                    <div class="formBox" style="">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email"
                                       value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Login
                                </button>

                                <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>