<?php

use Phalcon\Security;
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;

class SignupController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {   
        $form = new Form();
        $form->add(new Text('nama'));
        $form->add(new Text('nrp'));
        $form->add(new Text('no_telp'));
        $form->add(new Text('alamat'));
        $form->add(new Password('password'));
        $this->view->form = $form;
    }
    
    public function registerAction()
    {
        $user = new Pengguna();

        if($this->request->isPost())
        {
            $dataSent = $this->request->getPost();

            $user = new Pengguna();
            $security = new Security();
            
            $hashed = $security->hash($dataSent["password"]);
            $user->password = $hashed;
            $user->nama = $dataSent["nama"];
            $user->nrp = $dataSent["nrp"];
            $user->alamat = $dataSent["alamat"];
            $user->no_telp = $dataSent["no_telp"];
            $user->isAdmin = 0;

            $success = $user->save();
        }

        if ($success) {
            echo "Thank you for signing up!";
            header("refresh:2;url=/");
        } else {
            echo "Oops, seems like the following issues were encountered: ";

            $messages = $user->getMessages();

            foreach ($messages as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }

        $this->view->disable();
    }
}