<?php

class ListPinjamInv extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $id_user;

    /**
     *
     * @var integer
     */
    public $id_lab;

    /**
     *
     * @var string
     */
    public $nama;

    /**
     *
     * @var string
     */
    public $nama_lab;

    /**
     *
     * @var string
     */
    public $nama_barang;

    /**
     *
     * @var string
     */
    public $tanggal;

    /**
     *
     * @var string
     */
    public $keperluan;

    /**
     *
     * @var string
     */
    public $status;


    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("lammas");
        $this->setSource("daftarPinjamanInv");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ListPinjamInv[]|ListPinjamInv|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ListPinjamInv|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
