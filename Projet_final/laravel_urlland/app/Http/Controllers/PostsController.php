<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Posts;
use App\Models\Comments;
use Session;
use DB;

class PostsController extends Controller
{
    // Affichage de tous les posts
    public function displayPosts()
    {
        $posts = Posts::orderBy('created_at', 'desc')->get();
        return $posts;
    }

    // Affichage d'un post en fonction de son id
    public function displayPost($id_post)
    {
        $post = Posts::find($id_post);
        // return json_encode($post);
        return $post;
    }

    // Modification d'un post à partir des données du formulaire
    public function modifyPost(Request $request, $id)
    {
        $post = Posts::find($id);
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        if($request->input('category') != null) {
            $post->category = $request->input('category');
        }
        if($request->input('picture') != null) {
            $post->picture = $request->input('picture');
        }
        $post->save();
        $post = Posts::find($id);
        return response($post, 200);
    }

    // Ajout d'un post à partir du contenu du formulaire
    public function addPost(Request $request)
    {
        $post = new Posts();
        $post->create([
            'title' => $request['title'],
            'content' => $request['content'],
            'picture' => $request['picture'],
            'category' => $request['category'],
            'nb_like' => 0,
            'id_user' => $request['id_user'],
        ]);
        return true;
    }

    // Suppression d'un post
    public function deletePost($postId)
    {
        $post = Posts::find($postId);
        $post->delete();

        return true;
    }

    //recherche via la search bar
    public function selectPosts(Request $request)
    {
        $search = $request->query()["search"];
        $posts = Posts::where('title', 'like', "%{$search}%")->orWhere('content', 'like', "%{$search}%")->get();

        return $posts;
    }

    // Affichage de tous les posts d'un utilisateur
    public function userPosts($id)
    {
        $posts = Posts::where('id_user', $id)->get();

        return $posts;
    }

    // Affiche les catégories des publications et le nombre de publications associé à chaque catégorie
    public function getPostsByCategory() {
        $posts = Posts::selectRaw('category, count(*) as nb_posts')
        ->groupBy('category')
        ->orderBy('category')
        ->get();
        return response($posts, 200);
    }

    // Affiche le nombre total de publications par utilisateur (limité aux 5 premiers)
    public function getPostsByUser() {
        $posts = Posts::leftJoin('users', 'posts.id_user', '=', 'users.id')
        ->selectRaw('nickname, count(*) as nb_posts')
        ->groupBy('id_user')
        ->orderBy('nb_posts', 'desc')
        ->limit(5)
        ->get();
        return response($posts, 200);
    }

    // Affiche le nombre total d'utilisateur, de publications et de commentaires
    public function getNumberOf() {
        $nb_users = Users::selectRaw('count(*) as nb_users')
        ->get();
        $nb_posts = Posts::selectRaw('count(*) as nb_posts')
        ->get();
        $nb_comments = Comments::selectRaw('count(*) as nb_comments')
        ->get();
        return response(["users" => $nb_users, "posts" => $nb_posts, "comments" => $nb_comments], 200);
    }

    // Affiche le nombre total de connexion au site
    public function getTotalConnect() {
        $nb_connect = Users::selectRaw('sum(nb_connect) as sumTotal')->get();
        return response(["total" => $nb_connect], 200);
    }

    //Affiche le nombre de posts (commentaires à modifier) créés les 3 derniers jours
    public function getPostsByDate() {
        $array = [];
        
        $avthier = DB::select('SELECT left(created_at,10) AS date, count(*) AS nb_posts FROM posts WHERE created_at IS NOT NULL AND left(created_at,10) = subdate(current_date, 2) GROUP BY date;');
        if(count($avthier) == 1){
            $array[] = $avthier[0];
        } else {
            $avthier = DB::select('SELECT subdate(current_date, 2) AS date;');
            $array[] = ['date' => $avthier[0]->date, 'nb_posts' => 0];
        }

        $hier = DB::select('SELECT left(created_at,10) AS date, count(*) AS nb_posts FROM posts WHERE created_at IS NOT NULL AND left(created_at,10) = subdate(current_date, 1) GROUP BY date;');
        if(count($hier) == 1){
            $array[] = $hier[0];
        } else {
            $hier = DB::select('SELECT subdate(current_date, 1) AS date;');
            $array[] = ['date' => $hier[0]->date, 'nb_posts' => 0];
        }
        
        $aujourdhui = DB::select('SELECT left(created_at,10) AS date, count(*) AS nb_posts FROM posts WHERE created_at IS NOT NULL AND left(created_at,10) = subdate(current_date, 0) GROUP BY date;');
        if(count($aujourdhui) == 1){
            $array[] = $aujourdhui[0];
        } else {
            $aujourdhui = DB::select('SELECT subdate(current_date, 0) AS date;');
            $array[] = ['date' => $aujourdhui[0]->date, 'nb_posts' => 0];
        }

        return response($array, 200);
    }

    public function addLike($id) {
        $post = Posts::find($id);
        $post->nb_like = $post->nb_like + 1;
        $post->save();
        $post = Posts::find($id);
        return response($post, 200);
    }
}