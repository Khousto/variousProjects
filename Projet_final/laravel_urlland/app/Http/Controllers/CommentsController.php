<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comments;
use Session;

class CommentsController extends Controller
{
    // Affichage des commentaires d'un user
    public function displayCommentsByUser($id_user)
    {
        $comments = Comments::where("id_user", "=", $id_user)->get();
        return response($comments, 200);
    }

    // Affichage d'un commentaire
    public function displayComment($id)
    {

        // $comment = Comments::where("id", "=", $id)->get()->first();
        $comment = Comments::find($id);
        return $comment;
    }

    // Affichage des commentaires d'un post
    public function displayCommentsByPost($id_post)
    {
        $comments = Comments::where("id_post", "=", $id_post)->get();
        return response($comments, 200);
    }
    
    // Modification d'un commentaire à partir des données du formulaire
    public function modifyComment(Request $request, $id)
    {
        $comment = Comments::find($id);

        $comment->content = $request->input('content');
        $comment->save();

        $comment = Comments::find($id);
        return response($comment, 200);
    }

    // Ajout d'un commentaire à partir du contenu du formulaire
    public function addComment(Request $request)
    {
        $comment = new Comments();
        $comment->create([
            'content' => $request['content'],
            'nb_like' => 0,
            'id_user' => $request['id_user'],
            'id_post' => $request['id_post'],
        ]);
        $comments = Comments::where("id_post", "=", $request['id_post'])->get();
        return json_encode(["comment" => $comments]);
    }

    // Suppression d'un commentaire
    public function deleteComment($commentId)
    {
        $comment = Comments::find($commentId);
        $comment->delete();

        return true;
    }
}