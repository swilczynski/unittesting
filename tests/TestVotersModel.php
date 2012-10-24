<?php

require_once 'setup.php';
require_once 'model/VotersModel.php'; 

class TestVotersModel extends PHPUnit_Extensions_Database_TestCase
{
    /**
     * @var PDO
     */
    private $db;
    
    /**
     * @var VotersModel
     */
    private $votersModel;
    
    public function __construct()
    {
        $this->db = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, USER, PASSWORD);
        $this->votersModel = new VotersModel($this->db);
    }
    
    protected function getConnection()
    {
        $this->db->query('SET foreign_key_checks=0');
        
        return $this->createDefaultDBConnection($this->db, DBNAME);
    }
    
    protected function getDataSet()
    {
    	$dataSet = new PHPUnit_Extensions_Database_DataSet_CsvDataSet();
    	
    	$dataSet->addTable('regions', 'fixtures/regions.csv');
    	$dataSet->addTable('zipcodes', 'fixtures/zipcodes.csv');
    	$dataSet->addTable('voters', 'fixtures/voters.csv');
    	
        return $dataSet;
    }
    
    public function testGetByZipcode()
    {
        $expectedVoters = array('Jon', 'Mark');
        $actualVoters = $this->votersModel->getByZipcode('95101');
        
        $this->assertEquals($expectedVoters, $actualVoters);
    }
    
    public function testGetBySsn()
    {
         $expectedVoters = array('Sebastian');
         $actualVoters = $this->votersModel->getBySsn('003123344');
        
         $this->assertEquals($expectedVoters, $actualVoters);        
    }
    
    public function testAdd()
    {
        $voter = array
        (
            'region_id' => 2,
            'name' => 'Jack',
            'allowed' => 1,
            'ssn' => '002123123',
        );
        
        $this->votersModel->add($voter);
        
        $expectedVoters = array('Jack');
        $actualVoters = $this->votersModel->getBySsn('002123123');
        
        $this->assertEquals($expectedVoters, $actualVoters);
    }
}