


<?php
require "/var/www/html/moodle/config.php";
global $USER,$DB,$CFG;
  if(!isloggedin()){
    header("Location: https://".$_SERVER['HTTP_HOST']."/login.php");
  }
$logout="https://".$_SERVER['HTTP_HOST']."/login/logout.php?sesskey=".$USER->sesskey;
$_SESSION['initial_page']="extsite";
$sql_query="SELECT b.fullname,a.name from mdl_assign a, mdl_course b where b.id=a.course and a.name='mlapstandalone'";
$studentname=$USER->firstname +" "+ $USER->lastname;
$course=$DB->get_records_sql($sql_query);
?>
<STYLE><!--
.container{
    display: flex;
    justify-content: center;
    align-items: center;
    }
--></STYLE>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>mL "antiPlagiarism Service"</title>

  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Satisfy|Bree+Serif|Candal|PT+Sans">
  <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/stylesuccess.css">
  
</head>

<body>
  <!--banner-->
<section id="banner">
    <div class="bg-color">
      <header id="header">
        <div class="container">
          <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="#about">About</a>
            <a href="#event">A</a>
            <a href="#menu-list">B</a>
            <a href="#contact">C</a>
          </div>
          <!-- Use any element to open the sidenav -->
          <div class="img-responsive">
          <span onclick="openNav()" class="pull-right menu-icon">☰</span></div>
        </div>
      </header>
      <div class="container">
        <div class="row">
              <div class="inner text-center">
            <h4 class="logo-name3">ANTI PLAGIARISM</h4>
            <div class="chs">
            <h3 class="logo-name">mood</h3><h3 class="logo-name1">Learning</h3></div>
            <h2>Welcome <?php echo "$USER->firstname $USER->lastname";?></h2>
          </div>
          <div class="actions">
          <a href="#menu-list" class="btn-get-started">Check the Plagiarism</a></div>
        </div>
      </div>
    </div>
  </section>
  <!-- / banner -->
   <section id="about" class="section-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center marb-35">
          <h1 class="header-h">"mL antiPlagiarism"</h1>
          <p class="header-p">The moodLearning antiPlagiarism (mLaP) Service checks possible plagiarism in documents.It’s a utility integrated into an eLearning
          platform. mLaP searches and compares similarities between submitted assignments using pair-wise document comparison.It searches the
          internet for similar documents.mLaP is capable of getting mass upload of reference materials from partner institutions. </p>
        </div>
                <div class="col-md-1"></div>
        <div class="col-md-10">
          <div class="col-md-6 col-sm-6">
            <div class="about-info">
              <h2 class="heading">The moodLearning antiPlagiarism (mLaP) Services</h2>
              <div class="details-list">
                <ul>
                  <li><i class="fa fa-check"></i>Searches and compares similarities between submitted assignments using pair-wise document comparison. Included in those compared documents are submissions from other classes.</li>
                  <li><i class="fa fa-check"></i>Searches the internet for similar documents and display similarity results</li>
                  <li><i class="fa fa-check"></i>Processes txt, pdf, doc, docx, odt, rtf, txt, cpp, java files submitted </li>
                  <li><i class="fa fa-check"></i>Mass upload of reference papers from partner institutions. These papers become part of a databases that serve as references against which student submissions will be compared</li>
                </ul>
              </div>
            </div>
          </div>
       <div class="col-md-6 col-sm-6">
            <img src="css/images/logo.png" alt="" class="img-responsive">
          </div>
      
         
        </div>
        <div class="col-md-1"></div>
      </div>
    </div>
  </section>
   <section id="event">
    <div class="bg-color" class="section-padding">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 text-center" style="padding:60px;">
          <h1 class="header-h"></h1>
          </div>
          <div class="col-md-12" style="padding-bottom:60px;">
            <div class="item active left">
              <div class="col-md-6 col-sm-6 left-images">
                <img src="css/images/anti.png" class="img-responsive">
              </div>
              <div class="col-md-6 col-sm-6 details-text">
                <div class="content-holder">
                  <h2>Advantages</h2>
                  <p>* unlimited number of users<br>
                    * integrated search<br>
                    * better intellectual property (IP) management<br>
                    * native search engine.</p>
                  <a class="btn btn-imfo btn-read-more" href="https://doku.moodlearning.com/doku.php?id=mlap-service">Read more</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

    <section id="menu-list" class="section-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center marb-35">

       

   <?php 
    //echo print_r($USER);
    //echo $USER->id;


        echo "<div id='menu-wrapper'>";

  
            

      $sql_query="SELECT a.id as aid,b.id,a.filename,a.status from {mlap_files} a,{mlap_documents} b where userid=$USER->id and b.mlap_submission_id=a.id or a.status='queue'";
      $file=$DB->get_records_sql($sql_query);
      if($file==null){
        echo "No file submitted";
      }
      else{

      $strsimilar = get_string("similar", "plagiarism_mlap");
      $strname = get_string('col_name','plagiarism_mlap');
        $strcourse = get_string('col_course','plagiarism_mlap');
        $strscore = get_string('col_similarity_score','plagiarism_mlap');
        $strnoplagiarism = get_string('no_plagiarism','plagiarism_mlap');
      foreach ($file as $files) {
      //echo print_r($files);
      $table = new html_table();
       $table->head  = array ("Filename", $strsimilar);
        $table->align = array ("left", "left");
        $table->size = array('30%', '80%');
              echo "<div class='C'>";
           echo "<span class='clearfix'>";    
                    echo "<span>"; 
               $table2 = "<table id='example' class='table table-striped table-bordered'cellspacing='0' 'width:100%'><tr width='100%'> <td width='100%'>$strname</td> <td width='100%'>$strcourse</td> <td width='570px'>$strscore</td></tr>"; 
            
          echo "</span>";echo "</span>";
     
          echo "</div>";
        if($files->status=="queue"){
             $table2 = "<table border=6 width='100%'padding-left='100%'><tr width='100%'><td width='100'%>Your file has been successfully uploaded and is now being queued for scanning. You'll be notified by email once possible plagiarism is detected</td></tr>";
            
           
           
  
      }
      
                     
            
      else{
  
  
        $sql_query = "SELECT * FROM {$CFG->prefix}mlap_submission_pair WHERE submission_a_id =$files->id OR  submission_b_id = $files->id order by number_of_same_hashes desc";
        $similars = $DB->get_records_sql($sql_query);
        //echo print_r($similars);
        $sql_query = "SELECT count(*) as cnt from {$CFG->prefix}mlap_fingerprint where mlap_doc_id = '$files->id'";
        $numbertotal = $DB->get_record_sql($sql_query);
        if (!empty($similars)){
          foreach ($similars as $asim){
          if ($asim->submission_a_id == $files->id){
         $partner = $asim->submission_b_id;
          }
            else {
         $partner = $asim->submission_a_id;
        }
        // back from id to assignment id
        $subm3 = $DB->get_record("mlap_documents", array("id"=>$partner));
            $party = $partner;
    
        if ($subm3->mlap_submission_id == 0) {
      // web document
                $wwwdoc = $DB->get_record("mlap_web_documents", array("document_id"=>$party));          
                $nURL = urldecode($wwwdoc->link);
                $namelink = substr($nURL,0,40);
                $courseBname = get_string('webdocument','plagiarism_mlap');
        }
        else {
        $subm4 = $DB->get_record("mlap_files", array("id"=>$subm3->mlap_submission_id));
                $partner=$subm4->file_id;       
                if ($partns = $DB->get_record("files", array("id"=>$partner))) {
                    $namelink = $partns->author;// get author name
                    $courseB = $DB->get_record("course", array("id"=>$subm4->courseid));
                    $courseBname = $courseB->shortname;// get course shortname
                } 
                else {
             //$namelink = get_string('file_was_not_found','plagiarism_mlap');
           $namelink = NULL;
           $courseBname = NULL;
             //$courseBname = get_string('course_not_applicable','plagiarism_mlap');
                }
        }
        // divide  the number of common by the total # of hashes to get the percentage
        
        $perc =  round(($asim->number_of_same_hashes / $numbertotal->cnt) * 100, 2);
            $perc_link = "<a href=\"compare.php?ida=$files->id&idb=$party&perc=$perc\">   <img src=\"details.png\"  width=\"30\" height=\"30\" title=\"Click here for details.\"></a>";
        //TODO add threshold here $CFG->block_mlap_threshold
      
        if ($perc > $threshold && !empty($namelink) && !empty($courseBname)){

               echo "<div class='C'>";
           echo "<span class='clearfix'>";   
             echo "<span>";  $table2 = $table2."<tr><td>$namelink</td><td>$courseBname</td><td>$perc%$perc_link</td></tr>";echo "</span>"; 
                
         
         echo "</span>";
     
          echo "</div>"; 

          }
           
          }// end of the loop   
    }
         


      else {  
       
            echo "<div class='C'>";
           echo "<span class='clearfix'>";

            
             echo "<span>";  $table2 = "<table id='example' class='table table-striped table-bordered'cellspacing='0'>
             <tr width='1000px'><td class='no' width='1000px'>No plagiarism has been detected.</td></tr>";
             echo "</span>";
            echo "</span>";
     
          echo "</div>"; 

      } 
       
     
    }

        $table2 = $table2."</table>";
        $table->data[] = array ("$files->filename", $table2);
        echo html_writer::table($table);
      }
    }

  ?>




</div></div> <div class="col-md-1"></div></div></div></section>
 <section id="contact" class="section-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
         <h2 class="ser-title">Select to Upload:</h2>
        <form action="upload.php" method="post" enctype="multipart/form-data">
          <div class="ocon">
          <input class="form-control br-radius-zero" id="name" type="file" name="fileToUpload" id="fileToUpload">
          </div>
    </form>
    <div class="con">
    <div class="form-action">
                <input type="submit" value="Upload" class="btn btn-form"">
              </div>

              <div class="container1">
    <form name="logout" class="expose" method="post" action=<?php echo $logout?>>
            <div class="form-action">
                <input type="submit" value="logout" class="btn btn-form"">
             

     
    
    </div>
</div></div>
  </section>
 
 
<footer class="footer text-center">
    <div class="footer-top">
      <div class="row">
        <div class="col-md-offset-3 col-md-6 text-center">
          <div class="widget">
            <h4 class="widget-title">mL "antiPlagiarism" Services</h4>
            <address><address>Entreprise Program for Technopreneurship <br>3/F National Engineering Center<br>
                    University of the Philippines<br>Diliman, Quezon City</address>
            <div class="social-list">
              <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
              <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            </div>
            <p class="copyright clear-float">
              Copyright © moodLearning, Inc. 2011-8.
            </p>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <script src="js/jquery.min.js"></script>
  <script src="js/jquery.easing.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/custom.js"></script>
  <script src="contactform/contactform.js"></script>
  <script src="js/java.js"></script>
   <script src="js/javas.js"></script>
  <script>
       $(document).ready(function(){
           $('[data-toggle="tooltip"]').tooltip();

       });
     </script>

</body>

</html>
