<?php   

namespace App\Services;

use App\Repository\UserRepository;

class UserService{
    public $userRepository;
    public function __construct(UserRepository $userRepository){
        $this->userRepository=$userRepository;

    }



        public function find($id){}
    public function store(array $data){
        return $this->userRepository->Storeuser($data);

    }
    public function update($id, array $data){}
    public function delete($id){}
    public function findByEmail($email){}
}