<?php 
include "phpqrcode/qrlib.php"; 
$url=base_url();
   //$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    //$PNG_TEMP_DIR = dirname('E:\Bitnami\wampstack-5.5.29-1\apache2\htdocs\pnmsystem\assets').'\temp'.DIRECTORY_SEPARATOR;
     // $PNG_TEMP_DIR = dirname($url.'\assets\temp').'\temp'.DIRECTORY_SEPARATOR;
//    $PNG_TEMP_DIR = dirname('C:\xampp\htdocs\pnmsystem\assets\temp').'\temp'.DIRECTORY_SEPARATOR;
    
    if (stripos(strtolower($url), "localhost") !== false) {
        $PNG_TEMP_DIR = dirname('E:\Bitnami\wampstack-5.5.29-1\apache2\htdocs\pnmsystem\assets\uploads').'\temp'.DIRECTORY_SEPARATOR;
        //$PNG_TEMP_DIR = dirname('http://'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'].'/mtmassetfix/assets/uploads').'\temp'.DIRECTORY_SEPARATOR;
        }else{
        $PNG_TEMP_DIR = dirname('E:\Bitnami\wampstack-5.5.29-1\apache2\htdocs\pnmsystem\assets\uploads').'\temp'.DIRECTORY_SEPARATOR; 
        }
        $PNG_TEMP_DIR = dirname('C:\Bitnami\wampstack-5.5.29-1\apache2\htdocs\pnmsystem\assets\uploads').'\temp'.DIRECTORY_SEPARATOR;
       //$PNG_TEMP_DIR = dirname('C:\xampp\htdocs\pnmsystem\assets\uploads').'\temp'.DIRECTORY_SEPARATOR;

    $PNG_WEB_DIR = 'temp/';
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);

    
      $filename = $PNG_TEMP_DIR.$faid.'.png';
       $errorCorrectionLevel = 'L';
      if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
          $errorCorrectionLevel = $_REQUEST['level'];    
          $matrixPointSize = 4;
         
      if (isset($_REQUEST['size']))
          $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);

        //QRcode::png($ItemName." | ".$IClassName." | ".$BranchName." | Go to : ".base_url()."scaner/assetscan?code=".$faid, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
        QRcode::png($ItemName." | ".$IClassName." | ".$BranchName."".$location." | Go to : http://27.50.31.76:9495/pnmsystem/scaner/assetscan?code=".$faid, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
        //QRcode::png("http://27.50.31.76:9495/Asset/scaner/assetscan?code=".$faid, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
        

?>
  <div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="widget">
           <div class="widget-body">
            <?php if($this->session->flashdata('msg')):?>
                    <div class="alert alert-info fade in alert-radius-bordered alert-shadowed">
                        <button class="close" data-dismiss="alert">×</button>
                        <i class="fa-fw fa fa-info"></i>
                       <strong>Success!</strong>
                        <?php echo $this->session->flashdata('msg'); ?>
                        <span class="close" data-dismiss="alert">×</span>
                    </div>
                <?php endif; ?>
          </div>
        </div>
    </div>
  </div>