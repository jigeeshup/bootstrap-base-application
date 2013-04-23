<?php
/**
 * Class creating datagrid.
 *
 * @author  joesama <joharijumali@gmail.com>
 */
class Datagrid
{
    /**
     * Create a table of data.
     * @param  object  $data content of the daagrid.
     * @return string Complete datagrid.
     */


    /** 
    * declaration for container attributes
    * @param string $containerId - predefine id for datagrid  created
    * @param string $containerClass - predefine class for datagrid created
    */

    var $container = ''; 
    var $containerId = 'dgCont';
    var $containerClass = ''; 

    /** 
    * declaration for table attributes
    * @param string $tableId - predefine id for table created
    * @param string $tableClass - predefine class for table created
    * @param array $rowsFields - define field for
    * @param array $rowsDesc - define header descriptions
    * @param array $queryData - data from model
    */

    var $tableId = 'dgTable';
    var $tableClass = ''; 
    var $rowsFields = array();
    var $rowsDesc = array();

    var $rowsAttributes = '';

    var $queryData = array();
    var $actionAttributes = array();

    var $hasAction = false;
    var $hasAjax = false;
    var $hasNumbering = true;

    var $primaryKey = '';



    public function build($query,$primaryKey)
    {
        $this->primaryKey = $primaryKey;
        $this->queryData = $query;   

    }

    public function setContainer($id,$class){

        $this->containerId = $id;
        $this->containerClass = $class;
    }


    public function setTable($id,$class){

        $this->tableId = $id;
        $this->tableClass = $class;
    }

    public function setFields(Array $rows , Array $attributes = array()){

        foreach($rows as $fields => $desc){
            $this->rowsFields[]=$fields;
            $this->rowsDesc[]=$desc;
        }

        if(!empty($attributes)){
            $this->setAttributes($attributes);
        }else{
            $this->rowsAttributes = '';
        }      
    }


    public function setAction($type,$target,$ajax=false,$param=array(),$selector="onclick"){

        $this->hasAction = true;

        if($ajax == true){
            // $this->hasAjax  = true;
            $this->actionAttributes[$type] = array('type'=>$type,'function'=>$target,'ajax'=>true,'param'=>$param,'selector'=>$selector);
        }else{
            $this->actionAttributes[$type] = array('type'=>$type,'target'=>$target,'param'=>$param);
        }
    }

    public function showNumbering($no){
        $this->hasNumbering = $no;
    }


    protected function setAttributes(Array $attributes){

        foreach ($attributes as $key => $value) {
            $this->rowsAttributes = $key.'='.$value.'&nbsp;';
        }

        
    }

    // creating table container
    protected function createContainers(){

        $container = "<div id='".$this->containerId."' class='".$this->containerClass."' >";
        $container .= $this->createContents();
        $container .= "</div>"; 

        $this->container = $container;
    }

    // creating table content
    protected function createContents(){

        $table = "<table id='".$this->tableId."' class='".$this->tableClass."'>";
        $table .=$this->createHeader();
        $table .=$this->createFields();
        $table .="</table>";

        return $table;

    }

    // creating table header
    protected function createHeader(){

        $header = "<thead>";
        $header .= "<tr>";
        $header .= $this->rowHeader();
        $header .= "</tr>";
        $header .= "</thead>";

        return $header;
    }

    // assign value to row header
    protected function rowHeader(){

        $row = "";

        if($this->hasNumbering == true){
            $row .= "<th style ='width:10px;text-align:center;background-color: #F5F5F5;' ><strong>#</strong></th>";
        }

        foreach ($this->rowsDesc as $value) {
            $row .= "<th ".$this->rowsAttributes.">";
            $row .= $value;
            $row .= "</th>";
        }

        if($this->hasAction && !empty($this->queryData)){
            $row .= "<th style ='width:100px;text-align:center' ".$this->rowsAttributes.">Actions</th>";
        }

        return $row;
    }
    

    // creating body table
    protected function createFields(){

        $key = $this->primaryKey;

        $body = "<tbody>";
        $num = 1;

        if(!empty($this->queryData)){

            foreach($this->queryData as $qValue){
                $body .= "<tr id=\"".$qValue->$key."\">";

                if($this->hasNumbering == true){
                    $body .= "<td style='width:10px;text-align:center;background-color: #F5F5F5;' >".$num."</td>";
                }

                $body .= $this->rowFields($qValue);
                $body .= "</tr>";

                $num++;
            }

        }else{
            $body .= "<tr>";
            $body .= "<td colspan=\"".count($this->rowsDesc)."\" style=\"text-align:center\">No Data</td>";
            $body .= "</tr>";
        }

        $body .= "</tbody>";

        return $body;
    }

    // assign value to row table
    protected function rowFields($data){

        $row = "";

        foreach ($this->rowsFields as $value) {

            $row .= "<td ".$this->rowsAttributes.">";

            if(strrpos($value, "/")){
                
                $foo = explode("/", $value);
                 $countfoo = count($foo);

                 $row .= ($countfoo == 2)?$data->$foo[0]->$foo[1]:'';
                 $row .= ($countfoo == 3)?$data->$foo[0]->$foo[1]->$foo[2]:'';
                 $row .= ($countfoo == 4)?$data->$foo[0]->$foo[1]->$foo[2]->$foo[3]:'';

            }else{
                $row .= $data->$value;
            }

            $row .= "</td>";
        }  

        if($this->hasAction){
            $row .= "<td style ='width:100px;text-align:center'".$this->rowsAttributes.">";
            foreach ($this->actionAttributes as $value) {
                $row .= $this->actionTaken($value,$data);
                $row .= "&nbsp;&nbsp;";
            }  
            $row .= "</td>";
        }
        
        return $row;
    }

    protected function actionTaken($attr,$data){
        
        $params = '';
        $key = $this->primaryKey;

        // echo "<pre>";print_r($attr);

        if(isset($attr['ajax'])){
            $i = 1;
            foreach ($attr['param'] as $value) {
                $params .= "'".$data->$value."'";
                $params .= ($i < count($attr['param']))?',':'';
                $i++; 
            }

            $action = "<a href=\"#\" onclick=\"".$attr['function']."(".$params.")\" >".ucwords($attr['type'])."</a>";// ".$selector."=".$target" 
        }else{

            $url = $attr['target'].'/'.$data->$key;

            if(isset($attr['param'])){
               
                if(is_array($attr['param'])){
                    $i = 1;
                    foreach ($attr['param'] as $att => $value) {
                        $params .= $att."='".$value."'";
                        $url = ($value == 'modal')? $attr['target']:$url;
                        $i++; 
                    }
                }else{
                    $params = '';
                }
            }

            $action = "<a href=\"{$url}\"  ".$params.">".ucwords($attr['type'])."</a>";
        }

        return $action;
    }

    public function render(){

        $this->createContainers(); 
        return $this->container;
    }

}