<?php session_start();
require'header.php';
if(!isset($_SESSION['finance'])){
  echo '<script type="text/javascript">window.location="login";</script>';
} ?>

      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">All Students</h4>
                  <p class="card-category">LIst of all payed students</p>
                </div>
                <div class="card-body">

                   <form method="get">
                    <div class="row">
                      <div class="col-md-12">


                    <div class="row">
                      <div class="col-md-8">
                        <div class="form-group">
                          <label class="bmd-label-floating">Class</label>
                          <select class="form-control" name="module" required="">
                            <option></option>
                            <?php 
                            
                          $sql="SELECT * from faculty,department,class,student_year,modules where faculty.id=mod_faculty and department.id=mod_depart and class.id=mod_class and student_year.id_class=mod_class and student_year.section=mod_section group by mod_id";
                          $param = array();
                          $module = $action->selectRows($sql,$param);
                            foreach ($module as $key => $y) {
                            ?>
                            <option value="<?= $y['mod_id']; ?>"><?= $y['code_faculty']; ?> | <?= $y['code_department_en']; ?> | <?= $y['code_class_en']; ?> | <?= $y['section']; ?></option>
                          <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Date to</label>
                          <input type="date" class="form-control" name="date" value="<?= date('Y-m-d'); ?>">
                        </div>
                      </div>
                    </div>


                      
                    <button type="submit" class="btn btn-primary pull-right">Check Attendance</button>
                      </div>
                    </div>
                  </form>
                  <?php 
                   $sql="SELECT * from faculty,department,class,student_year,modules where mod_id=? and faculty.id=mod_faculty and department.id=mod_depart and class.id=mod_class and student_year.id_class=mod_class and student_year.section=mod_section";
                          $param = array($_GET['module']);
                          $module = $action->selectRow($sql,$param);
                  ?>

  <title>
   <?= $module['code_faculty']; ?> | <?= $module['code_department_en']; ?> | <?= $module['code_class_en']; ?> | <?= $module['section']; ?>
  </title>
                  <div id="attendance">
                  <h3><?= $module['code_faculty']; ?> | <?= $module['code_department_en']; ?> | <?= $module['code_class_en']; ?> | <?= $module['section']; ?></h3>
                  <div class="table-responsive">
                    <table class="table" border="1" cellspacing="0">
                      <thead class=" text-primary">
                      <td>#</td>
                      <th>Name</th>
                      <th>Rollnumber</th>
                      <th>Department</th>
                      <th>Class</th>
                      <th>Section</th>
                      <th>Module Exam</th>
                      <th>Exam Date</th>
                      <th>Exam Booklet</th>
                      </thead>
                      <tbody>
                        <?php 
                          $n=0;

                          // $sql="SELECT * from student,faculty,department,class,student_year,modules,attendance where mod_id=? and faculty.id=mod_faculty and department.id=mod_depart and class.id=mod_class and student_year.id_class=mod_class and student_year.section=mod_section and student.id=att_student and student_year.id_student=att_student and att_date=? and att_status=1 group by att_student";
                          $sql="SELECT * from student,faculty,department,class,student_year,modules,exam_attendance where mod_id=? and faculty.id=mod_faculty and department.id=mod_depart and class.id=mod_class and student_year.id_class=mod_class and student_year.section=mod_section and student.id=attendance_student and student_year.id_student=attendance_student and attendance_exam_time=? and attendance_status=? group by attendance_student";
                          
                          // $sql="SELECT * from student,faculty,department,class,student_year,modules,exam_attendance where attendance_status=? AND exam_attendance.attendance_module=0 group by attendance_student";

                          $param = array($_GET['module'],$_GET['date'],"E");
                          $attendance = $action->selectRows($sql,$param);
                          foreach ($attendance as $key => $att) {
                            $n+=1;
                          ?>

                        <tr>
                          <td><?= $n; ?></td>
                          <td><?= $att['firstname_student']; ?> <?= $att['lastname_student']; ?></td>
                          <td><?= $att['regnumber_student']; ?></td>
                          <td><?= $att['name_department_en']; ?></td>
                          <td><?= $att['name_class_en']; ?></td>
                          <td><?= $att['section']; ?></td>
                          <td><?= $att['mod_name']; ?></td>
                          <td><?= $att['atte']; ?></td>
                        </tr>

                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                    <button id="pr" class="btn btn-primary pull-right">Print Attendance</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  <?php require 'footer.php'; ?>
</body>
<script type="text/javascript">
  $('#pr').click(function(){
  const contain=document.getElementById('attendance').innerHTML;
  const a=window.open('','','height=600,width=600');
   a.document.write('<html><body border="1"><head><style type="text/css">');
   a.document.write('th, td,{border: 1px solid #000;},#hr{border:1px solid black}');
   a.document.write('</style></head>');
   a.document.write(contain);
   a.document.write('</body></html>');
   a.document.close();
   a.print();
  })
</script>
</html>

