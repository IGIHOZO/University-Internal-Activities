<?php
include_once "Database.php";
class Students
{

    public $conn;
    private $validate;

    function __construct()
    {
        $db = new Database();
        $this->conn = $db->connection();
    }

    function get($datas)
    {
        $faculty = $datas['faculty'];
        $qy = $this->conn->prepare("SELECT * FROM masters_students WHERE ms_rollnumber=:faculty");
        $qy->execute(['faculty' => $faculty]);
        $data = $qy->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function login($datas)
    {
        $rollnumber = $datas['rollnumber'];
        $confRollNumber = $datas['confirm_rollnumber'];
//        return $datas;exit;
        if($rollnumber!==$confRollNumber) return ['status'=>'fail','message'=>'Roll number does not match'];
        $qy = $this->conn->prepare("SELECT * FROM masters_students WHERE ms_rollnumber=:rollnumber");
        $qy->execute(['rollnumber' => $rollnumber]);
        if ($qy->rowCount() == 1) {
            //fetch faculty and modules
            $studentInfo = $qy->fetch(PDO::FETCH_ASSOC);

            $facultyMatching = [
                'MASTERS-LLM/IEL-E' => 'MASTER OF INTERNATIONAL ECONOMICS AND BUSINESS LAW',
                'MIEBL/W' => 'MASTER OF INTERNATIONAL ECONOMICS AND BUSINESS LAW',
                'MASTERS-Macc-E' => 'MASTER OF ACCOUNTING',
                'MACC /W' => 'MASTER OF ACCOUNTING',
                'MASTERS-MDS-E' => 'MASTER OF DEVELOPMENT STUDIES',
                'MDS/W' => 'MASTER OF DEVELOPMENT STUDIES',
                'MASTERS-FINANCE-E' => 'MASTER OF FINANCE',
                'MFIN/W' => 'MASTER OF FINANCE',
                'MASTERS-LLM/PIL-E' => 'MASTER OF PUBLIC INTERNATIONAL LAW',
                'MPIL/W' => 'MASTER OF PUBLIC INTERNATIONAL LAW',
                'MASTERS-MIS-E' => 'MASTER OF INTERNET SYSTEMS',
                'MASTERS-ECONOMICS-E' => 'MASTER OF SCIENCE IN ECONOMICS',
                'MSEC/W' => 'MASTER OF SCIENCE IN ECONOMICS',
                'MASTERS-MBA-E' => 'MASTER OF BUSINESS ADMINISTRATION',
                'MBA/W' => 'MASTER OF BUSINESS ADMINISTRATION'
            ];
            $facultyName = $facultyMatching[$studentInfo['ms_classes']];
//            return [$studentInfo];
            $qyFaculty = $this->conn->prepare("SELECT * FROM masters_faculties WHERE facult_name=:faculty");
            $qyFaculty->execute(['faculty' => $facultyName]);
            $faculties = $qyFaculty->fetch();
            $studentInfo['faculty'] = $faculties;

            $qyModules = $this->conn->prepare("SELECT * FROM masters_modules WHERE modules_facult=:faculty");
            $qyModules->execute(['faculty' => $faculties['facult_id']]);
            $modules = $qyModules->fetchAll(PDO::FETCH_ASSOC);

            $studentInfo['modules'] = $modules;
            return $studentInfo;

        }

        return ['status'=>'fail','message'=>'Rollnumber not exist'];
    }

    public function saveModules($datas)
    {
        $feed = ['status'=>'ok'];
//        return is_array($datas['modules'])?json_encode($datas['modules']):"Not array";
        if (is_array($datas['modules'])) {
            for ($i=0;$i<count($datas['modules']);$i++) {
                $module = $datas['modules'][$i];

                $qyModules = $this->conn->prepare("SELECT * FROM masters_modules_done WHERE done_module=:modules AND done_student=:student");
                $qyModules->execute(['student' => $datas['student'], 'modules' =>$module]);
                if($qyModules->rowCount()==0){
                    $qyModulesIns = $this->conn->prepare("INSERT INTO masters_modules_done SET done_module=:modules,done_student=:student");
                    $qyModulesIns->execute(['student' => $datas['student'], 'modules' =>$module]);
                    $feed[] = ['module'=>$module,'error'=>$qyModulesIns->errorInfo()];
                }else $feed[]=['status'=>'exist','module'=>$module];
            }
        }
        return $feed;
    }
    function getRegisteredModules($datas){
        $student = $datas['student'];
        $qyModules = $this->conn->prepare("SELECT mmd.*,mm.* FROM masters_modules_done mmd INNER JOIN masters_modules mm ON mm.modules_id=mmd.done_module WHERE mmd.done_student=:student");
        $qyModules->execute(['student' => $student]);
        return $qyModules->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>