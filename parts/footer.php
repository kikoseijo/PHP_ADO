
		<footer>

    </footer>

    </div>
		<!-- container-->

		<!-- bower:js -->
		<script src="../bower_components/jquery/dist/jquery.js"></script>
		<script src="../bower_components/bootstrap/dist/js/bootstrap.js"></script>
		<script src="../bower_components/jquery.gritter/js/jquery.gritter.js"></script>
		<script src="../bower_components/toastr/toastr.js"></script>
		<!-- endbower -->
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
