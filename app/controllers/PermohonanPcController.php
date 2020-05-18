<?php
declare(strict_types=1);

class PermohonanPcController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {

    }

    public function reserveAction()
    {
        if ($this->session->has('nama_user')) {
            if($this->request->isPost())
            {
                $dataSent = $this->request->getPost();

                $ppc = new PermohonanPc();
                $ppc->lab = $dataSent["lab"];
                $ppc->jenis = $dataSent["jenis"];
                $ppc->keperluan = $dataSent["keperluan"];
                $ppc->id_user = $this->session->user_id;
                $ppc->status = "Menunggu persetujuan admin";
                $ppc->tanggal = date('Y-m-d H:i:s');
                
                $ppc->save();
                $this->response->redirect('/mahasiswa/dashboard');
            }
        }
        else {
            echo "Who are you?";
            header("refresh:2;url=/pengguna/loginpage");
        }
    }

    public function listppcAction(int $lab)
    {
        if ($this->session->isAdmin) {
            $ppcs = PermohonanPc::find(   // Nyari permohonan pc berdasar Lab dari admin yang sedang login
                [
                    'conditions' => 'lab = :lab:',
                    'bind'       => [
                        'lab' => $lab,
                    ],
                    'order'     => 'status, tanggal DESC'
                ]
            );
            $this->view->ppcs = $ppcs;
        }
    }
    
    public function confirmAction(int $id)
    {
        if ($this->session->isAdmin) {    
            if($this->request->isPost()) {
                $ppc = PermohonanPc::findFirst(     // Nyari PC berdasar id_pc yang di-passing
                    [
                        'conditions' => 'id_ppc = :id:',
                        'bind'       => ['id' => $id,],
                    ]
                );
                if($ppc->lab == $this->session->isAdmin) {
                    $dataSent = $this->request->getPost();

                    $ppc->status = $dataSent["status"];
        
                    $success = $ppc->save();

                    if ($success) {
                        $this->response->redirect('/admin/listReservasiPC');
                    } else {
                        echo "Oops, update data status permohonan PC gagal! Seems like the following issues were encountered: ";

                        $messages = $pc->getMessages();

                        foreach ($messages as $message) {
                            echo $message->getMessage(), "<br/>";
                        }
                    }
                } else {
                    echo "This is not your lab's PermohonanPC, dude!";
                    header("refresh:2;url=/admin/listPC");
                }
            }
        }
        else {
            echo "Syapa kaw";
            header("refresh:2;url=/");
        }
    }
}

