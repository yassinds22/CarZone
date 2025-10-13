<?php 

namespace App\Repository;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository{
    public $user;
    public function __construct(User $user){
        $this->user=$user;
    }
    

     public function all(){

     }
    public function find($id){}
    public function Storeuser(array $data){
        return $this->user::create($data);

    }



//----------------
    public function findByGoogleId(string $googleId): ?Model
    {
        return $this->user->where('google_id', $googleId)->first();
    }

    public function findByEmail(string $email): ?Model
    {
        return $this->user->where('email', $email)->first();
    }
//---------------


    public function update($id, array $data){}
    public function delete($id){}
   
}