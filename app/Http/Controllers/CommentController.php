<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Events\Comments; 

class CommentController extends Controller
{
    public function getComments($postId)
{
    $comment = Comment::where('post_id', $postId)->first();
    return response()->json($comment ? $comment->content : []);
}
public function store(Request $request)
{
    $request->validate([
        'post_id' => 'required|integer',
        'content' => 'required|string',
        'parent_id' => 'nullable|integer',
    ]);

    $comment = Comment::firstOrCreate(
        ['post_id' => $request->post_id],
        ['content' => '[]'] 
    );

    $comments = is_array($comment->content) ? $comment->content : json_decode($comment->content, true);
    $comments = $comments ?? [];

    if ($request->parent_id) {
        foreach ($comments as &$c) {
            if ($c['id'] == $request->parent_id) {
                $c['replies'][] = [
                    'id' => time(),
                    'user' => auth()->user()->name,
                    'content' => $request->content,
                ];
                break;
            }
        }
    } else {
        $comments[] = [
            'id' => time(),
            'user' => auth()->user()->name,
            'content' => $request->content,
            'replies' => [],
        ];
    }
    $channelName = 'code-'.$request->post_id;
            broadcast(new Comments(
                $comments,
                $channelName
            ));

    $comment->update(['content' => $comments]);

    return response()->json(['success' => 'Bình luận đã được thêm.']);
}

   
}
