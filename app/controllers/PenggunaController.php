<?php

declare(strict_types=1);
use Phalcon\Security;

class PenggunaController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
       
    }

    public function loginpageAction()
    {
       
    }

    public function loginAction()
    {
        if($this->request->isPost())
        { 
         $nrp    = $this->request->getPost('nrp');
         $password = $this->request->getPost('password');
         echo "</br>";
         $user = Pengguna::findFirst(     // Nyari user berdasar NRP yang diinput
             [
                 'conditions' => 'nrp = :nrp:',
                 'bind'       => [
                     'nrp' => $nrp,
                 ],
             ]
         );
 
         if ($user) { //Memeriksa apakah user ada
            $check = $this
               ->security
               ->checkHash($password, $user->password); //Memeriksa apakah password sesuai

             if (true == $check) {  
                 //Password benar
                 $this->session->set('user_id', $user->id_user);
                 $this->session->set('nama_user', $user->nama);
                 $this->session->set('nrp', $user->nrp);
                 $this->session->set('isAdmin', $user->isAdmin);
                 
                 echo "Login successful!";
                 if($user->isAdmin) {
                    header("refresh:1;url=/admin/dashboard");
                 }
                 else {
                    header("refresh:1;url=/mahasiswa/dashboard");        
                 }
             }
             else {
                //Password salah
                echo "Wrong password!";
                header("refresh:2;url=/pengguna/loginpage");
             }
         }
         else {
            //User tidak ada di database
             echo "User doesn't exist!";
             header("refresh:2;url=/pengguna/loginpage");
             $this->security->hash(rand());
         }
        }
     }

     public function logoutAction() { 
      //   $this->session->remove('auth');
        $this->session->destroy();
        echo "You're logged out";
        header("refresh:2;url=/");
      //   return $this->dispatcher->forward(array( 
      //      'controller' => 'index', 'action' => 'index' 
      //   )); 
     }
}

