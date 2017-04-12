<?php
?>
<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
$GLOBALS['title']="Cost-HMS";
$base_url="http://localhost/hms/";
$GLOBALS['output']='';
$GLOBALS['isData']="";
require('./../../inc/sessionManager.php');
require('./../../inc/dbPlayer.php');
require('./../../inc/handyCam.php');
$ses = new \sessionManager\sessionManager();
$ses->start();
$name=$ses->Get("name");
if($ses->isExpired())
{
    header( 'Location:'.$base_url.'login.php');


}
elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    
        header( 'Location: view.php');

}

    $name=$ses->Get("loginId");
    $msg="";
    $db = new \dbPlayer\dbPlayer();
    $msg = $db->open();

    if ($msg = "true") {
        $handyCam = new \handyCam\handyCam();
        $data = array();
        $result = $db->getData("SELECT * FROM cost");
        $GLOBALS['output']='';
        if(false===strpos((string)$result,"Can't"))
        {

            $GLOBALS['output'].='<div class="table-responsive">
                                <table id="paymentList" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>

                                            <th>Cost Type</th>
                                             <th>Amount</th>
                                            <th>Name</th>
                                             <th>Date</th>
                                              <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>';
            while ($row = mysql_fetch_array($result)) {
                $GLOBALS['isData']="1";
                $GLOBALS['output'] .= "<tr>";

                $GLOBALS['output'] .= "<td>" . $row['type'] . "</td>";
                $GLOBALS['output'] .= "<td>" . $row['amount'] . "</td>";

                $GLOBALS['output'] .= "<td>" . $row['description'] . "</td>";

                $GLOBALS['output'] .= "<td>" .$handyCam->getAppDate($row['date']). "</td>";
                $GLOBALS['output'] .= "<td><a title='Edit' class='btn btn-success btn-circle' href='edit.php?id=" . $row['serial'] ."&wtd=edit'"."><i class='fa fa-pencil'></i></a>&nbsp&nbsp<a title='Delete' class='btn btn-danger btn-circle' href='edit.php?id=" . $row['serial'] ."&wtd=delete'"."><i class='fa fa-trash-o'></i></a></td>";
                $GLOBALS['output'] .= "</tr>";

            }

            $GLOBALS['output'].=  '</tbody>
                                </table>
                            </div>';


        }
        else
        {
            echo '<script type="text/javascript"> alert("' . $result . '");</script>';
        }
    } else {
        echo '<script type="text/javascript"> alert("' . $msg . '");</script>';
    }

function LoadData($db)
{
    $msg= $db->open();
    $query = "SELECT * FROM cost";
    $result = $db->execDataTable($query);
    $paydata = array();
    $handyCam = new \handyCam\handyCam();
    while ($row = mysql_fetch_array($result)) {

        $rowd=array();

        array_push($rowd,$row["type"]);
        array_push($rowd,$row["amount"]);
        array_push($rowd,$row["description"]);
        array_push($rowd,$handyCam->getAppDate($row["date"]));
        array_push($paydata,$rowd);

    }

    return $paydata;
}
?>
<?php include('./../../master.php'); ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>Cost View</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-info-circle fa-fw"></i> Hostel Fine List View
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    
                    <div class="row">
                        <div class="col-lg-12">
                            <hr />
                            <?php if($GLOBALS['isData']=="1"){echo $GLOBALS['output'];}?>
                        </div>
                    </div>


                </div>
                <!-- /.panel-body -->
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>

</div>
<!-- /#page-wrapper -->


<?php include('./../../footer.php'); ?>
<script type="text/javascript">
    $( document ).ready(function() {



        $('#paymentList').dataTable();
    });




</script>
