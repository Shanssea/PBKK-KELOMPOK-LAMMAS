<?php

class PermohonanRuangan extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_plab;

    /**
     *
     * @var integer
     */
    public $id_lab;

    /**
     *
     * @var integer
     */
    public $id_user;

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
    public $sTATUS;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("lammas");
        $this->setSource("permohonan_ruangan");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return PermohonanRuangan[]|PermohonanRuangan|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return PermohonanRuangan|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
