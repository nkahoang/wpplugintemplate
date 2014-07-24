<?php
if (!isset($_REQUEST["name"])) {
    die("Invalid plugin name");
}
if (!isset($_REQUEST["prefix"])) {
    die("Invalid plugin prefix");
}
if (!isset($_REQUEST["uri"])) {
    die("Invalid plugin URI");
}
$plugin_name = $_REQUEST["name"];
$plugin_prefix = $_REQUEST["prefix"];
$plugin_uri = $_REQUEST["uri"];
$plugin_prefix = str_replace(" ","_",$plugin_prefix);

function dirToArray($dir) {
    $result = array();

    $cdir = scandir($dir);
    foreach ($cdir as $key => $value)
    {
        if (!in_array($value,array(".","..")))
        {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
            {
                $result = array_merge($result, dirToArray($dir . DIRECTORY_SEPARATOR . $value));
            }
            else
            {
                $result[] = $dir . DIRECTORY_SEPARATOR . $value;
            }
        }
    }

    return $result;
}
/* creates a compressed zip file */
function create_zip($files = array(),$destination = '',$basename= '',$overwrite = false,$options) {
    if (!$destination) {
        $tmpFile = tmpfile();
        $metaDatas = stream_get_meta_data($tmpFile);
        $destination = $metaDatas['uri'];
        $overwrite=true;
    }

    //if the zip file already exists and overwrite is false, return false
    if(file_exists($destination) && !$overwrite) { return false; }
    if (!file_exists($destination) && $overwrite) {$overwrite = false;}
    //vars
    $valid_files = array();
    //if files were passed in...
    if(is_array($files)) {
        //cycle through each file
        foreach($files as $file) {
            //make sure the file exists
            if(file_exists($file)) {
                $valid_files[] = $file;
            }
        }
    }
    $plugin_name = strtolower($options['prefix']) . "_plugin";
    //if we have good files...
    if(count($valid_files)) {
        //create the archive
        $zip = new ZipArchive();
        $result = $zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE);

        if(!$result) {
            return false;
        }

        //add the files
        foreach($valid_files as $file) {
            $data = file_get_contents($file);
            $localname = str_replace($basename, "$plugin_name" . DIRECTORY_SEPARATOR, $file);
            if (strpos($localname, "wme_plugin.php") > 0) {
                $localname = str_replace("wme_plugin.php","$plugin_name.php",$localname);
                $data = str_replace("%%PLUGIN_NAME%%", $options["name"], $data);
                $data = str_replace("%%PLUGIN_URI%%", $options["uri"], $data);
            }
            $zip->addFromString($localname, str_replace("WME",$options['prefix'],$data));
        }
        //debug
        //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;

        //close the zip -- done!
        $zip->close();

        //check to make sure the file exists
        return $destination;
    }
    else
    {
        return false;
    }
}
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

$base_name = __DIR__ . "/template";
$files_to_zip = dirToArray($base_name);
$name = generateRandomString(20) . ".zip";
$file_name = __DIR__ . "/tmp/$name";
//if true, good; if false, zip creation failed
$options = array(
    "name" => $plugin_name,
    "prefix" => $plugin_prefix,
    "uri" => $plugin_uri
);
$result = create_zip($files_to_zip, $file_name, $base_name . DIRECTORY_SEPARATOR, true, $options);
$download_file_name = str_replace(" ","_",$plugin_name) . "_" . date_format(new \DateTime(), "Y_m_d__H_i_s");
header("Content-Type: application/zip");
header("Content-Disposition: attachment; filename=$download_file_name.zip");
header("Content-Length: " . filesize($result));

readfile($result);
unlink($result);