<?php 

namespace App\Repository;

use App\Models\User;

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
    public function update($id, array $data){}
    public function delete($id){}
    public function findByEmail($email){}
}