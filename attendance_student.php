<?php require'header.php'; ?>

  <title>
    All Students
  </title>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Students Attendance</h4>
                  <p class="card-category">LIst of all payed students attendance</p>
                </div>
                <div class="card-body">
                   <form method="GET">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Department</label>
                          <select class="form-control"  name="depart" required="">
                            <option></option>
                            <?php 
                            $sql="SELECT * from department order by id asc";
                            $param = array();
                            $year = $action->selectRows($sql,$param);
                            foreach ($year as $key => $y) {
                            ?>
                            <option value="<?= $y['id']; ?>"><?= $y['name_department_en']; ?></option>
                          <?php } ?>
                          </select>
                        </div>
                    <button type="submit" class="btn btn-primary pull-right">Check</button>
                    <div class="clearfix"></div>
                      </div>
                    </div>
                  </form>
                </div>
                  <div class="table-responsive" id="attendance">
                    <table class="table">
                      <thead class=" text-primary">
                      <td>#</td>
                      <th>Name</th>
                      <th>Roll Number</th>
                      <th>Program</th>
                      <th>Department</th>
                      <th>Save</th>
                      </thead>
                      <tbody>
                        <?php 
                        $date = date('Y-m-d');
                        if(isset($_GET['depart'])){
                          $depart=$_GET['depart'];
                        }else{
                          $depart='';
                        }
  $sql = "SELECT * from student,student_year,academic_year,class,department,faculty,to_be_paid,attendance
    where  attendance.att_date=? and student_year.id_student=student.id and student_year.id_year=academic_year.id and class.id=student_year.id_class and department.id=class.id_department and faculty.id=class.id_faculty and to_be_paid.paid_deprt=department.id and student_year.section=to_be_paid.paid_section and attendance.att_student=student_year.id_student and department.id=?";
  $param = array($date,$depart);
                          $students = $action->selectRows($sql,$param);
                          if($students){
                            $n=0;
                          foreach ($students as $student) {
                          $n +=1;
                        ?>
                        <tr>
                      <td><?= $n; ?></td>
                      <td><?= $student['firstname_student'].' '.$student['lastname_student']; ?></td>
                      <td><?= $student['regnumber_student']; ?></td>
                      <td><?= $student['year']; ?></td>
                      <td><?= $student['name_department_en']; ?></td>
                      <td><a href="cards.php?card=<?= $student['regnumber_student']; ?>">Save Card</a></td>
                        </tr>
                        <tr>
                        <?php }} ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                    <button type="submit" class="btn btn-primary pull-right" id="print">Print</button>
              </div>
            </div>
          </div>
        </div>
      </div>
  <?php require 'footer.php'; ?>
</body>
  <script type="text/javascript" src="assets/js/printThis.js"></script>

</html>