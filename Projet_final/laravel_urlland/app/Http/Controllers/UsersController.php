<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Posts;
use App\Models\Comments;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UsersController extends Controller
{
    // Ajout d'un utilisateur à partir des informations insérées dans le formulaire
    public function addUser(Request $request)
    {
        $user = new Users();
        $user->insert([
            'nickname' => $request['nickname'],
            'email' => $request['email'],
            'password' => password_hash($request['password'], PASSWORD_DEFAULT),
            'logo' => 0,
            'is_admin' => $request['is_admin'],
        ]);

        $users = Users::all();
        return response($users, 200);
    }

     // Inscription d'un utilisateur à partir des informations insérées dans le formulaire
     public function registerUser(Request $request)
     {
        if($request['password'] == $request['passwordV2'])
        {
            $user = new Users();
            $user->insert([
                'nickname' => $request['nickname'],
                'email' => $request['email'],
                'password' => password_hash($request['password'], PASSWORD_DEFAULT),
                'logo' => 0,
                'is_admin' => 0
            ]);
            return true;
        }
        else
        {
            return false;
        }
     }

    // Affichage de tous les users
    public function displayUsers()
    {
        $users = Users::all();
        return $users;
    }

    // Affichage d'un user
    public function displayUser($userId)
    {
        $user = Users::find($userId);
        return $user;
    }

    // Suppression d'un user ainsi que toutes ses publications et tous ses commentaires
    public function deleteUser($userId)
    {
        $comments = Comments::where("id_user", $userId);
        $comments->delete();

        $posts = Posts::where('id_user', $userId)
        ->delete();

        $user = Users::find($userId);
        $user->delete();
        return true;
    }

    // Modification d'un user à partir des informations du formulaire
    public function modifyProfilUser(Request $request)
    {
        $id = Session::get('id');
        $nickname = $request->input('nickname');
        $email = $request->input('email');
        $password = password_hash($request->input('password'), PASSWORD_DEFAULT);
        $logo = $request->input('logo');

        //Si le password n'a pas été modifié
        if($password == null)
        {
            $user = Users::find($id);
            $user->nickname = $nickname;
            $user->email = $email;
            $user->logo = $logo;
            $user->save();
            return response("modified user", 200);
        }
        else
        {
            $user = Users::find($id);
            $user->nickname = $nickname;
            $user->email = $email;
            $user->logo = $logo;
            $user->password = $password;
            $user->save();
            return response("complete modified user", 200);

        }
    }

    // Modification d'un user à partie des informations du formulaire dans la partie admin
    public function modifyUser(Request $request)
    {
        $id = $request->input('id');
        $nickname = $request->input('nickname');
        $email = $request->input('email');
        $password = password_hash($request->input('password'), PASSWORD_DEFAULT);
        $logo = $request->input('logo');
        $is_admin = $request->input('is_admin');

        //Si le password n'a pas été modifié
        if($password == null)
        {
            if($is_admin == null)
            {
                $user = Users::find($id);
                $user->nickname = $nickname;
                $user->email = $email;
                $user->logo = $logo;
                $user->save();
                $user = Users::find($id);
                return response($user, 200);
            }
            else
            {
                $user = Users::find($id);
                $user->nickname = $nickname;
                $user->email = $email;
                $user->logo = $logo;
                $user->is_admin = $is_admin;
                $user->save();
                $user = Users::find($id);
                return response($user, 200);
            }
        }
        else
        {
            if($is_admin == null)
            {
                $user = Users::find($id);
                $user->nickname = $nickname;
                $user->email = $email;
                $user->logo = $logo;
                $user->password = $password;
                $user->save();
                $user = Users::find($id);
                return response($user, 200);
            }
            else
            {
                $user = Users::find($id);
                $user->nickname = $nickname;
                $user->email = $email;
                $user->logo = $logo;
                $user->password = $password;
                $user->is_admin = $is_admin;
                $user->save();
                $user = Users::find($id);
                return response($user, 200);
            }
        }
    }

     //Connexion de l'utilisateur en comparant à la DB
     public function connectUser(Request $request)
     {
         $email = $request->input('email');
         $password = $request->input('password');
         $users = Users::where('email', $email)->get();
         if(count($users) == 1)
         {
            $comparaison = password_verify($password, $users[0]['password']);
            if($comparaison)
            {
                return response ($users[0]['id'], 200);
            }
            else
            {
                //si le mail correspond mais pas le password
                return response('Ok', 200);
            }
         }
         else
         {
            //Si aucun user ne correspond à l'email saisi
            return response('unknown user', 404);
         }
     }

     //Déconnexion de l'utilisateur
    public function deconnectUser()
    {
        $id = Session::find('id');

        session()->forget('id');
        session()->flush();
        session()->save();

        return response("deconnexion", 200);

    }

    //Accéder à l'espace admin
    public function verifyIsAdmin($userId)
    {
        $user = Users::find($userId);
        if($user['is_admin'] == true)
        {
            return response("is admin", 200);

        }
        else
        {
            return response("is not admin", 400);
        }
    }

    //Incrémenter le nombre de connexion d'un utilisateur
    public function addNumberConnect($userId)
    {
        $user = Users::find($userId);
        $user->nb_connect = $user['nb_connect'] + 1;
        $user->save();
        return response($user, 200);
    }
}