<?php
declare(strict_types=1);

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\TextArea;

class MahasiswaController extends \Phalcon\Mvc\Controller
{

    /**
     * DASHBOARD
     */

    public function indexAction($id)
    {
        $this->view->id = $id;

        $conditions = ['id' => $id];
        $x = $this->view->pinjInvs = ListPinjamInv::find(
            [
                'id_user = (:id:)',
                'bind' => $conditions,
            ]
        );
    }
    
    public function dashboardAction()
    {

    }

    /**
     * PC
     */

    public function reservasipcpageAction()
    {
        $labs = Laboratorium::find(
            ['columns' => 'id_lab, nama_lab']
        );

        $form = new Form();
        $form->add(new Select(
            'lab',
            $labs,
            [
                'using' => ['id_lab', 'nama_lab'],
                'useEmpty'   => true,
                'emptyText'  => 'Pilih lab yang dituju',
            ],
        ));
        $form->add(new Select(
            'jenis',
            [
                'Server' => 'Remote Server',
                'PC & Workstation' => 'PC dan Workstation'
            ],
        ));
        $form->add(new TextArea('keperluan'));
        $this->view->form = $form;
        $this->flash->success('Success message');
    }
    
    /**
     * LAB
     */

    public function jadwalpemakaianruanganAction()
    {
        if($this->session->has('nama_user'))
        {
            $labs = Laboratorium::find(
                ['columns' => 'id_lab, nama_lab']
            );
            $form = new Form();
            $form->add(New Select(
                'lab',
                $labs,
                [
                    'using' => ['id_lab', 'nama_lab'],
                    'useEmpty'   => true,
                    'emptyText'  => 'Pilih lab yang ingin dilihat',
                ]
            ));
            $this->view->form = $form;
        }
        else {
            echo "You must login to see this page";
            header("refresh:2;url=/mahasiswa/dashboard");
        }
    }

    public function jadwallabAction()
    {
        if($this->session->has('nama_user'))
        {
            if($this->request->isPost())
            {
                $dataSent = $this->request->getPost();

                return $this->dispatcher->forward(array( 
                    'controller' => 'PermohonanRuangan',
                    'action' => 'jadwallab',
                    'params' => array($dataSent["lab"])
                    ));
            }
            else {
                echo "ada yang kurang";
            }
        }
        else
        {
            echo "You must login to see this page";
            header("refresh:2;url=/mahasiswa/dashboard");
        }
    }

    public function reservelabpageAction()
    {
        $labs = Laboratorium::find(
            ['columns' => 'id_lab, nama_lab']
        );

        $form = new Form();
        $form->add(New Select(
            'lab',
            $labs,
            [
                'using' => ['id_lab', 'nama_lab'],
                'useEmpty'   => true,
                'emptyText'  => 'Pilih lab yang ingin direservasi',
            ]
        ));
        $form->add(new TextArea('keperluan'));
        $this->view->form = $form;
    }

    /**
     * INVENTARIS
     */

    public function listInvAction($id)
    {
        $this->view->id = $id;
        $this->view->pick("mahasiswa/requestInv");
        $this->view->invens = ListInv::find();
    }

    public function requestInvAction($id,$invenId)
    {
        return $this->dispatcher->forward(
            [
                'controller' => 'inventaris',
                'action' => 'request',
                'params' => [$id,$invenId],
            ]
        );
    }

    public function cancelInvAction($id,$invenId)
    {
        return $this->dispatcher->forward(
            [
                'controller' => 'inventaris',
                'action' => 'cancel',
                'params' => [$id,$invenId],
            ]
        );
    }
    
}

