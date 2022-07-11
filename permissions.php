<?php 
session_start();
require'header.php'; 
if(!isset($_SESSION['finance'])){
  echo '<script type="text/javascript">window.location="login";</script>';
} 
?>
  <title>
    Payment Permission
  </title>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Payment Permission</h4>
                  <p class="card-category">Assign payment perssion to student</p>
                </div>
                <div class="card-body">
                   <form method="post" id="permission">
                    <input type="hidden" name="permission">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Student Regnumber</label>
                          <div class="form-group">
                            <label class="bmd-label-floating" id="names"></label>
                          <input type="text" name="reg" class="form-control" required="" id="reg">
                        </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Academic Year</label>
                          <div class="form-group">
                            <label class="bmd-label-floating" id="names"></label>
                          <select class="form-control" name="year" required="">
                            <option></option>
                            <?php 
                            $sql="SELECT * from academic_year where id>34 order by id asc";
                            $param = array();
                            $year = $action->selectRows($sql,$param);
                            foreach ($year as $key => $y) {
                            ?>
                            <option value="<?= $y['id']; ?>"><?= $y['year']; ?></option>
                          <?php } ?>
                          </select>
                        </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Date from</label>
                          <input type="date" class="form-control" name="from" value="<?= date('Y-m-d'); ?>">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Date to</label>
                          <input type="date" class="form-control" name="to" value="<?= date('Y-m-d'); ?>">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Comment </label>
                          <div class="form-group">
                            <label class="bmd-label-floating">Payment Comment</label>
                            <textarea class="form-control" rows="5" name="comment"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>

                    <button type="submit" class="btn btn-primary pull-right">Confirm</button>
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