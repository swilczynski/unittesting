<?php

class VotersModel
{
    private $db;
    
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
    
    public function getByZipcode($zipCode)
    {
        $voters = array();
        
        $query = 'SELECT v.name
                    FROM voters v 
                        INNER JOIN regions r using(region_id) 
                        INNER JOIN zipcodes z using(region_id)
                    WHERE z.zipcode = :zipcode
                    AND allowed = 1
                    ORDER BY v.name ASC';
        
         $statement = $this->db->prepare($query);
        
         $statement->bindParam(':zipcode', $zipCode);
         $statement->execute();
        
         while(($row = $statement->fetch()) !== false)
         {
             $voters[] = $row['name'];
         }
        
         return $voters;
    }
    
    public function getBySsn($ssn)
    {
        $voters = array();
    
         $query = 'SELECT v.name FROM voters v WHERE v.ssn = :ssn';
    
         $statement = $this->db->prepare($query);
    
         $statement->bindParam(':ssn', $ssn);
         $statement->execute();
    
         while(($row = $statement->fetch()) !== false)
         {
             $voters[] = $row['name'];
         }

        return $voters;
    }
    
    public function add($voter)
    {
         $query = 'INSERT INTO voters(region_id, name, allowed, ssn) values (:region_id, :name, :allowed, :ssn)';
        
         $statement = $this->db->prepare($query);
        
         $statement->bindParam(':region_id', $voter['region_id']);
         $statement->bindParam(':name', $voter['name']);
         $statement->bindParam(':allowed', $voter['allowed']);
         $statement->bindParam(':ssn', $voter['ssn']);
        
         $statement->execute();
    }
}