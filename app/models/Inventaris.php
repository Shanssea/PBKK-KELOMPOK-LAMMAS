<?php

class Inventaris extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_inv;

    /**
     *
     * @var string
     */
    public $nama_inv;

    /**
     *
     * @var string
     */
    public $status_inv;

    /**
     *
     * @var integer
     */
    public $id_lab;


    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("lammas");
        $this->setSource("inventaris");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Inventaris[]|Inventaris|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Inventaris|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
