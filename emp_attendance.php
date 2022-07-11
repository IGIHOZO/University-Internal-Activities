<?php require'header.php';
if(!isset($_SESSION['user'])){
  echo '<script type="text/javascript">window.location="login";</script>';
  $stud = $_GET['st']
} ?>

  <title>
    All Students
  </title>
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
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                      <td>#</td>
                      <th>Name</th>
                      <th>Roll Number</th>
                      <th>Program</th>
                      <th>Period</th>
                      <th>Save</th>
                      </thead>
                      <tbody>
                        <?php 
                          $sql = "SELECT * from student,student_year,academic_year,attendance where student.student_photo!='' and student_year.id_student=student.id and academic_year.year=? group by student.id and atte_student=;
                          $param = array('2019-2020');
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
                      <td>2019-2020</td>
                      <td><a href="cards.php?card=<?= $student['regnumber_student']; ?>">Save Card</a></td>
                        </tr>
                        <tr>
                        <?php }} ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  <?php require 'footer.php'; ?>
</body>

</html>