<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>ViewerJS</title>
</head>
<body>
<p>ViewerJS</p>

    <div id="header"class="row">HEADER TEXT</div>
           
    <div id="menu" class="col-2" id=leftDiv>
    
    		<p></p>
           LINKS
           <ul>
                <li><a href="<?php echo base_url(); ?>assets/js/ViewerJS/#<?php echo base_url(); ?>assets/images/codeigniter17.pdf" target="content"> Link 1 </a></li>
                <li><a href="<?php echo base_url(); ?>assets/js/ViewerJS/#<?php echo base_url(); ?>assets/images/css_tutorial.pdf" target="content"> Link 2 </a></li>
                <li><a href="<?php echo base_url(); ?>assets/js/ViewerJS/#<?php echo base_url(); ?>assets/images/html7days.pdf" target="content"> Link 3 </a></li>
           </ul>
    </div>

    <div id="content" class="col-10"><iframe name="content" src="" width='800' height='600' allowfullscreen webkitallowfullscreen></div></iframe>

<object class="embed-responsive-item" data="<?php echo base_url(); ?>assets/doc/pics.pdf" type="application/pdf" internalinstanceid="9" title="">
                  <p>Your browser isn't supporting embedded pdf files. You can download the file
                    <a href="<?php echo base_url(); ?>assets/doc/pics.pdf">here</a>.</p>
                  </object>
                
</body>
</html>
