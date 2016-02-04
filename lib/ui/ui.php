<?php



function toastNotification(&$notification){
	//
	$tipo = ($notification->status=='Error' || $notification->status=='error') ? 'error' : 'success' ;
	$resScript = 'toastr.options = {
									"closeButton": true,
									"debug": false,
									"progressBar": true,
									"preventDuplicates": false,
									"positionClass": "toast-top-right",
									"onclick": null,
									"showDuration": "400",
									"hideDuration": "1000",
									"timeOut": "7000",
									"extendedTimeOut": "1000",
									"showEasing": "swing",
									"hideEasing": "linear",
									"showMethod": "fadeIn",
									"hideMethod": "fadeOut"
								}; ';
	
	return $resScript ." toastr.".$tipo."(".json_encode($notification->text).",'".$notification->status."'); ";
}

function cssNotification(&$notification){
		$tipo=($notification->status=='Error')?'error':'success';
		return "setTimeout(function() {
                $.gritter.add({
                    title: 'Airzone',
                    text: ".json_encode($notification->text).",
                    time: 6000
                });
            }, 1000);";
}