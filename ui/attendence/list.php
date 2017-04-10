<?php
/**
 * Created by PhpStorm.
 * User: lmx
 * Date: 2/26/2015
 * Time: 12:27 PM
 */

$GLOBALS['title']="Attendence-HMS";
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
else
{


    if (isset($_GET['id']) && $_GET['wtd']) {

        $GLOBALS['serial']=$_GET['id'];

        $db = new \dbPlayer\dbPlayer();
        $msg = $db->open();
        if($_GET['wtd']==="delete")
        {
            if ($msg = "true") {


                $result = $db->delete("delete from attendence where serial='".$GLOBALS['serial']."'");

                if(false===strpos((string)$result,"Can't"))
                {
                    echo '<script type="text/javascript"> alert("Attendence Deleted Successfully.");
                                window.location.href = "list.php";
                        </script>';
                }
                else
                {
                    echo '<script type="text/javascript"> alert("' . $result . '");window.location.href = "list.php";</script>';
                }
            } else {
                echo '<script type="text/javascript"> alert("' . $msg . '");window.location.href = "list.php";</script>';
            }

        }
        else
        {
            header("location: view.php");

        }

    }
    elseif(isset($_GET['update']))
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $_GET['update']=="1") {

            if (isset($_POST["btnUpdate"])) {

                if($ses->Get("serial")!==NULL) {
                    $serialFor = $ses->Get("serial");
                    $db = new \dbPlayer\dbPlayer();
                    $msg = $db->open();
                    if ($msg = "true") {

                        $handyCam = new \handyCam\handyCam();
                        $data = array(


                            'isAbsence' => $_POST['isabs'],
                            'isLeave' => $_POST['isLeave'],
                            'remark' => $_POST['remark'],

                        );

                        $result = $db->updateData("attendence", "serial", $serialFor, $data);
                        // var_dump($result);
                        if ($result === "true") {

                            //  $db->close();
                            echo '<script type="text/javascript"> alert("Attendence Updated Successfully.");
                                window.location.href = "list.php";
                        </script>';
                            // header("location: block.php");

                        } else {
                            echo '<script type="text/javascript"> alert("' . $result . '");</window.location.href = "list.php";script>';
                        }
                    } else {
                        echo '<script type="text/javascript"> alert("' . $msg . '");window.location.href = "list.php";</script>';
                    }
                }
                else
                {
                    echo '<script type="text/javascript"> alert("Please Select attendence from below table!!!");window.location.href = "list.php";</script>';
                }

                $ses->remove("serial");
            }

        }
    }


        $name=$ses->Get("loginId");
        $msg="";
        $db = new \dbPlayer\dbPlayer();
        $msg = $db->open();


        if ($msg = "true") {
            $handyCam = new \handyCam\handyCam();
            $data = array();
            $result = $db->getData("SELECT a.serial,b.name,a.date,a.isAbsence ,a.isLeave,a.remark FROM attendence as a,studentinfo as b where a.userId=b.userId and b.isActive='Y'");
            $GLOBALS['output']='';
            if(false===strpos((string)$result,"Can't"))
            {

                $GLOBALS['output'].='<div class="table-responsive">
                                <table id="attendenceList" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>

                                            <th>Name</th>
                                             
                                             <th>Is Absence</th>
                                             <th>Is Leave</th>
                                             <th>Attendance</th>

                                        </tr>
                                    </thead>
                                    <tbody>';
                while ($row = mysql_fetch_array($result)) {
                    $GLOBALS['isData']="1";
                    $GLOBALS['output'] .= "<tr>";

                    $GLOBALS['output'] .= "<td>" . $row['name'] . "</td>";
                  

                    $GLOBALS['output'] .= "<td>" . $row['isAbsence'] ."</td>";
                    $GLOBALS['output'] .= "<td>" . $row['isLeave'] . "</td>";
                    $GLOBALS['output'] .= "<td>" . $row['remark'] . "</td>";

                   

                }

                $GLOBALS['output'].=  '</tbody>
                                </table>
                            </div>';


            }
            else
            {
                echo '<script type="text/javascript"> alert("' . $result . '");window.location="list.php";</script>';
            }
        } else {
            echo '<script type="text/javascript"> alert("' . $msg . '");window.location="list.php";</script>';
        }




}

?>
<?php include('./../../master.php'); ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>Attendence List</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-info-circle fa-fw"></i><i class="fa fa-hand-o-right"></i> Student Attendence List
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">


                    <div class="row">
                        <div class="col-lg-12">
                            <hr />
                            
                           
                            <?php if($GLOBALS['isData']=="1"){echo $GLOBALS['output'];}
                             else
                             {
                                 echo "<h1 class='text-warning'>Attendance Data Not Found!!!</h1>";
                             }
                            ?>
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
        $('.datepicker').datepicker();
        $('#attendenceList').dataTable();

        $('.editBtn').on('click', function(){

           var serial=$(this).attr('href').substring(1);
           var name=$(this).closest("tr").find("td").eq('0').text();


            $("#name").val(name);
            $('#attendDate').val($(this).closest("tr").find("td").eq('1').text());
            $('#abs').val($(this).closest("tr").find("td").eq('2').text());
            $('#leave').val($(this).closest("tr").find("td").eq('3').text());
            $('#remark').val($(this).closest("tr").find("td").eq('4').text());
            $('#updates').val($(this).closest("tr").find("td").eq('5').text());

            $.ajax({
                type: 'POST',
                url: '/hms/sesboss.php',
                data: {'serial': serial},
                success: function (msg) {
                   // alert(msg);
                },
                error: function (err){
                    console.log(err);
                    alert('Error');
                }
            });

        });
    });




</script>

<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>

</body>
</html>
