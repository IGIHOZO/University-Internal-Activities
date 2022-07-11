<?php require'header.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script><script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<style type="text/css">
  #qrcode{
    height: 8.50392in; 
    width: 13.480316in;
    position: relative;
    float: left;
    background: #fff;
  }
  #qrcode img{
    height: 90%;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%,-50%);
  }
  #button{
    position: absolute;
    top: 50%;
    right: 20px;
    transform: translateY(-50%);
  }
  #button button{
    cursor: pointer;
    outline: none;
    border: none;
    padding: 10px 30px;
    border-radius: 10px;
    float: left;
    margin-left: 10px;
  }
</style>
  <title>
    Search Employee
  </title>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Employee QR</h4>
                  <p class="card-category">Type employee names to search</p>
                  <div id="button" style="display: none;">
                    
                    <button id="download">Download</button>
                    <button id="print">Print</button>
                  </div>
                </div>
                <div class="card-body">
                   <form>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Employee Names</label>
                          <input type="text" id="phone" class="form-control">
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Employee QR</h4>
                  <p class="card-category">Save Employee QR Code below</p>
                  <p id="names" style="display: none;">sdsd</p>
                </div>
                <div class="card-body">
                  <div id="qrcode">
                    <img src="qrcode/php/qr_img.php?d=cards.inkuge.com/payment_checker.php?student=201511556">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  <?php require 'footer.php'; ?>
  <script type="text/javascript" src="assets/js/printThis.js"></script>
</body>

</html>