<?php
declare(strict_types=1);

class PcController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {

    }

    public function listAction(int $lab)
    {
        $pcs = Pc::find(     // 
            [
                'conditions' => 'pc_lab = :lab:',
                'bind'       => [
                    'lab' => $lab,
                ],
            ]
        );
        $this->view->pcs = $pcs;
    }

    public function tambahAction(int $lab)
    {
        if($this->request->isPost()) {
            $pc = new Pc();
            $dataSent = $this->request->getPost();

            $pc->nama_pc = $dataSent["nama"];
            $pc->ip = $dataSent["ip"];
            $pc->hdd = $dataSent["hdd"];
            $pc->ram = $dataSent["ram"];
            $pc->processor = $dataSent["processor"];
            $pc->gpu = $dataSent["gpu"];
            $pc->status_pc = $dataSent["status"];
            $pc->pc_lab = $lab;

            $success = $pc->save();
                

            if ($success) {
                // echo "PC telah ditambahkan";
                // header("refresh:2;url=/admin/listPC");
                $this->response->redirect('/admin/listPC');
            } else {
                echo "Oops, penambahan PC gagal! Seems like the following issues were encountered: ";

                $messages = $pc->getMessages();

                foreach ($messages as $message) {
                    echo $message->getMessage(), "<br/>";
                }
            }
        }
    }

    public function updateAction(int $id)
    {
        if ($this->session->isAdmin) {    
            if($this->request->isPost()) {
                $pc = Pc::findFirst(     // Nyari PC berdasar id_pc yang di-passing
                    [
                        'conditions' => 'id_pc = :id:',
                        'bind'       => ['id' => $id,],
                    ]
                );
                if($pc->pc_lab == $this->session->isAdmin) {
                    $dataSent = $this->request->getPost();

                    $pc->nama_pc = $dataSent["nama"];
                    $pc->ip = $dataSent["ip"];
                    $pc->hdd = $dataSent["hdd"];
                    $pc->ram = $dataSent["ram"];
                    $pc->processor = $dataSent["processor"];
                    $pc->gpu = $dataSent["gpu"];
                    $pc->status_pc = $dataSent["status"];
        
                    $success = $pc->save();

                    if ($success) {
                        // echo "PC telah ditambahkan";
                        // header("refresh:2;url=/admin/listPC");
                        $this->response->redirect('/admin/listPC');
                    } else {
                        echo "Oops, update data PC gagal! Seems like the following issues were encountered: ";

                        $messages = $pc->getMessages();

                        foreach ($messages as $message) {
                            echo $message->getMessage(), "<br/>";
                        }
                    }
                } else {
                    echo "This is not your PC, dude!";
                    header("refresh:2;url=/admin/listPC");
                }
            }
        }
        else {
            echo "Syapa kaw";
            header("refresh:2;url=/");
        }
    }

    public function hapusAction(int $id)
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
                $pc->delete();
                $this->response->redirect('/admin/listPC');
            } else {
                echo "This is not your PC, dude!";
                header("refresh:2;url=/admin/listPC");
            }
        }
        else {
            echo "Syapa kaw";
            header("refresh:2;url=/admin/listPC");
        }
    }
}

