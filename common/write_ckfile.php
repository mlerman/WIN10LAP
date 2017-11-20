<?php
$strtarget=$_GET['target'];
$pos=strrpos($strtarget, "/");
$ftarget=substr($strtarget, $pos+1);
$dir=substr($strtarget, 0, $pos);


//file_put_contents("debug.txt", "target=".$_GET['target']."\nvalue=".$_GET['value']);
$status=$_GET['value']=="true"?"checked":"";
if($ftarget==".ckpasswd") $status="checked";  // password protect cannot be un-checked
file_put_contents($strtarget, $status );

if ($ftarget==".ckgithub"){
  if($_GET['value']=="true") {
    $bool=copy("c:\\UniServer\\www\\doc\\files\\Engineering\\ENVIRONMENT\\WINDOWS_BATCH\\github_commands\\ui_git_download_changes_from_github_to_this_directory.bat", $dir."/"."ui_git_download_changes_from_github_to_this_directory.bat");
    //file_put_contents("debug.txt", $bool);
    copy("c:\\UniServer\\www\\doc\\files\\Engineering\\ENVIRONMENT\\WINDOWS_BATCH\\github_commands\\ui_git_upload_changes_to_github.bat", $dir."/"."ui_git_upload_changes_to_github.bat");
    copy("c:\\UniServer\\www\\doc\\files\\Engineering\\ENVIRONMENT\\WINDOWS_BATCH\\github_commands\\ui_git_create_repo_from_this_directory.bat", $dir."/"."ui_git_create_repo_from_this_directory.bat");
    //copy("c:\\UniServer\\www\\doc\\files\\Engineering\\ENVIRONMENT\\WINDOWS_BATCH\\github_commands\\ui_github_client.bat", $dir."/"."ui_github_client.bat");
    copy("c:\\UniServer\\www\\doc\\files\\Engineering\\ENVIRONMENT\\WINDOWS_BATCH\\github_commands\\.gitignore", $dir."/".".gitignore");
  } else {
    //file_put_contents("debug.txt", "unlink");

    unlink($dir."/"."ui_git_download_changes_from_github_to_this_directory.bat");
    unlink($dir."/"."ui_git_upload_changes_to_github.bat");
    unlink($dir."/"."ui_git_create_repo_from_this_directory.bat");
    //unlink($dir."/"."ui_github_client.bat");
  }
}

//file_put_contents("debug.txt", "source="."c:\\UniServer\\www\\doc\\files\\ThisPC\\htpasswd\\.htaccess"."\ndest="$dir."/".".htaccess");
if ($ftarget==".ckpasswd"){
  if($_GET['value']=="true") {
    copy("c:\\UniServer\\www\\doc\\files\\ThisPC\\htpasswd\\.htaccess", $dir."/".".htaccess");
  }
}


if ($ftarget==".ckftpx"){
  if($_GET['value']=="true") {
    $bool=copy("c:\\UniServer\\www\\doc\\files\\Engineering\\ENVIRONMENT\\WINDOWS_BATCH\\ftp_commands\\ui_ftp_upload.bat", $dir."/"."ui_ftp_upload.bat");
    $bool=copy("c:\\UniServer\\www\\doc\\files\\Engineering\\ENVIRONMENT\\WINDOWS_BATCH\\ftp_commands\\ui_ftp_download.bat", $dir."/"."ui_ftp_download.bat");
    $bool=copy("c:\\UniServer\\www\\doc\\files\\Engineering\\ENVIRONMENT\\WINDOWS_BATCH\\ftp_commands\\ui_set_env_variable_UPLOADFILE_input.bat", $dir."/"."ui_set_env_variable_UPLOADFILE_input.bat");
    $bool=copy("c:\\UniServer\\www\\doc\\files\\Engineering\\ENVIRONMENT\\WINDOWS_BATCH\\ftp_commands\\ui_set_env_variable_UPLOADDIR_input.bat", $dir."/"."ui_set_env_variable_UPLOADDIR_input.bat");
  } else {
    unlink($dir."/"."ui_ftp_upload.bat");
    unlink($dir."/"."ui_ftp_download.bat");
    unlink($dir."/"."ui_set_env_variable_UPLOADFILE_input.bat");
    unlink($dir."/"."ui_set_env_variable_UPLOADDIR_input.bat");
  }
}


if ($ftarget==".ckrun"){
  if($_GET['value']=="true") {
    if (!file_exists($dir."/"."ui_run.run")) $bool=copy("c:\\UniServer\\www\\common\\open_command_files\\ui_run.run", $dir."/"."ui_run.run");
  } else {
  
    if(sha1_file($dir."/"."ui_run.run")==sha1_file("c:\\UniServer\\www\\common\\open_command_files\\ui_run.run")) {  // delete only if it was not modified
      unlink($dir."/"."ui_run.run");
    }
  
  
  }
}

if ($ftarget==".cklrun"){
  if($_GET['value']=="true") {
    if (!file_exists($dir."/"."run.rn")) $bool=copy("c:\\UniServer\\www\\common\\open_command_files\\run.rn", $dir."/"."run.rn");
  } else {
  
    if(sha1_file($dir."/"."run.rn")==sha1_file("c:\\UniServer\\www\\common\\open_command_files\\run.rn")) {  // delete only if it was not modified
      unlink($dir."/"."run.rn");
    }
  }
}

if ($ftarget==".cklcd"){
  if($_GET['value']=="true") {
    if (!file_exists($dir."/"."krusader.rn")) $bool=copy("c:\\UniServer\\www\\common\\open_command_files\\krusader.rn", $dir."/"."krusader.rn");
  } else {
  
    if(sha1_file($dir."/"."krusader.rn")==sha1_file("c:\\UniServer\\www\\common\\open_command_files\\krusader.rn")) {  // delete only if it was not modified
      unlink($dir."/"."krusader.rn");
    }
  }
}


if ($ftarget==".cklver"){
  if($_GET['value']=="true") {
    if (!file_exists($dir."/"."version.rn")) $bool=copy("c:\\UniServer\\www\\common\\open_command_files\\version.rn", $dir."/"."version.rn");
  } else {
  
    if(sha1_file($dir."/"."version.rn")==sha1_file("c:\\UniServer\\www\\common\\open_command_files\\version.rn")) {  // delete only if it was not modified
      unlink($dir."/"."version.rn");
    }
  }
}


if ($ftarget==".ckhlp"){
  if($_GET['value']=="true") {
    if (!file_exists($dir."/"."ui_help.run")) $bool=copy("c:\\UniServer\\www\\common\\open_command_files\\ui_help.run", $dir."/"."ui_help.run");
  } else {

    if(sha1_file($dir."/"."ui_help.run")==sha1_file("c:\\UniServer\\www\\common\\open_command_files\\ui_help.run")) {  // delete only if it was not modified
      unlink($dir."/"."ui_help.run");
    }


  }
}

if ($ftarget==".ckpdf"){
  if($_GET['value']=="true") {
    if (!file_exists($dir."/"."ui_showpdf.run")) $bool=copy("c:\\UniServer\\www\\common\\open_command_files\\ui_showpdf.run", $dir."/"."ui_showpdf.run");
  } else {

    if(sha1_file($dir."/"."ui_showpdf.run")==sha1_file("c:\\UniServer\\www\\common\\open_command_files\\ui_showpdf.run")) {  // delete only if it was not modified
      unlink($dir."/"."ui_showpdf.run");
    }


  }
}


if ($ftarget==".ckpty"){
  if($_GET['value']=="true") {
    if (!file_exists($dir."/"."ui_putty_com.run")) $bool=copy("c:\\UniServer\\www\\common\\open_command_files\\ui_putty_com.run", $dir."/"."ui_putty_com.run");
  } else {
    if(sha1_file($dir."/"."ui_putty_com.run")==sha1_file("c:\\UniServer\\www\\common\\open_command_files\\ui_putty_com.run")) {  // delete only if it was not modified
      unlink($dir."/"."ui_putty_com.run");
    }
  }
}

if ($ftarget==".ckssh"){
  if($_GET['value']=="true") {
    if (!file_exists($dir."/"."ui_putty_ssh.run")) {
		$bool=copy("c:\\UniServer\\www\\common\\open_command_files\\ui_putty_ssh.run", $dir."/"."ui_putty_ssh.run");
		$bool=copy("c:\\UniServer\\www\\common\\open_command_files\\get_zedboard_IP.bat", $dir."/"."get_zedboard_IP.bat");
		}
  } else {
    if(sha1_file($dir."/"."ui_putty_ssh.run")==sha1_file("c:\\UniServer\\www\\common\\open_command_files\\ui_putty_ssh.run")) {  // delete only if it was not modified
      unlink($dir."/"."ui_putty_ssh.run");
      unlink($dir."/"."get_zedboard_IP.bat");
    }
  }
}

if ($ftarget==".ckscp"){
  if($_GET['value']=="true") {
    if (!file_exists($dir."/"."ui_winscp.run")) {
		$bool=copy("c:\\UniServer\\www\\common\\open_command_files\\ui_winscp.run", $dir."/"."ui_winscp.run");
		$bool=copy("c:\\UniServer\\www\\common\\open_command_files\\get_zedboard_IP.bat", $dir."/"."get_zedboard_IP.bat");
		}
  } else {
    if(sha1_file($dir."/"."ui_winscp.run")==sha1_file("c:\\UniServer\\www\\common\\open_command_files\\ui_winscp.run")) {  // delete only if it was not modified
      unlink($dir."/"."ui_winscp.run");
      unlink($dir."/"."get_zedboard_IP.bat");
    }
  }
}


if ($ftarget==".ckver"){
  if($_GET['value']=="true") {
    if (!file_exists($dir."/"."ui_version.run")) $bool=copy("c:\\UniServer\\www\\common\\open_command_files\\ui_version.run", $dir."/"."ui_version.run");
  } else {


    if(sha1_file($dir."/"."ui_version.run")==sha1_file("c:\\UniServer\\www\\common\\open_command_files\\ui_version.run")) {  // delete only if it was not modified
      unlink($dir."/"."ui_version.run");
    }

  }
}

if ($ftarget==".ckftp"){
  if($_GET['value']=="true") {
    if (!file_exists($dir."/"."ui_total_commander_ftp.run")) $bool=copy("c:\\UniServer\\www\\common\\open_command_files\\ui_total_commander_ftp.run", $dir."/"."ui_total_commander_ftp.run");
  } else {


    if(sha1_file($dir."/"."ui_total_commander_ftp.run")==sha1_file("c:\\UniServer\\www\\common\\open_command_files\\ui_total_commander_ftp.run")) {  // delete only if it was not modified
      unlink($dir."/"."ui_total_commander_ftp.run");
    }

  }
}

if ($ftarget==".ckcd"){
  if($_GET['value']=="true") {
    if (!file_exists($dir."/"."ui_total_commander.run")) $bool=copy("c:\\UniServer\\www\\common\\open_command_files\\ui_total_commander.run", $dir."/"."ui_total_commander.run");
  } else {


    if(sha1_file($dir."/"."ui_total_commander.run")==sha1_file("c:\\UniServer\\www\\common\\open_command_files\\ui_total_commander.run")) {  // delete only if it was not modified
      unlink($dir."/"."ui_total_commander.run");
    }
  }
}

if ($ftarget==".ckcod"){
  if($_GET['value']=="true") {
    if (!file_exists($dir."/"."ui_total_commander_src.run")) {
		$bool=copy("c:\\UniServer\\www\\common\\open_command_files\\ui_total_commander_src.run", $dir."/"."ui_total_commander_src.run");
		$bool=copy("c:\\UniServer\\www\\common\\open_command_files\\.gitignore", $dir."/".".gitignore");
		$bool=copy("c:\\UniServer\\www\\common\\open_command_files\\ui_codecompare.run", $dir."/"."ui_codecompare.run");
		$bool=copy("c:\\UniServer\\www\\common\\open_command_files\\ui_put.run", $dir."/"."ui_put.run");
		$bool=copy("c:\\UniServer\\www\\common\\open_command_files\\ui_get.run", $dir."/"."ui_get.run");
	}
  } else {

// faire plutot if exist get_cd_directory.bat
    if(!file_exists($dir."/"."get_cd_directory.bat")) {
    //if(sha1_file($dir."/"."ui_total_commander_src.run")==sha1_file("c:\\UniServer\\www\\common\\open_command_files\\ui_total_commander_src.run")) {  // delete only if it was not modified
      unlink($dir."/"."ui_total_commander_src.run");
      unlink($dir."/".".gitignore");
      unlink($dir."/"."ui_codecompare.run");
      unlink($dir."/"."ui_put.run");
      unlink($dir."/"."ui_get.run");
    }
  }
}



if ($ftarget==".ckreg"){
  if($_GET['value']=="true") {
    if (!file_exists($dir."/"."ai_regedit.run")) $bool=copy("c:\\UniServer\\www\\common\\open_command_files\\ai_regedit.run", $dir."/"."ai_regedit.run");
  } else {


    if(sha1_file($dir."/"."ai_regedit.run")==sha1_file("c:\\UniServer\\www\\common\\open_command_files\\ai_regedit.run")) {  // delete only if it was not modified
      unlink($dir."/"."ai_regedit.run");
    }

  }
}


if ($ftarget==".ckbld"){
  if($_GET['value']=="true") {
    if (!file_exists($dir."/"."ui_build.run")) $bool=copy("c:\\UniServer\\www\\common\\open_command_files\\ui_build.run", $dir."/"."ui_build.run");
  } else {


    if(sha1_file($dir."/"."ui_build.run")==sha1_file("c:\\UniServer\\www\\common\\open_command_files\\ui_build.run")) {  // delete only if it was not modified
      unlink($dir."/"."ui_build.run");
    }

  }
}


if ($ftarget==".ckbed"){
  if($_GET['value']=="true") {
    if (!file_exists($dir."/"."get_feu.bat")) $bool=copy("c:\\UniServer\\www\\common\\open_command_files\\get_feu.bat", $dir."/"."get_feu.bat");
  } else {


    if(sha1_file($dir."/"."get_feu.bat")==sha1_file("c:\\UniServer\\www\\common\\open_command_files\\get_feu.bat")) {  // delete only if it was not modified
      unlink($dir."/"."get_feu.bat");
    }

  }
}


if ($ftarget==".ckbie"){
  if($_GET['value']=="true") {
    if (!file_exists($dir."/"."ui_jump_to_with_ie.run")) $bool=copy("c:\\UniServer\\www\\common\\open_command_files\\ui_jump_to_with_ie.run", $dir."/"."ui_jump_to_with_ie.run");
  } else {


    if(sha1_file($dir."/"."ui_jump_to_with_ie.run")==sha1_file("c:\\UniServer\\www\\common\\open_command_files\\ui_jump_to_with_ie.run")) {  // delete only if it was not modified
      unlink($dir."/"."ui_jump_to_with_ie.run");
    }

  }
}

if ($ftarget==".ckjir"){
  if($_GET['value']=="true") {
    if (!file_exists($dir."/"."ui_jump_to_jira.run")) $bool=copy("c:\\UniServer\\www\\common\\open_command_files\\ui_jump_to_jira.run", $dir."/"."ui_jump_to_jira.run");
  } else {


    if(sha1_file($dir."/"."ui_jump_to_jira.run")==sha1_file("c:\\UniServer\\www\\common\\open_command_files\\ui_jump_to_jira.run")) {  // delete only if it was not modified
      unlink($dir."/"."ui_jump_to_jira.run");
      unlink($dir."/"."get_jira_num.bat");
    }

  }
}

?>