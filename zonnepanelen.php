<?php
	// start error handling
	set_error_handler("errorHandler");
	register_shutdown_function("shutdownHandler");

	function errorHandler($error_level, $error_message, $error_file, $error_line, $error_context)
	{
		$error = "Error level: " . $error_level . " <br>\nError message:" . $error_message . " <br>\nfile:" . $error_file . " <br>\nline:" . $error_line;
		switch ($error_level) {
			case E_ERROR:
			case E_CORE_ERROR:
			case E_COMPILE_ERROR:
			case E_PARSE:
				mylog($error, "fatal");
				break;
			case E_USER_ERROR:
			case E_RECOVERABLE_ERROR:
				mylog($error, "error");
				break;
			case E_WARNING:
			case E_CORE_WARNING:
			case E_COMPILE_WARNING:
			case E_USER_WARNING:
				mylog($error, "warn");
				break;
			case E_NOTICE:
			case E_USER_NOTICE:
				mylog($error, "info");
				break;
			case E_STRICT:
				mylog($error, "debug");
				break;
			default:
				mylog($error, "warn");
		}
	}
	function shutdownHandler() //will be called when php script ends.
	{
		$lasterror = error_get_last();
		switch ($lasterror['type'])
		{
			case E_ERROR:
			case E_CORE_ERROR:
			case E_COMPILE_ERROR:
			case E_USER_ERROR:
			case E_RECOVERABLE_ERROR:
			case E_CORE_WARNING:
			case E_COMPILE_WARNING:
			case E_PARSE:
				$error = "[SHUTDOWN] level:" . $lasterror['type'] . " <br>\nmsg:" . $lasterror['message'] . " <br>\nfile:" . $lasterror['file'] . " <br>\nline:" . $lasterror['line'];
				mylog($error, "fatal");
		}
	}
	function mylog($error, $errlvl)
	{

		if($errlvl == "fatal") {
			echo "<div style=background-color:Red;color:white;>\n";
			echo "<p>We found a problem in the PHP code:<br>\n$errlvl  => $error<br>\n";
			echo "The website can't be shown until this issue is fixed.</p>\n";
			echo "</div>";
		} else {
			echo "<div style=background-color:orange;color:white;>\n";
			echo "<p>We found a problem in the PHP code: $errlvl  => $error<br>\n";
			echo "The website will likely lack infomation.</p>\n";
			echo "</div>";
		}
	}
	// end error handling
	if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
		include('general_functions.php');
	}
	include('config.php');
	include('main_zonnepanelen.php');
?>