<?php

/* * **c* Ad
 * NAME
 * Ad
 * SYNOPSIS
 * $ad = new Ad($id)
 * AUTHOR
 * jdooley
 * FUNCTION
 *
 * ATTRIBUTES
 *
 * NOTES
 *
 * ** */
class Ad {
    public $id;

   /****m* Ad/__construct
    * NAME
    * __construct
    * SYNOPSIS
    * $ad = new Ad($ad_id)
    * FUNCTION
    * Instantiates an Ad Object
    * INPUTS
    * $id - Ad ID of the Ad
    * RETURN VALUE
    * Null
    * ERRORS
    *
    * EXAMPLE
    * $ad = new Ad($ad_id)
    * NOTES
    *
    * SEE ALSO
    *
    ****/
    public function __construct($id) {
        $this->id = $id;
    }

    /****m* Ad/getTotalViews
    * NAME
    * getTotalViews
    * SYNOPSIS
    * $views = $this->getTotalViews();
    * FUNCTION
    * Determines the total number of times that an Ad has been viewed
    * INPUTS
    * 
    * RETURN VALUE
    * INT
    * ERRORS
    * 
    * EXAMPLE
    * $views = $this->getTotalViews();
    * NOTES
    *
    * SEE ALSO
    *
    ****/
    public function getTotalViews() {
        $schema = SCHEMA;
        $query = "SELECT SUM(Views) as totalviews FROM {$schema}.dailyads WHERE Ad_ID = :ad_id AND Deleted = 0";
        $arg_array = Array ('ad_id'=> $this->id);
        $db = db_connect();
        $statement = $db->prepare($query);
        $statement->execute($arg_array);
        return $statement->fetch(PDO::FETCH_COLUMN);
    }

    /****m* Ad/getTotalClicks
    * NAME
    * getTotalViews
    * SYNOPSIS
    * $clicks = $this->getTotalClicks();
    * FUNCTION
    * Determines the total number of times that an Ad has been clicked
    * INPUTS
    * 
    * RETURN VALUE
    * INT
    * ERRORS
    * 
    * EXAMPLE
    * $clicks = $this->getTotalClicks();
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

    /****m* Ad/getClickthroughRate
    * NAME
    * getClickthroughRate
    * SYNOPSIS
    * $click_rate = $this->getClickthroughRate();
    * FUNCTION
    * Determines the Click Through Rate for an Ad.
    * The "click-through rate" of an ad is the number of leads who clicked it divided
    * by the number of times the ad was viewed.
    * INPUTS
    * 
    * RETURN VALUE
    * Decimal
    * ERRORS
    * 
    * EXAMPLE
    * $click_rate = $this->getClickthroughRate();
    * NOTES
    *
    * SEE ALSO
    *
    ****/
    public function getClickthroughRate() {
        $views = $this->getTotalViews();
        $clicks = $this->getTotalClicks();
        return number_format($clicks / $views * 100,3) . " %";
    }

    /****m* Ad/getConversions
    * NAME
    * getConversions
    * SYNOPSIS
    * $conversions = $this->getConversions();
    * FUNCTION
    * Determines the total number of conversions for this ad
    * A "conversion" is a sale.  An ad "converts" whenever a lead makes at least one 
    * purchase after viewing it.  If a lead makes more than one purchase after viewing
    * the ad, it still only counts as one conversion. 
    * INPUTS
    * 
    * RETURN VALUE
    * INT
    * ERRORS
    * 
    * EXAMPLE
    * $conversions = $this->getConversions();
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

    /****m* Ad/getConversionRate
    * NAME
    * getConversionRate
    * SYNOPSIS
    * $conversion_rate = $this->getConversionRate();
    * FUNCTION
    * Determines the conversion rate for this ad.
    * The "conversion rate" for an ad is the number of its conversions divided by the
    * number of times it was viewed.    
    * INPUTS
    * 
    * RETURN VALUE
    * DECIMAL
    * ERRORS
    * 
    * EXAMPLE
    * $conversion_rate = $thisgetConversionRategetTotalClicks();
    * NOTES
    *
    * SEE ALSO
    *
    ****/
    public function getConversionRate() {
        $views = $this->getTotalViews();
        $conversions = $this->getConversions();
        return number_format($conversions / $views * 100,3) . " %";
    }

    /****m* Ad/getTotalRevenue
    * NAME
    * getTotalRevenue
    * SYNOPSIS
    * $revenue = $this->getTotalRevenue();
    * FUNCTION
    * Determines the total revenue for this Ad
    * INPUTS
    * 
    * RETURN VALUE
    * Decimal
    * ERRORS
    * 
    * EXAMPLE
    * $revenue = $this->getTotalRevenue();
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

    /****m* Ad/getAverageAge
    * NAME
    * getAverageAge
    * SYNOPSIS
    * $age = $this->getAverageAge();
    * FUNCTION
    * Determines average customer age for leads that clicked an ad.
    * Age is determined at the time the Ad was clicked.
    * INPUTS
    * 
    * RETURN VALUE
    * Decimal
    * ERRORS
    * 
    * EXAMPLE
    * $clicks = $this->getTotalClicks();
    * NOTES
    *
    * SEE ALSO
    *
    ****/
    public function getAverageAge() {
        $schema = SCHEMA;
        $query = "SELECT AVG(TIMESTAMPDIFF(YEAR,BirthDate,CreatedAt)) as Age "
               . "FROM {$schema}.lead WHERE Ad_ID = :ad_id AND Deleted = 0";
        $arg_array = Array ('ad_id'=> $this->id);
        $db = db_connect();
        $statement = $db->prepare($query);
        $statement->execute($arg_array);
        $average_age = $statement->fetch(PDO::FETCH_COLUMN);
        return number_format($average_age,2);
    }

    /****m* Ad/getBestState
    * NAME
    * getTotalViews
    * SYNOPSIS
    * $clicks = $this->getBestState();
    * FUNCTION
    * Determines the best state (in terms of number of conversions) for this Ad
    * INPUTS
    * 
    * RETURN VALUE
    * String
    * ERRORS
    * 
    * EXAMPLE
    * $clicks = $this->getBestState();
    * NOTES
    * If there are multiple 'best states', only one will be chosen
    * SEE ALSO
    *
    ****/
    public function getBestState() {
        $schema = SCHEMA;
        $query = "SELECT State FROM {$schema}.orders o
                  INNER JOIN {$schema}.lead l ON o.lead_id = l.lead_id AND l.Deleted = 0
                  WHERE o.Deleted = 0 AND Ad_ID = :ad_id
                  GROUP BY State
                  ORDER BY COUNT(DISTINCT o.Lead_ID) DESC, SUM(UnitPrice * Quantity + ShippingCost) DESC
                  LIMIT 1;";
        $arg_array = Array ('ad_id'=> $this->id);
        $db = db_connect();
        $statement = $db->prepare($query);
        $statement->execute($arg_array);
        return $statement->fetch(PDO::FETCH_COLUMN);
    }

    /****m* Ad/getWorstState
    * NAME
    * getWorstState
    * SYNOPSIS
    * $clicks = $this->getWorstState();
    * FUNCTION
    * Determines the worst state (in terms of number of conversions) for this Ad
    * INPUTS
    * 
    * RETURN VALUE
    * String
    * ERRORS
    * 
    * EXAMPLE
    * $clicks = $this->getWorstState();
    * NOTES
    * If there are multiple 'worst states', only one will be chosen
    * SEE ALSO
    *
    ****/
    public function getWorstState() {
        $schema = SCHEMA;
        $query = "SELECT State FROM {$schema}.orders o
                  INNER JOIN {$schema}.lead l ON o.lead_id = l.lead_id AND l.Deleted = 0
                  WHERE o.Deleted = 0 AND Ad_ID = :ad_id
                  GROUP BY State
                  ORDER BY COUNT(DISTINCT o.Lead_ID), SUM(UnitPrice * Quantity + ShippingCost)
                  LIMIT 1;";
        $arg_array = Array ('ad_id'=> $this->id);
        $db = db_connect();
        $statement = $db->prepare($query);
        $statement->execute($arg_array);
        return $statement->fetch(PDO::FETCH_COLUMN);
    }

    /****f* Ad/getAdIDs
    * NAME
    * getAdIDs
    * SYNOPSIS
    * $ad_ids = Ad::getAdIDs();
    * FUNCTION
    * Returns an array of unique ad ids
    * INPUTS
    * 
    * RETURN VALUE
    * Array
    * ERRORS
    * 
    * EXAMPLE
    * $ad_ids = Ad::getAdIDs();
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

    /****f* Ad/getTableData
    * NAME
    * getTableData
    * SYNOPSIS
    * $table_data = Ad::getTableData();
    * FUNCTION
    * Generates table data that is used by outputAdTable
    * INPUTS
    * 
    * RETURN VALUE
    * Array
    * ERRORS
    * 
    * EXAMPLE
    * $table_data = Ad::getTableData();
    * NOTES
    *
    * SEE ALSO
    *
    ****/
    public static function getTableData() {
        $table_data = Array ();
        $ad_ids = Ad::getAdIDs();
        foreach ($ad_ids as $index => $this_ad_id) {
            $ad = new Ad($this_ad_id);
            $table_data[$index]['Ad ID'] = $this_ad_id;
            $table_data[$index]['Total Views'] = $ad->getTotalViews();
            $table_data[$index]['Click Through Rate %'] = $ad->getClickthroughRate();
            $table_data[$index]['Conversion Rate %'] = $ad->getConversionRate();
            $table_data[$index]['Total Revenue'] = $ad->getTotalRevenue();
            $table_data[$index]['Average Customer Age'] = $ad->getAverageAge();
            $table_data[$index]['Best State'] = $ad->getBestState();
            $table_data[$index]['Worst State'] = $ad->getWorstState();
        }
        usort($table_data,"table_sort_helper");
        return $table_data;
    }

    /****f* Ad/outputAdTable
    * NAME
    * outputAdTable
    * SYNOPSIS
    * $add_table_html = Ad::outputAdTable();
    * FUNCTION
    * Returns the HTML that generates the output ad table
    * INPUTS
    * 
    * RETURN VALUE
    * String
    * ERRORS
    * 
    * EXAMPLE
    * $add_table_html = Ad::outputAdTable();
    * NOTES
    *
    * SEE ALSO
    *
    ****/
    public static function outputAdTable() {
        $table_data = Ad::getTableData();
        $columns = array_keys($table_data[0]);
        $output_html = "<table id='ads' name='ads'><thead><tr>";

        foreach ($columns as $column) {
            $output_html .= '<th>' . $column . '</th>';
        }
        $output_html .= '</tr></thead><tbody>';
        
        foreach ($table_data as $index => $this_row) {
            $output_html .= '<tr>';
            foreach ($this_row as $column_key => $column_val) {
                $output_html .= '<td>' . $column_val . '</td>';
            }
            $output_html .= '</tr>';
        }
        $output_html .= '</tbody></table>';
        return $output_html;
    }
}
?>