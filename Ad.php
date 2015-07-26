<?php
class Ad {
    
    public function __construct($id) {
        // Construct Ad Object
    }   
    
    public function getTotalViews() {
        
    }
    
    public function getClickthroughRate() {
        
    }
    
    public function getConversionRate() {
        
    }
    
    public function getTotalRevenue() {
        
    }
    
    public function getAverageAge() {
        
    }
    
    public function getBestState() {
        
    }
    
    public function getWorstState() {
        
    }
    
    // Return list of Ad IDs
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
            $table_data['Total Views'][$index] = $this_ad_id;
            $table_data['Click Through Rate %'][$index] = $this_ad_id;
            $table_data['Conversion Rate %'][$index] = $this_ad_id;
            $table_data['Total Revenue'][$index] = $this_ad_id;
            $table_data['Average Customer Age'][$index] = $this_ad_id;
            $table_data['Best State'][$index] = $this_ad_id;
            $table_data['Worst State'][$index] = $this_ad_id;
            
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

