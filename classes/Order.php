<?php

   /****c* Order
    * NAME
    * Order
    * SYNOPSIS
    * $lead = new Order($order_id)
    * AUTHOR
    * jdooley
    * FUNCTION
    *
    * ATTRIBUTES
    *
    * NOTES
    *
    ****/

class Order {

    public $id;
    public $table;
    public $schema;

   /****m* Order/__construct
    * NAME
    * __construct
    * SYNOPSIS
    * $lead = new Order($order_id)
    * FUNCTION
    * Instantiates a Order Object
    * INPUTS
    * $order_id - Order ID of the Order
    * RETURN VALUE
    * Null
    * ERRORS
    * Exception if the Order doesn't exist or is not valid
    * EXAMPLE
    * $lead = new Order($order_id);
    * NOTES
    *
    * SEE ALSO
    *
    ****/
    public function __construct($id = null) {
        if(!is_numeric($id) || empty($id)) {
            throw new Exception('Invalid Order: ['.$id.']');
        }        

        //make sure it exists
        if(!empty($id)) {
            $db = db_connect();
            $query = "SELECT COUNT(*) as count FROM ".SCHEMA.".orders WHERE Orders_ID=:orders_id AND Deleted=0";
            $prep_query = $db->prepare($query);
            $arg_array = Array ('orders_id' => $id);
            $prep_query->execute($arg_array);
            $count = $prep_query->fetch(PDO::FETCH_COLUMN);
            if($count != 1) {
                throw new Exception("Error: no Order found for ID [$id]");
            }
        }
        $this->schema = SCHEMA;
        $this->table = 'orders';
        $this->id = $id;
    }
}
?>