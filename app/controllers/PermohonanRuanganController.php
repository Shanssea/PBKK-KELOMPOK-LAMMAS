<?php
declare(strict_types=1);

class PermohonanRuanganController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {

    }

    public function jadwallabAction(int $lab)
    {
        
        if($this->session->has('nama_user'))
        {
            $prs = PermohonanRuangan::find(     // 
                [
                    'conditions' => 'id_lab = :lab: AND ' .
                                    'status = :status:',
                    'bind'       => [
                        'lab'       => $lab,
                        'status'    => 'Permohonan diterima'
                    ],
                    'order'      => 'created_at'
                ]
            );
            $infolab = Laboratorium::findFirst(
                [
                    'conditions'    => 'id_lab = :lab:',
                    'bind'          => [
                        'lab' => $lab,
                    ],
                    'columns'       => 'nama_lab'
                ]
            );
            if ($this->session->isAdmin > 0)
            {
                $this->view->setTemplateAfter('admin');
            }
            elseif ($this->session->isAdmin == 0)
            {
                $this->view->setTemplateAfter('mahasiswa');
            }
            $this->view->prs = $prs;
            $namalab = $infolab->nama_lab;
            $this->view->pagetitle = "Jadwal Pemakaian Ruangan ".$namalab;
        }
    }

    public function reservelAction()
    {
        if($this->session->has('nama_user'))
        {
            $dataSent = $this->request->getPost();

            $pr = new PermohonanRuangan();
            $pr->id_user = $this->session->user_id;
            $pr->id_lab = $dataSent["lab"];
            $pr->tanggal = $dataSent["tanggal"];
            $pr->keperluan = $dataSent["keperluan"];
            $pr->tanggal = $dataSent["waktu"];
            $pr->created_at = date('Y-m-d H:i:s');
            $pr->status = "Menunggu persetujuan admin";

            $success = $pr->save();

            if ($success) {
                $this->response->redirect('/mahasiswa/jadwalpemakaianruangan');
            } else {
                echo "Oops, tambah permohonan peminjaman ruangan gagal! Seems like the following issues were encountered: ";

                $messages = $pr->getMessages();

                foreach ($messages as $message) {
                    echo $message->getMessage(), "<br/>";
                }
            }
        }
    }
    
    public function confirmAction(int $id)
    {
        if ($this->session->isAdmin) {    
            if($this->request->isPost()) {
                $pr = PermohonanRuangan::findFirst(     // 
                    [
                        'conditions' => 'id_plab = :id:',
                        'bind'       => ['id' => $id,],
                    ]
                );
                if($pr->id_lab == $this->session->isAdmin) {
                    $dataSent = $this->request->getPost();

                    $pr->status = $dataSent["status"];
        
                    $success = $pr->save();

                    if ($success) {
                        $this->response->redirect('/admin/listPermohonanRuangan/'.$this->session->isAdmin);
                    } else {
                        echo "Oops, update data status permohonan reservasi lab gagal! Seems like the following issues were encountered: ";

                        $messages = $pr->getMessages();

                        foreach ($messages as $message) {
                            echo $message->getMessage(), "<br/>";
                        }
                    }
                } else {
                    echo "This is not your lab's permohonan reservasi lab, dude!";
                    header("refresh:2;url=/admin/jadwalPemakaianRuangan/".$this->session->isAdmin);
                }
            }
        }
        else {
            echo "Syapa kaw";
            header("refresh:2;url=/");
        }
    }

    public function listprAction(int $lab)
    {
        if($this->session->has('nama_user'))
        {
            $prs = PermohonanRuangan::find(     // 
                [
                    'conditions' => 'id_lab = :lab:',
                    'bind'       => [
                        'lab'       => $lab
                    ],
                    'order'      => 'status, created_at'
                ]
            );
            $infolab = Laboratorium::findFirst(
                [
                    'conditions'    => 'id_lab = :lab:',
                    'bind'          => [
                        'lab' => $lab,
                    ],
                    'columns'       => 'nama_lab'
                ]
            );
            $this->view->setTemplateAfter('admin');
            $this->view->prs = $prs;
            $this->view->namalab = $infolab->nama_lab;
        }
    }
}

