<?php

$GLOBALS['title']="Admission-HMS";
$base_url="http://localhost/hms/";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
require('./../../inc/sessionManager.php');
require('./../../inc/dbPlayer.php');
require('./../../inc/fileUploader.php');
require('./../../inc/handyCam.php');
$ses = new \sessionManager\sessionManager();
$ses->start();
if($ses->isExpired())
{
    header( 'Location:'.$base_url.'login.php');


}
else
{
    $name=$ses->Get("loginId");


}


$msg="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["btnSave"])) {

        $db = new \dbPlayer\dbPlayer();
        $msg = $db->open();
        //echo '<script type="text/javascript"> alert("'.$msg.'");</script>';
        if ($msg = "true") {
            $userIds = $db->getAutoId("U");
            $flup = new fileUploader\fileUploader();
            //$perPhoto = $flup->upload("/hms/files/photos/",$_FILES['perPhoto'], $userIds[1]);
           // var_dump($perPhoto);
            $handyCam=new \handyCam\handyCam();
           //if (strpos($perPhoto, 'Error:') === false) {
                $dateNow=date("Y-m-d");
                $data = array(
                    'userId' => $userIds[1],
                    'userGroupId' => "UG004",
                    'name' => $_POST['name'],
                    'studentId' => $_POST['studentId'],
                    'cellNo' => $_POST['cellNo'],
                    'email' => $_POST['email'],
                    'nameOfInst' => $_POST['nameOfInst'],
                    'program' => $_POST['program'],
                    'batchNo' => $_POST['batchNo'],
                    //'gender' => $_POST['gender'],
                    'dob' => $handyCam->parseAppDate($_POST['dob']),
                    'bloodGroup' => $_POST['bloodGroup'],
                    'nationality' => $_POST['nationality'],
                    'nationalId' => $_POST['nationalId'],
                    'passportNo' => $_POST['passportNo'],
                    'fatherName' => $_POST['fatherName'],
                    'motherName' => $_POST['motherName'],
                    'fatherCellNo' => $_POST['fatherCellNo'],
                    'motherCellNo' => $_POST['motherCellNo'],
                    'localGuardian' => $_POST['localGuardian'],
                    'localGuardianCell' => $_POST['localGuardianCell'],
                    'presentAddress' => $_POST['presentAddress'],
                    'parmanentAddress' =>$_POST['parmanentAddress'],
                    //'perPhoto' => $perPhoto,
                    'admitDate' => $dateNow,
                    'isActive' => 'Y'
                );
                $userGroupId = "UG004";
                $name = $_POST['name'];
                $userId = $_POST['userId'];
                $studentId = $_POST['studentId'];
                $cellNo = $_POST['cellNo'];
                $email = $_POST['email'];
                $nameOfInst = $_POST['nameOfInst'];
                $program = $_POST['program'];
                $batchNo = $_POST['batchNo'];
                $gender = 'Female';
                $dob = $handyCam->parseAppDate($_POST['dob']);
                $bloodGroup = $_POST['bloodGroup'];
                $nationality = $_POST['nationality'];
                $nationalId = $_POST['nationalId'];
                $passportNo = $_POST['passportNo'];
                $fatherName = $_POST['fatherName'];
                $motherName = $_POST['motherName'];
                $fatherCellNo = $_POST['fatherCellNo'];
                $motherCellNo = $_POST['motherCellNo'];
                $localGuardian = $_POST['localGuardian'];
                $localGuardianCell = $_POST['localGuardianCell'];
                $presentAddress = $_POST['presentAddress'];
                $parmanentAddress =$_POST['parmanentAddress'];
                //$perPhoto = $perPhoto;
                $admitDate = $dateNow;
                $isActive = 'Y';
                if($handyCam->parseAppDate($_POST['dob']) > date('Y-m-d') || $handyCam->parseAppDate($_POST['dob']) < '1990-01-01'){
                    $msg = "Invalid DOB";
                }
                if(!preg_match("/^[A-Za-z ]+$/",$name))
                {
                    $msg = "Invalid Name"; 
                }
               else if(!preg_match("/[0-9]{4}\-[0-9]{2}\-[0-9]{2}/",$dob))
               {
                 $msg = "Date of Birth should be in (yyyy-mm-dd)"; 
               } 
               
              else if((!preg_match("/[0-9]{10}/",$cellNo)) || (!preg_match("/[0-9]{10}/",$fatherCellNo)) || (!preg_match("/[0-9]{10}/",$motherCellNo)) ||(!preg_match("/[0-9]{10}/",$localGuardianCell)))
               {
                 $msg = "Please enter a valid 10 digit mobile number"; 
               } 
               else if($cellNo>10000000000 || $fatherCellNo>10000000000 || $motherCellNo>10000000000 || $localGuardianCell>10000000000)
               {
                 $msg = "Please enter 10 digit mobile number"; 
               } 
                else {
                try{
                $sql = "INSERT into studentinfo(userId, userGroupId, name, studentId, cellNo, email, nameOfInst, program, batchNo, gender, dob, bloodGroup, nationalId, nationality, passportNo, fatherName, motherName, fatherCellNo, motherCellNo, localGuardian, localGuardianCell, presentAddress, parmanentAddress, admitDate, isActive) VALUES('$userId', '$userGroupId', '$name', '$studentId', '$cellNo', '$email', '$nameOfInst', '$program', '$batchNo', '$gender', '$dob', '$bloodGroup', '$nationalId', '$nationality', '$passportNo', '$fatherName', '$motherName', '$fatherCellNo', '$motherCellNo', '$localGuardian', '$localGuardianCell', '$presentAddress', '$parmanentAddress', '$admitDate', '$isActive')";
                mysql_query($sql);
                $result=mysql_insert_id().mysql_error();}
                catch(Exception $e) {
}
               // $result = $db->insertData("studentinfo",$data);
                if($result>=0) {
                    $userPass = md5("hms2015".$_POST['password']);
                    $data = array(
                        'userId' => $_POST['userId'],
                        'userGroupId' => "UG004",
                        'name' => $_POST['name'],
                        'loginId' => $_POST['cellNo'],
                        'password' => $userPass,
                        'verifyCode' => "vhms2115",
                        'expireDate' => "2115-01-4",
                        'isVerifed' => 'Y'
                    );
                    $userId = $_POST['userId'];
                    $name = $_POST['name'];
                    $loginId = $_POST['cellNo'];
                    $sql = "INSERT into users( userId,userGroupId, name, loginId, password, verifyCode, expireDate, isVerifed) VALUES('$userId', 'UG004', '$name', '$loginId', '$userPass', 'vhms2115', '2115-01-4', 'Y')";
                    mysql_query($sql);
                    $result=mysql_insert_id().mysql_error();
                    if($result>0)
                    {
                        $id =intval($userIds[0])+1;

                        $query="UPDATE auto_id set number=".$id." where prefix='U';";
                        $result=$db->update($query);
                       // $db->close();
                        echo '<script type="text/javascript"> alert("Admitted Successfully.");</script>';
                    }
                    else
                    {
                        echo '<script type="text/javascript"> alert("' . $result . '");</script>';
                    }


                    }
                
                if(strpos($result,'Duplicate') !== false)
                {
                    echo '<script type="text/javascript"> alert("Student Already Exits!");</script>';
                }
                else
                {
                    echo '<script type="text/javascript"> alert("' . $result . '");</script>';
                }
         }
     }
         else {
            echo '<script type="text/javascript"> alert("' . $msg . '");</script>';
        }
    }

}

?>
<?php include('./../../master.php'); ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>New Admission</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-info-circle fa-fw"></i> Admission Information
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <form name="admission" action="admission.php" onsubmit="return checkForm(this);" accept-charset="utf-8" method="post" enctype="multipart/form-data">


                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Full Name</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-leaf"></i> </span>
                                                <input type="text" placeholder="Full Name" class="form-control" name="name" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Student Id(As Login Id)</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-info"></i> </span>
                                                <input type="text" placeholder="Student Id" class="form-control" name="studentId" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>User Id</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-info"></i> </span>
                                                <input type="text" placeholder="Student Id" class="form-control" name="userId" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Cell No</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-mobile-phone"></i> </span>
                                                <input type="text" placeholder="Mobile No" class="form-control" name="cellNo" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Email</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-envelope"></i> </span>
                                                <input type="email" placeholder="Email" class="form-control" name="email" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Password</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-key"></i> </span>
                                                <input type="password" id="password" placeholder="" class="form-control" name="password" required>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Confirm Password</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-key"></i> </span>
                                                <input type="password" id="rePassword" placeholder="" class="form-control" name="rePassword" required>
                                            </div>
                                        </div>

                                    </div>
                                    </div>
                                </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <!-- <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Photo</label>
                                            <div class="input-group">

                                                <input type="file" class="form-control" name="perPhoto" required>
                                            </div>
                                        </div>

                                    </div> -->
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Name Of Institute</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-building"></i> </span>
                                                <input type="text" placeholder="Name Of Institute" class="form-control" name="nameOfInst" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Program</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-book"></i> </span>
                                                <input type="text" placeholder="Program" class="form-control" name="program" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Batch No</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i> </span>
                                                <input type="text" placeholder="Batch No" class="form-control" name="batchNo" required>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Gender</label>
                                            <select class="form-control" name="gender" required="">
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>

                                            </select>
                                        </div>
                                    </div> -->
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Date Of Birth</label>
                                            <div class="input-group date" id='dp1'>

                                                <span class="input-group-addon"><i class="fa fa-calendar"></i> </span>
                                                <input type="text" placeholder="Date Of Birth" class="form-control datepicker" name="dob" required  data-date-format="dd/mm/yyyy">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Blood Group</label>
                                            <select class="form-control" name="bloodGroup" required="">

                                                         <option value="A(+)">A(+)</option>
                                                         <option value="A(-)">A(-)</option>
                                                        <option value="A(un)">A(unknown)</option>
                                                        <option value="B(+)">B(+)</option>
                                                <option value="B(-)">B(-)</option>
                                                <option value="B(un)">B(unknown)</option>
                                                <option value="AB(+)">AB(+)</option>
                                                <option value="AB(-)">AB(-)</option>
                                                <option value="AB(un)">AB(unknown)</option>
                                                <option value="O(+)">O(+)</option>
                                                <option value="O(-)">O(-)</option>
                                                <option value="O(un)">O(unknown)</option>
                                                         <option value="un">Unknown</option>

                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Nationality</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-info"></i> </span>
                                                <input type="text" placeholder="Nationality" class="form-control" name="nationality" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>National ID</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-info"></i> </span>
                                                <input type="text" placeholder="National Id" class="form-control" name="nationalId" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Passport No</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-info"></i> </span>
                                                <input type="text" placeholder="Passport No" class="form-control" name="passportNo">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Father Name</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-leaf"></i> </span>
                                                <input type="text" placeholder="Father Name" class="form-control" name="fatherName" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Father Cell No</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-mobile-phone"></i> </span>
                                                <input type="text" placeholder="Mobile No" class="form-control" name="fatherCellNo" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Mother Name</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-leaf"></i> </span>
                                                <input type="text" placeholder="Mother Name" class="form-control" name="motherName" required>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Mother Cell No</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-mobile-phone"></i> </span>
                                                <input type="text" placeholder="Mobile No" class="form-control" name="motherCellNo" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Local Guardian</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-leaf"></i> </span>
                                                <input type="text" placeholder="Guardian Name" class="form-control" name="localGuardian" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Local Guardian Cell No</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-mobile-phone"></i> </span>
                                                <input type="text" placeholder="Mobile No" class="form-control" name="localGuardianCell" required>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Present Address</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-road"></i> </span>
                                                <textarea rows="3" placeholder="Address" class="form-control" name="presentAddress" required> </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Parmanent Address</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-road"></i> </span>
                                                <textarea rows="3" placeholder="Parmanent Address" class="form-control" name="parmanentAddress" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="row">
                                <div class="col-lg-12">
                                    <label id="lblmsg" class="red"></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-5"></div>
                                    <div class="col-lg-2">
                                        <label id="loginMsg" class="red"><?php echo $msg ?></label>
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


    });
    function checkForm(form) {

        var password = document.getElementById("password")
            , confirm_password = document.getElementById("rePassword");
        console.log(password.value);
        console.log(confirm_password.value);
        if(password.value != confirm_password.value) {

            $("#lblmsg").text("**Passwords Don't Match");

            return false;
        } else {

            return true;
        }

    }


</script>
