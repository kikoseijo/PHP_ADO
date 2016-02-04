






		<footer>
    
    </footer>
    
    </div><!-- container-->
    <script src="/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/bower_components/jquery.gritter/js/jquery.gritter.min.js"></script>
    <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/bower_components/toastr/toastr.min.js"></script>
    <script src="/assets/js/js.js"></script>
		
    <script>
        $(document).ready(function() {
            //WinMove();
						<?php 
						if ($notification) {
							/*	you can choose toast toastNotification or gitter gitterNotification	*/
							echo toastNotification($notification);
						}
						if ($addJS) {
							echo $addJS;
						}
						?>
        });
    </script>
  </body>
</html>