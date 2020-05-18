<?php
declare(strict_types=1);

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;

class AdminController extends \Phalcon\Mvc\Controller
{
    /**
     * DASHBOARD
     */

    // public function indexAction($id)
    public function indexAction()
    {
        // $this->view->setTemplateAfter('admin');
    }

    public function dashboardAction()
    {
        $this->view->pagetitle = "Dashboard";
    }

    /**
     * PC
     */

    public function listPcAction()
    {
        return $this->dispatcher->forward(array( 
        'controller' => 'pc',
        'action' => 'list',
        'params' => array($this->session->isAdmin)
        ));
    }

    public function tambahPcPageAction()
    {
        $form = new Form();
        $form->add(new Text('nama'));
        $form->add(new Text('ip'));
        $form->add(new Text('hdd'));
        $form->add(new Text('ram'));
        $form->add(new Text('processor'));
        $form->add(new Text('gpu'));
        $form->add(new Text('status'));
        $this->view->form = $form;
        $this->view->pagetitle = "Form Tambah PC";
    }

    public function tambahPcAction()
    {
        if($this->request->isPost()) {
            return $this->dispatcher->forward(array( 
            'controller' => 'pc',
            'action' => 'tambah',
            'params' => array($this->session->isAdmin)
            ));
        }
    }

    public function editPcAction(int $id)
    {
        if ($this->session->isAdmin) {    
            $pc = Pc::findFirst(     // Nyari PC berdasar id_pc yang di-passing
                [
                    'conditions' => 'id_pc = :id:',
                    'bind'       => [
                        'id' => $id,
                    ],
                ]
            );
            if($pc->pc_lab == $this->session->isAdmin) {
                $this->view->setVars(
                    [
                        'id'        => $pc->id_pc,
                        'nama'      => $pc->nama_pc,
                        'ip'        => $pc->ip,
                        'hdd'       => $pc->hdd,
                        'ram'       => $pc->ram,
                        'processor' => $pc->processor,
                        'gpu'       => $pc->gpu,
                        'status'    => $pc->status_pc,
                    ]
                );
            } else {
                echo "This is not your PC, dude!";
                header("refresh:2;url=/admin/listPC");
            }
        }
        else {
            echo "Syapa kaw";
            header("refresh:2;url=/");
        }
    }

    public function listReservasiPcAction()
    {
        return $this->dispatcher->forward(array( 
        'controller' => 'PermohonanPc',
        'action' => 'listppc',
        'params' => array($this->session->isAdmin)
        ));
    }

    public function detailreservasipcAction(int $id)
    {
        if ($this->session->isAdmin) {    
            $ppc = PermohonanPc::findFirst(     // Nyari PPC berdasar id_ppc yang di-passing
                [
                    'conditions' => 'id_ppc = :id:',
                    'bind'       => [
                        'id' => $id,
                    ],
                ]
            );
            $pemohon = Pengguna::findFirst(
                [
                    'conditions' => 'id_user = :uid:',
                    'bind'       => [
                        ':uid' => $ppc->id_user,
                    ],
                ]
            );
            $form = new Form();
            $form->add(new Select(
                'status',
                [
                    'Permohonan diterima' => 'Accept',
                    'Permohonan ditolak' => 'Deny',
                    'Permohonan selesai' => 'Already done',
                ],
                [
                    'useEmpty'   => true,
                    'emptyText'  => $ppc->status,
                ],
            ));
            
            if($ppc->lab == $this->session->isAdmin) {
                $this->view->setVars(
                    [
                        'tanggal'   => $ppc->tanggal,
                        'id'        => $ppc->id_ppc,
                        'nama'      => $pemohon->nama,
                        'nrp'       => $pemohon->nrp,
                        'no_telp'   => $pemohon->no_telp,
                        'alamat'    => $pemohon->alamat,
                        'jenis'     => $ppc->jenis,
                        'keperluan' => $ppc->keperluan,
                        'form'      => $form
                    ]
                );

            } else {
                echo "This is not your lab's permohonan PC, dude!";
                header("refresh:2;url=/admin/listReservasiPC");
            }
        }
        else {
            echo "Syapa kaw";
            header("refresh:2;url=/");
        }
    }

    /**
     * LAB
     */
    public function jadwalPemakaianRuanganAction($id)
    {
        // $this->view->id->$id;
        $this->view->id = $id;
        return $this->dispatcher->forward([
                'controller' => 'PermohonanRuangan',
                'action' => 'jadwallab',
                'params' => [$id]
            ]);
    }

    public function detailreservasilabAction(int $id)
    {
        if ($this->session->isAdmin) {    
            $pr = PermohonanRuangan::findFirst(     // Nyari PPC berdasar id_ppc yang di-passing
                [
                    'conditions' => 'id_plab = :id:',
                    'bind'       => [
                        'id' => $id,
                    ],
                ]
            );
            $pemohon = Pengguna::findFirst(
                [
                    'conditions' => 'id_user = :uid:',
                    'bind'       => [
                        ':uid' => $pr->id_user,
                    ],
                ]
            );
            $form = new Form();
            $form->add(new Select(
                'status',
                [
                    'Permohonan diterima' => 'Accept',
                    'Permohonan ditolak' => 'Deny',
                    'Permohonan selesai' => 'Already done',
                ],
                [
                    'useEmpty'   => true,
                    'emptyText'  => $pr->status,
                ],
            ));
            
            if($pr->id_lab == $this->session->isAdmin) {
                $this->view->setVars(
                    [
                        'tanggal'   => $pr->tanggal,
                        'id'        => $pr->id_plab,
                        'nama'      => $pemohon->nama,
                        'nrp'       => $pemohon->nrp,
                        'no_telp'   => $pemohon->no_telp,
                        'alamat'    => $pemohon->alamat,
                        'keperluan' => $pr->keperluan,
                        'form'      => $form
                    ]
                );

            } else {
                echo "This is not your lab's permohonan reservasi lab, dude!";
                header("refresh:2;url=/admin/jadwalPemakaianRuangan/".$this->session->isAdmin);
            }
        }
        else {
            echo "Syapa kaw";
            header("refresh:2;url=/");
        }
    }


    /**
     * INVENTARIS
     */
        
    public function createInvAction($id)
    {
        $this->view->id->$id;
        return $this->dispatcher->forward([
                'controller' => 'inventaris',
                'action' => 'create',
                'params' => [$id]
            ]);
    }

    public function listpeminjamanInvAction($id)
    {
        // $id = $this->session->isAdmin;
        $this->view->id = $id;
        $status = "unverified";
        $this->view->pinjInvs = ListPinjamInv::find(
            [
                'status = (:status:) AND id_lab = (:id:)',
                'bind' => [
                    'id' => $id,
                    'status' => $status,
                ]
            ]
        );
        $this->view->pagetitle = "Barang Pinjaman";
    }

    public function updateInvAction($id,$invenId)
    {
        $this->view->id->$id;
        return $this->dispatcher->forward([
                'controller' => 'inventaris',
                'action' => 'update',
                'params' => [$id,$invenId],
            ]);
    }

    public function deleteInvAction($id,$invenId)
    {
        return $this->dispatcher->forward([
                'controller' => 'inventaris',
                'action' => 'delete',
                'params' => [$id,$invenId],
            ]);
    }

    public function listInvAction($id)
    // public function listInvAction()
    {
        // $id = $this->session->isAdmin;
        $this->view->id->$id;
        $conditions = ['id' => $id];
        $this->view->invens = Inventaris::find(
            [
                'conditions' => 'id_lab=:id:',
                'bind' => $conditions,
            ]
        );
    }

    public function confirmInvAction($id,$pinjInvId)
    {
        return $this->dispatcher->forward([
            'controller' => 'inventaris',
            'action' => 'confirm',
            'params' => [$id,$pinjInvId],
        ]);
    }

    public function declineInvAction($id,$pinjInvId)
    {
        return $this->dispatcher->forward([
            'controller' => 'inventaris',
            'action' => 'decline',
            'params' => [$id,$pinjInvId],
        ]);
    }

}

