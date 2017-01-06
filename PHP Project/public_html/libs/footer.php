<footer class="footer">
    <div class="container">
        <p>© 2016 Company, Inc. | <?php
            if($userLoggedIn){
                echo  '<a href="'.$logOutPath.'">Log Out</a>';
            } else {
                echo '<a href="#" data-toggle="modal" data-target="#signIn">Log In</a>';
            }
        ?> | <a href="/folder_view/vs.php?s=<?php echo $viewFile?>" target="_blank">View Source</a></p>
    </div>
</footer>
<script type="text/javascript">
    // Display any Error messages
    if( isError ){
        messageModal(errorMessage, errorHeader, errorFooter);
    }
    //$('#loginForm').validator();
</script>
<script src="js/events.js" type="text/javascript"></script>
<!-- https://github.com/1000hz/bootstrap-validator -->
<script src="vendors/js/validator.min.js" type="text/javascript"></script>
<!-- http://eonasdan.github.io/bootstrap-datetimepicker/ -->
<script src="vendors/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src=http://my.gblearn.com/js/loadscript.js type="text/javascript"></script>
