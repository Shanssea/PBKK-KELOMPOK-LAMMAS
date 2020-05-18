<?php

class Pc extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_pc;

    /**
     *
     * @var string
     */
    public $nama_pc;

    /**
     *
     * @var string
     */
    public $ip;

    /**
     *
     * @var string
     */
    public $hdd;

    /**
     *
     * @var string
     */
    public $ram;

    /**
     *
     * @var string
     */
    public $processor;

    /**
     *
     * @var string
     */
    public $gpu;

    /**
     *
     * @var string
     */
    public $status_pc;

    /**
     *
     * @var integer
     */
    public $pc_lab;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("lammas");
        $this->setSource("pc");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Pc[]|Pc|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Pc|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
