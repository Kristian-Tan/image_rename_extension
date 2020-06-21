@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/image_rename_extension.php
php "%BIN_TARGET%" %*