<?php

$counter = 0;
$errors = array();

function rename_file($filename, $depth=0) {
    global $errors;
    $spaces = str_repeat(" ",$depth);
    $type = exif_imagetype($filename);
    $extensionMapping = array(
        IMAGETYPE_GIF => "gif",
        IMAGETYPE_JPEG => "jpg",
        IMAGETYPE_PNG => "png",
        IMAGETYPE_SWF => "swf",
        IMAGETYPE_PSD => "psd",
        IMAGETYPE_BMP => "bmp",
        IMAGETYPE_TIFF_II => "tiff",
        IMAGETYPE_TIFF_MM => "tiff",
        IMAGETYPE_JPC => "jpc",
        IMAGETYPE_JP2 => "jp2",
        IMAGETYPE_JPX => "jpx",
        IMAGETYPE_JB2 => "jb2",
        IMAGETYPE_SWC => "swc",
        IMAGETYPE_IFF => "iff",
        IMAGETYPE_WBMP => "wbmp",
        IMAGETYPE_XBM => "xbm",
        IMAGETYPE_ICO => "ico",
        IMAGETYPE_WEBP => "webp"
    );
    if($type === false) {
        return;
    }
    else {
        $pathinfo = pathinfo($filename);
        $oldname = $pathinfo["dirname"] . "/" . $pathinfo["filename"] . "." . $pathinfo["extension"];
        $newname = $pathinfo["dirname"] . "/" . $pathinfo["filename"] . "." . $extensionMapping[$type];
        if($oldname != $newname) {
            $rename_result = rename($oldname, $newname);
            if($rename_result)
            {
                echo $spaces . "success rename: `" . $oldname . "` to `" . $newname . "`" . "\r\n";
            }
            else
            {
                $errors[] = array("oldname"=>$oldname, "newname"=>$newname);
                echo $spaces . "fail to rename: `" . $oldname . "` to `" . $newname . "`" . "\r\n";
            }

        }
    }
}

function iterate_directory($base, $depth=0) {
    global $counter;

    //echo "exploring $base" . "\r\n";
    $arrPath = glob($base."*");
    foreach ($arrPath as $path) {
        $counter++;
        //if($base == "*") $currentFullPath = $path;
        //else $currentFullPath = $base."/".$path."/";
        //$currentFullPath = $path."/";
        //echo "iterating $currentFullPath" . "\r\n";
        if( is_dir($path) )
        {
            //echo "  entering directory: $currentFullPath" . "\r\n";
            iterate_directory($path."/", $depth+1);
        }
        else
        {
            //echo "  not a directory: $currentFullPath" . "\r\n";
            rename_file($path, $depth);
        }
    }
}

$options = getopt("f::"); //var_dump($options);
if(isset($options["f"])) $base = $options["f"];
else $base = getcwd();

iterate_directory($base);

echo "done, " . $counter . " file(s) / folder(s) processed" . "\r\n";
echo "errors: " . count($errors) . "\r\n";
foreach ($errors as $key => $value) {
    echo "-" . $value["oldname"] . " => " . $value["newname"] . "\r\n";
}
