<?php

class InventarisController extends ControllerBase
{
    /**
     * ADMIN
     */

    public function createAction($id)
    {
        $this->view->setTemplateAfter('admin');
        $this->view->pagetitle="Tambah Inventaris";
        $this->view->id->$id;
    }

    public function submitAction($id)
    {
        if($this->request->isPost())
        {
            $dataSent = $this->request->getPost();

            $inven = new Inventaris();

            $inven->nama_inv = $dataSent["nama"];
            $inven->status_inv = $dataSent["status"];
            $inven->id_lab = $id;

            $success = $inven->save();
        }

        if ($success) {
        return $this->response->redirect("/admin/dashboard"/*.$id*/);
        } else {
            echo "Oops, seems like the following issues were encountered: ";

            $messages = $inven->getMessages();

            foreach ($messages as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }

        $this->view->disable();
    }

    public function updateAction($id,$invenId)
    {
        $this->view->setTemplateAfter('admin');
        $this->view->pick("inventaris/edit");
        $this->view->id->$id;
        // passing ke view
        $this->view->invenId = $invenId;

        $conditions = ['id_lab' => $id,'id_inv' => $invenId];
        $inven = Inventaris::findFirst(
            [
                'conditions' => 'id_inv = (:id_inv:) AND id_lab = (:id_lab:)',
                'bind' => $conditions,
            ]
        );

        $this->view->setVars(
            [
                'nama_inv' => $inven->nama_inv,
                'status_inv' => $inven->status_inv,
                'pagetitle' => "Edit Inventaris"
            ]
        );

        if ($this->request->isPost()) 
        {

            $dataSent = $this->request->get();

            $inven->nama_inv = $dataSent["nama"];
            $inven->status_inv = $dataSent["status"];
            $inven->id_lab = $id;

            $success = $inven->save();

            if ($success) {
            return $this->response->redirect("/admin/listInv/".$id);
            } else {
                echo "Oops, seems like the following issues were encountered: ";
    
                $messages = $inven->getMessages();
    
                foreach ($messages as $message) {
                    echo $message->getMessage(), "<br/>";
                }
            }
        }
    }

    public function deleteAction($id,$invenId)
    {
        $conditions = ['id_lab' => $id,'id_inv' => $invenId];
        $inven = Inventaris::findFirst(
            [
                'conditions' => 'id_inv = (:id_inv:) AND id_lab = (:id_lab:)',
                'bind' => $conditions,
            ]
        );

        $success = $inven->delete();

        if ($success) {
            return $this->response->redirect("/admin/listInv/".$id);
        } else {
            echo "Oops, seems like the following issues were encountered: ";

            $messages = $inven->getMessages();

            foreach ($messages as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }
    }

    public function confirmAction($id,$pinjInvId)
    {

        $conditions1 = ['id' => $id, 'id_pinv' => $pinjInvId];
        $pinjInv = PinjamInv::findFirst([
            'conditions' => 'id_pinv = (:id_pinv:) AND id_lab = (:id:)',
            'bind' => $conditions1,
        ]);

        $pinjInv->status = 'approved';

        $conditions2 = ['id' => $pinjInv->id_inv];
        $inven = Inventaris::findFirst([
            'conditions' => 'id_inv = (:id:)',
            'bind' => $conditions2,
        ]);

        $inven->status_inv = "unavailable";

        $success = $pinjInv->save();
        $inven->save();

        if ($success) {
            return $this->response->redirect('/admin/dashboard'/*.$id*/);
        } else {
            echo "Oops, seems like the following issues were encountered: ";

            $messages = $inven->getMessages();

            foreach ($messages as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }
    
    }

    public function declineAction($id,$pinjInvId)
    {

        $conditions = ['id' => $id, 'id_pinv' => $pinjInvId];
        $pinjInv = PinjamInv::findFirst([
            'conditions' => 'id_pinv = (:id_pinv:) AND id_lab = (:id:)',
            'bind' => $conditions,
        ]);

        $pinjInv->status = "not approved";

        $success = $pinjInv->save();

        if ($success) {
            return $this->response->redirect('/admin/dashboard'/*.$id*/);
        } else {
            echo "Oops, seems like the following issues were encountered: ";

            $messages = $inven->getMessages();

            foreach ($messages as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }
    
    }

    /**
     * MAHASISWA
     */

    public function requestAction($id,$invenId)
    {
        $this->view->pagetitle="Request Peminjaman Barang";
        $this->view->setTemplateAfter('mahasiswa');
        $this->view->id = $id;
        $this->view->invenId = $invenId;

        $conditions = ['id_inv' => $invenId];
        $inven = Inventaris::findFirst([
            'conditions' => 'id_inv=:id_inv:',
            'bind' => $conditions,
        ]);

        $this->view->setVars(
            [
                'nama' => $inven->nama_inv
            ]
        );

        if ($this->request->isPost()) 
        {
            $pinjInv = new PinjamInv();

            $dataSent = $this->request->getPost();

            $pinjInv->id_user = $id;
            $pinjInv->id_inv = $invenId;
            $pinjInv->id_lab = $inven->id_lab;
            $pinjInv->keperluan = $dataSent["keperluan"];
            $pinjInv->tanggal = $dataSent["tanggal"];

            // $newDate = date("d-m-Y", strtotime($orgDate));  

            $success = $pinjInv->save();

            if ($success) {
                return $this->response->redirect("/mahasiswa/dashboard");
            } else {
                echo "Oops, seems like the following issues were encountered: ";
    
                $messages = $inven->getMessages();
    
                foreach ($messages as $message) {
                    echo $message->getMessage(), "<br/>";
                }
            }
        }
    }

    public function cancelAction($id,$pinjInvId)
    {
        $this->view->pinjInvId = $pinjInvId;

        $conditions = ['id_pinv' => $pinjInvId];
        $pinjInv = PinjamInv::findFirst([
            'conditions' => 'id_pinv=:id_pinv:',
            'bind' => $conditions,
        ]);

        $success = $pinjInv->delete();

        if ($success) {
            return $this->response->redirect("/mahasiswa/".$id);
        } else {
            echo "Oops, seems like the following issues were encountered: ";

            $messages = $inven->getMessages();

            foreach ($messages as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }
    }

}