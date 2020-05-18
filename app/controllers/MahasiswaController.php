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

    // public function indexAction($id)
    public function indexAction()
    {
        $id = $this->session->isAdmin;
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
        $this->view->pagetitle = "Dashboard";

        $id = $this->session->user_id;
        $this->view->id = $id;
        $conditions = ['id' => $id];

        # untuk daftar list pinjaman barang user
        $this->view->pinjInvs = ListPinjamInv::find(
            [
                'id_user = (:id:)',
                'bind' => $conditions,
            ]
        );

        # untuk daftar list pinjaman ruang si user
        $this->view->pinjLabs = PermohonanRuangan::find(
            [
                'id_user = (:id:)',
                'bind' => $conditions,
            ]
        );

        $this->view->labs = Laboratorium::find();
        $this->view->pcs = Pc::find();

        #untuk daftar list reservasi pc user
        $this->view->pinjPcs = PermohonanPc::find(
            [
                'id_user = (:id:)',
                'bind' => $conditions,
            ]
        );
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
        $this->view->pagetitle = "Form Reservasi PC";
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
                    // 'class' => 'dropdown',
                ]
            ));
            $this->view->form = $form;
            $this->view->pagetitle = "Lihat Jadwal Lab";
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
                $this->view->pagetitle = "Jadwal Ruangan Lab";
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
        $this->view->pagetitle = "Form Reservasi Lab";
    }

    /**
     * INVENTARIS
     */

    public function listInvAction($id)
    {
        $this->view->id = $id;
        $this->view->pagetitle = "Daftar Inventaris";
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

