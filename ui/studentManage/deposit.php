<?php

$GLOBALS['title']="Deposit-HMS";
$base_url="http://localhost/hms/";

require('./../../inc/sessionManager.php');
require('./../../inc/dbPlayer.php');
require('./../../inc/fpdf.php');

$ses = new \sessionManager\sessionManager();
$ses->start();
$GLOBALS['isData1']="";
if($ses->isExpired())
{
    header( 'Location:'.$base_url.'login.php');


}
else
{
    $name=$ses->Get("loginId");
    $msg="";
    $db = new \dbPlayer\dbPlayer();
    $msg = $db->open();

    //load student list
    $data = array();
    $query = "SELECT userId,name FROM studentinfo  where isActive='Y' and userId NOT IN(SELECT userId from deposit)";
    $result = mysql_query($query);
    $GLOBALS['output']='';
    if(false===strpos((string)$result,"Can't"))
    {
        while ($row = mysql_fetch_array($result)) {
            $GLOBALS['isData']="1";
            $GLOBALS['output'] .= '<option value="'.$row['userId'].'">'.$row['name'].'</option>';

        }




    }

    else
    {
        echo '<script type="text/javascript"> alert("' . $result . '");</script>';
    }

    getData();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST["btnSave"])) {

            $db = new \dbPlayer\dbPlayer();
            $msg = $db->open();

            if ($msg = "true") {


                $data = array(
                    'userId' => $_POST['person'],
                    'amount' => floatval($_POST['amount']),
                    'depositDate' =>date("Y-m-d")


                );
                $result = $db->insertData("deposit",$data);
                $query = "SELECT userId,name FROM studentinfo  where isActive='Y' and userId NOT IN(SELECT userId from deposit)";
    $results = mysql_query($query);
    $GLOBALS['output']='';
    if(false===strpos((string)$results,"Can't"))
    {
        while ($row = mysql_fetch_array($results)) {
            $GLOBALS['isData']="1";
            $GLOBALS['output'] .= '<option value="'.$row['userId'].'">'.$row['name'].'</option>';

        }




    }

                if($result>=0)
                {

                    echo '<script type="text/javascript"> alert("Money Deposit Successfull.");</script>';
                    getData();
                }
                else
                {
                    echo '<script type="text/javascript"> alert("' . $result . '");</script>';
                }

            }
            elseif(strpos($result,'Duplicate') !== false)
            {
                echo '<script type="text/javascript"> alert("Deposit Already Exits!");</script>';
            }
            else
            {
                echo '<script type="text/javascript"> alert("' . $result . '");</script>';
            }
        }
        elseif (isset($_POST["btnPrint"])) {

            $db = new \dbPlayer\dbPlayer();
            printData($db);
        }
        else
        {
            header( 'Location: deposit.php');
        }
    }


}
function getData()
{
    $db = new \dbPlayer\dbPlayer();
    $msg = $db->open();

    if ($msg = "true") {

        $data = array();
        $result = $db->getData("SELECT a.serial,b.name,a.amount,DATE_FORMAT(a.depositDate, '%D %M,%Y') as date from deposit as a, studentinfo as b where a.userId = b.userId and b.isActive='Y'");
        $GLOBALS['output1']='';
        if(false===strpos((string)$result,"Can't"))
        {

            $GLOBALS['output1'].='<div class="table-responsive">
                                <table id="depositList" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>

                                            <th>Name</th>
                                            <th>Amount</th>
                                            <th>Deposit Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
            while ($row = mysql_fetch_array($result)) {
                $GLOBALS['isData1']="1";
                $GLOBALS['output1'] .= "<tr>";

                $GLOBALS['output1'] .= "<td>" . $row['name'] . "</td>";
                $GLOBALS['output1'] .= "<td>" . $row['amount'] . "</td>";
                $GLOBALS['output1'] .= "<td>" . $row['date'] . "</td>";
                $GLOBALS['output1'] .= "<td><a title='Edit' class='btn btn-success btn-circle' href='depositaction.php?id=" . $row['serial'] ."&wtd=edit'"."><i class='fa fa-pencil'></i></a>&nbsp&nbsp<a title='Delete' class='btn btn-danger btn-circle' href='depositaction.php?id=" . $row['serial'] ."&wtd=delete'"."><i class='fa fa-trash-o'></i></a></td>";
                $GLOBALS['output1'] .= "</tr>";

            }

            $GLOBALS['output1'].=  '</tbody>
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

}


function LoadData($db,$userId)
{
    $query = "SELECT a.serial,b.name,a.amount,DATE_FORMAT(a.depositDate, '%D %M,%Y') as date from deposit as a, studentinfo as b where a.userId = b.userId and b.isActive='Y'";
    $result = $db->execDataTable($query);
    $paydata = array();

    while ($row = mysql_fetch_array($result)) {

        $rowd=array();

        array_push($rowd,$row["name"]);
        array_push($rowd,$row["amount"]);
        array_push($rowd,$row["date"]);
        array_push($paydata,$rowd);

    }

    return $paydata;
}
?>
<?php include('./../../master.php'); ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>Deposit</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-info-circle fa-fw"></i>Meal Money Deposit
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                    <div class="col-lg-12">
                    <form name="deposit" action="deposit.php"  accept-charset="utf-8" method="post" enctype="multipart/form-data">


                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Student Name</label>
                                        <select class="form-control" name="person" required="">
                                            <?php echo $GLOBALS['output'];?>

                                        </select>
                                    </div>
                                </div>


                                <div class="col-lg-4">
                                    <div class="form-group ">
                                        <label>Amount</label>
                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="fa fa-info"></i> </span>
                                            <input type="text" placeholder="Amount" class="form-control" name="amount" required>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>




                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-5"></div>
                                <div class="col-lg-2">
                                    <div class="form-group ">
                                        <button type="submit" class="btn btn-success" name="btnSave" ><i class="fa fa-2x fa-check"></i>Save</button>
                                    </div>

                                </div>
                                <div class="col-lg-5">
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
                    
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <hr />
                            <?php if($GLOBALS['isData1']=="1"){echo $GLOBALS['output1'];}?>
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
        $('#depositList').dataTable();


    });



</script>
