<?php 
require'header.php'; 
if(!isset($_SESSION['finance'])){
  echo '<script type="text/javascript">window.location="login";</script>';
} 
?>
  <title>
    Modules
  </title>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Add Module</h4>
                  <p class="card-category">Insert new module to be done</p>
                </div>
                <div class="card-body">
                   <form method="post" id="payment">
                    <input type="hidden" name="module">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Module name</label>
                          <div class="form-group">
                            <label class="bmd-label-floating" id="name"></label>
                          <input type="text" name="name" class="form-control" required="">
                        </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Module Code</label>
                          <div class="form-group">
                            <label class="bmd-label-floating" id="code"></label>
                          <input type="text" name="code" class="form-control" required="">
                        </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Faculty</label>
                          <select class="form-control" name="faculty" id="faculty" required="">
                            <option></option>
                             <?php 
                                  $sql="SELECT * from faculty";
                                  $param = array();
                                  $facults = $action->selectRows($sql,$param);
                                  foreach ($facults as $fac) {
                                  ?>
                                  <option value="<?= $fac['id']; ?>"><?= $fac['name_faculty_en']; ?></option>
                              <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Department</label>
                          <select class="form-control" required="" id="department" name="department">
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Class</label>
                          <select class="form-control" required="" id="class" name="class">
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Section</label>
                         <select class="form-control" required="" id="section" name="section">
                          <option></option>
                          <option value="D">Day</option>
                          <option value="E">Evening</option>
                          <option value="W">Weekend</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Date of  Exam</label>
                          <input type="date" class="form-control" name="date" value="<?= date('Y-m-d'); ?>">
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right">Confirm Payment</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  <?php require 'footer.php'; ?>
</body>

</html>