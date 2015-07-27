<?php

   /****c* Lead
    * NAME
    * Lead
    * SYNOPSIS
    * $lead = new Lead($lead_id)
    * AUTHOR
    * jdooley
    * FUNCTION
    *
    * ATTRIBUTES
    *
    * NOTES
    *
    ****/

class Lead {

    public $id;
    public $table;
    public $schema;

   /****m* Lead/__construct
    * NAME
    * __construct
    * SYNOPSIS
    * $lead = new Lead($lead_id)
    * FUNCTION
    * Instantiates a Lead Object
    * INPUTS
    * $lead_id - Lead ID of the Lead
    * RETURN VALUE
    * Null
    * ERRORS
    * Exception if the Lead doesn't exist or is not valid
    * EXAMPLE
    * $lead = new Lead($lead_id);
    * NOTES
    *
    * SEE ALSO
    *
    ****/
    public function __construct($id = null) {
        if(!is_numeric($id) || empty($id)) {
            throw new Exception('Invalid Lead: ['.$id.']');
        }        

        //make sure it exists
        if(!empty($id)) {
            $db = db_connect();
            $query = "SELECT COUNT(*) as count FROM ".SCHEMA.".lead WHERE Lead_ID=:lead_id AND Deleted=0";
            $prep_query = $db->prepare($query);
            $arg_array = Array ('lead_id' => $id);
            $prep_query->execute($arg_array);
            $count = $prep_query->fetch(PDO::FETCH_COLUMN);
            if($count != 1) {
                throw new Exception("Error: no Lead found for ID [$id]");
            }
        }
        $this->schema = SCHEMA;
        $this->table = 'lead';
        $this->id = $id;
    }
}
?>
