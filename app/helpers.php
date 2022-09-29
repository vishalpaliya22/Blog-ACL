<?php

if(!function_exists('prefixedRouteName')) {
	function prefixedRouteName($routeName) {
		if(session('userType') == 'Admin' && substr($routeName, 0, 6) != 'admin.')
			$routeName = 'admin.' . $routeName;
		elseif(session('userType') == 'Tour Operator' && substr($routeName, 0, 14) != 'blog-operator.')
			$routeName = 'blog-operator.' . $routeName;
		else
			$routeName = $routeName;
		
		return $routeName;
	}
}

if(!function_exists('fromTagifyToDb')) {
	function fromTagifyToDb($thingsToBring) {
		if($thingsToBring == '')
			return '';

		$things1 = json_decode($thingsToBring);
		$things2 = [];
		
		foreach($things1 as $thing)
			$things2[] = $thing->value;
		
		return json_encode($things2);
	}
}

if(!function_exists('fromDbToTagify')) {
	function fromDbToTagify($thingsToBring) {
		if($thingsToBring == '')
			return '';

		$things1 = json_decode($thingsToBring);
		$things2 = [];
		
		foreach($things1 as $thing)
			$things2[] = [ 'value' => $thing ];
		
		return json_encode($things2);
	}
}

if(!function_exists('mysqlDT')) {
	function mysqlDT() {
		return date('Y-m-d H:i:s');
	}
}

if(!function_exists('logMsg')) {
	function logMsg($msgOrEx) {
		if($msgOrEx instanceof \Exception) {
			$backTrace = $msgOrEx->getTrace();
			$basePath = base_path('vendor');
			$basePathLen = strlen($basePath);
			$msg = [];

			for($a = 0, $ac = count($backTrace); $a < $ac; $a++) {
				if(!isset($backTrace[$a]['file'], $backTrace[$a]['line'], $backTrace[$a]['function']))
					continue;
				
				if(substr($backTrace[$a]['file'], 0, $basePathLen) == $basePath)
					continue;
				
				$msg[] = $backTrace[$a]['file'] . " #" . $backTrace[$a]['line'] . ' :' . $backTrace[$a]['function'] . '()';
			}

			logger(
				$msgOrEx->getFile() . " #" . $msgOrEx->getLine() . "\n" . $msgOrEx->getMessage() .
				"\nBackTrace:\n" . implode("\n", $msg)
			);
		} else {
			$backTrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);
			
			logger(
				$backTrace[0]['file'] . "\n#" .
				$backTrace[0]['line'] . ' :' . $backTrace[0]['function'] . "()\n" .
				(is_string($msgOrEx) ? $msgOrEx : print_r($msgOrEx, true))
			);
		}
	}
}

if(!function_exists('sendJsonErrMsg')) {
	function sendJsonErrMsg($errMsg, $errCode = 500, $field = 'common') {
		return response()->json([ 'errors' => [ "$field" =>
			(is_array($errMsg) ? $errMsg : [ $errMsg ])
		] ], $errCode);
	}
}

if(!function_exists('formatTime')) {
	function formatTime($strTime) {
		if($strTime == null)
			return '-';
		
		$arTm = explode(':', $strTime);
		return ($arTm[0] > 12 ? $arTm[0] - 12 : $arTm[0]) . ':' . $arTm[1] . ' ' . ($arTm[0] < 12 ? 'am' : 'pm');
	}
}

if(!function_exists('fileNameExt')) {
	function fileNameExt($fileName) {
		$lastDotPos = strrpos($fileName, '.');
		$fileNmExt = new \stdClass;
		$fileNmExt->name = substr($fileName, 0, $lastDotPos);
		$fileNmExt->ext = substr($fileName, $lastDotPos + 1);
		return $fileNmExt;
	}
}

if(!function_exists('sendEmail')) {
	
	function sendEmail(String $subject, Array $to, String $view, Array $arEmailData = []) {

		$arEmailData += [
			'subject' => str_replace('_SITE_NAME_', env('APP_NAME'), $subject),
			'receiverName' => $to['name'],
		];

		return \Mail::to([ $to ])
			->send(new \App\Mail\Common($view, $arEmailData));
	}
}

if(!function_exists('diffRecord')) {
	function diffRecord($fields, $operationType, $oldValues1, $newValues1, & $oldValues2, & $newValues2) {
		foreach($fields as $field) {
			if($operationType == 'i' or isset($oldValues1[$field], $newValues1[$field])) {
				if($operationType == 'i' or $oldValues1[$field] != $newValues1[$field]) {
					if($operationType != 'i') // no old values when inserting
						$oldValues2[$field] = $oldValues1[$field];
					
					$newValues2[$field] = $newValues1[$field];
				}
			}
		}
	}
}
