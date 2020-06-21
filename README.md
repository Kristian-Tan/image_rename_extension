# image_rename_extension

## What is it?

- Tool to rename picture file to its correct extension
- example: a JPEG formatted file was named mypicture.png
- this tool will detect such file recursively, then rename it to mypicture.jpg

- require php to be able to call exif_imagetype
- tested on windows, not tested on linux

## Usage

common usage: copy image_rename_extension.php to your image directory
- ```cd myfolder```
- ```php image_rename_extension.php```

may also pass directory name in -f option:
- ```php image_rename_extension.php -fmyfolder```

to run from PATH in Windows:
- add php binary directory to PATH
- add image_rename_extension.php directory to PATH
- add ```.bat``` to PATHEXT
- ```image_rename_extension -fmyfolder```
