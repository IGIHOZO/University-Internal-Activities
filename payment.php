<?php 
session_start();
require'header.php';

if(!isset($_SESSION['user'])){
  echo '<script type="text/javascript">window.location="login";</script>';
} ?>
  <title>
    Fee Payment
  </title>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Fee Payment</h4>
                  <p class="card-category">Insert student fee payment</p>
                </div>
                <div class="card-body">
                   <form method="post" id="payment">
                    <input type="hidden" name="payment">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Student Regnumber</label>
                          <div class="form-group">
                            <label class="bmd-label-floating" id="names"></label>
                          <input type="text" name="reg" class="form-control" required="" id="reg">
                        </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Academic Year</label>
                          <select class="form-control" name="year" required="">
                            <option></option>
                            <?php 
                            $sql="SELECT * from academic_year order by id asc";
                            $param = array();
                            $year = $action->selectRows($sql,$param);
                            foreach ($year as $key => $y) {
                            ?>
                            <option value="<?= $y['id']; ?>"><?= $y['year']; ?></option>
                          <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Bank</label>
                          <select class="form-control" required="" name="bank">
                            <option></option><?php 
                            $sql="SELECT * from bank order by id asc";
                            $param = array();
                            $year = $action->selectRows($sql,$param);
                            foreach ($year as $key => $y) {
                            ?>
                            <option value="<?= $y['id']; ?>"><?= $y['code_bank']; ?></option>
                          <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Slip Payment</label>
                          <input type="text" class="form-control" name="slip" required="">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Payment Amount</label>
                          <input type="text" class="form-control" name="amount" required="">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Date of  Payment</label>
                          <input type="date" class="form-control" name="paid" value="<?= date('Y-m-d'); ?>">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Date of Recording</label>
                          <input type="date" class="form-control" name="recording" value="<?= date('Y-m-d'); ?>">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Comment</label>
                          <div class="form-group">
                            <label class="bmd-label-floating">Payment Comment</label>
                            <textarea class="form-control" rows="5" name="comment"></textarea>
                          </div>
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