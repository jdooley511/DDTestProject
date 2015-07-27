<?php
class Ad {
    public $id;    
    
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
    public function __construct($id) {
        $this->id = $id;
    }   
    
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
    public function getTotalViews() {
        $schema = SCHEMA;
        $query = "SELECT SUM(Views) as totalviews FROM {$schema}.dailyads WHERE Ad_ID = :ad_id";
        $arg_array = Array ('ad_id'=> $this->id);
        $db = db_connect();
        $statement = $db->prepare($query);
        $statement->execute($arg_array);
        return $statement->fetch(PDO::FETCH_COLUMN);        
    }
    
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
    public function getTotalClicks() {
        $schema = SCHEMA;
        $query = "SELECT COUNT(*) as Count FROM {$schema}.lead WHERE Ad_ID = :ad_id";
        $arg_array = Array ('ad_id'=> $this->id);
        $db = db_connect();
        $statement = $db->prepare($query);
        $statement->execute($arg_array);
        return $statement->fetch(PDO::FETCH_COLUMN);        
    }
    
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
    public function getClickthroughRate() {
        $views = $this->getTotalViews();
        $clicks = $this->getTotalClicks();
        return round($clicks / $views * 100,2) . " %";
    }
    
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
    public function getConversions() {
        $schema = SCHEMA;
        $query = "SELECT COUNT(DISTINCT o.Lead_ID) as Count FROM {$schema}.orders o
                  INNER JOIN {$schema}.lead l ON o.lead_id = l.lead_id AND l.Deleted = 0
                  WHERE o.Deleted = 0 AND Ad_ID = :ad_id";
        $arg_array = Array ('ad_id'=> $this->id);
        $db = db_connect();
        $statement = $db->prepare($query);
        $statement->execute($arg_array);
        return $statement->fetch(PDO::FETCH_COLUMN);
    }
    
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
    public function getConversionRate() {
        $views = $this->getTotalViews();
        $conversions = $this->getConversions();
        return round($conversions / $views * 100,2) . " %";
    }
    
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
    public function getTotalRevenue() {
        $schema = SCHEMA;
        $query = "SELECT SUM(UnitPrice * Quantity + ShippingCost) as TotalRev FROM {$schema}.orders o
                  INNER JOIN {$schema}.lead l ON o.lead_id = l.lead_id AND l.Deleted = 0
                  WHERE o.Deleted = 0 AND Ad_ID = :ad_id";
        $arg_array = Array ('ad_id'=> $this->id);
        $db = db_connect();
        $statement = $db->prepare($query);
        $statement->execute($arg_array);
        return $statement->fetch(PDO::FETCH_COLUMN);
    }
    
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
    public function getAverageAge() {
        $schema = SCHEMA;
        $query = "SELECT AVG(TIMESTAMPDIFF(YEAR,BirthDate,CURDATE())) as Age "
               . "FROM {$schema}.lead WHERE Ad_ID = :ad_id AND Deleted = 0";
        $arg_array = Array ('ad_id'=> $this->id);
        $db = db_connect();
        $statement = $db->prepare($query);
        $statement->execute($arg_array);
        $average_age = $statement->fetch(PDO::FETCH_COLUMN);
        return round($average_age,2);         
    }
    
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
    public function getBestState() {
        $schema = SCHEMA;
        $query = "SELECT State FROM ddtest.orders o
                  INNER JOIN ddtest.lead l ON o.lead_id = l.lead_id AND l.Deleted = 0
                  WHERE o.Deleted = 0 AND Ad_ID = :ad_id
                  GROUP BY State
                  ORDER BY COUNT(State) DESC
                  LIMIT 1;";
        $arg_array = Array ('ad_id'=> $this->id);
        $db = db_connect();
        $statement = $db->prepare($query);
        $statement->execute($arg_array);
        return $statement->fetch(PDO::FETCH_COLUMN);
    }
    
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
    public function getWorstState() {
        $schema = SCHEMA;
        $query = "SELECT State FROM {$schema}.orders o
                  INNER JOIN ddtest.lead l ON o.lead_id = l.lead_id AND l.Deleted = 0
                  WHERE o.Deleted = 0 AND Ad_ID = :ad_id
                  GROUP BY State
                  ORDER BY COUNT(State)
                  LIMIT 1;";
        $arg_array = Array ('ad_id'=> $this->id);
        $db = db_connect();
        $statement = $db->prepare($query);
        $statement->execute($arg_array);
        return $statement->fetch(PDO::FETCH_COLUMN);
    }
    
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
    public static function getAdIDs() {
        $db = db_connect();
        $query = "SELECT DISTINCT Ad_ID FROM " . SCHEMA . ".dailyads WHERE Deleted = 0 ORDER BY Ad_ID;";
        $prep = $db->prepare($query);
        $prep->execute();
        $ad_ids = $prep->fetchAll(PDO::FETCH_COLUMN);
        return $ad_ids;
    }
    
    public static function getTableData() {
        $table_data = Array ();
        $ad_ids = Ad::getAdIDs();
        foreach ($ad_ids as $index => $this_ad_id) {
            $ad = new Ad($this_ad_id);
            $table_data['Ad ID'][$index] = $this_ad_id;
            $table_data['Total Views'][$index] = $ad->getTotalViews();
            $table_data['Click Through Rate %'][$index] = $ad->getClickthroughRate();
            $table_data['Conversion Rate %'][$index] = $ad->getConversionRate();
            $table_data['Total Revenue'][$index] = $ad->getTotalRevenue();
            $table_data['Average Customer Age'][$index] = $ad->getAverageAge();
            $table_data['Best State'][$index] = $ad->getBestState();
            $table_data['Worst State'][$index] = $ad->getWorstState();
            
        }
        return $table_data;
    }
    
    public static function outputAdTable() {
        $table_data = Ad::getTableData();
        $columns = array_keys($table_data);
        $output_html = "<table id='ads' name='ads'><thead><tr>";        

        foreach ($columns as $column) {
            $output_html .= '<th>' . $column . '</th>';
        }
        $output_html .= '</tr></thead><tbody>';
        $ad_ids = $table_data['Ad ID'];
        foreach ($ad_ids as $index => $this_ad_id) {
            $output_html .= '<tr>';
            foreach ($columns as $column) {
                $output_html .= '<td>' . $table_data[$column][$index] . '</td>';
            }
            $output_html .= '</tr>';
        }
        $output_html .= '</tbody></table>';
        return $output_html;
    }    
}

?>

