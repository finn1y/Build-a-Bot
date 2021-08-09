<?php 
$browser = 0;
$music = 0;

foreach($argv as $arg) { 
    switch ($arg) {
        case "--browser":
            $browser = 1;
            break;
        case "--music":
            $music = 1;
            break;
    }
} ?>
ECHO OFF

<?php if ($browser == 1) { ?>
IF NOT EXIST ".\geckodriver\geckodriver.exe" (
    ECHO Downloading gecko driver
    MKDIR .\geckodriver\
    curl https://github.com/mozilla/geckodriver/releases/download/v0.29.1/geckodriver-v0.29.1-win64.zip -L -o .\geckodriver\geckodriver-v0.29.1-win64.zip
    PowerShell Expand-Archive -Path .\geckodriver\geckodriver-v0.29.1-win64.zip -DestinationPath .\geckodriver
    DEL /Q /F .\geckodriver\geckodriver-v0.29.1-win64.zip
)

COPY /Y /V .\src\FireFoxBrowser.py .\main
<?php } ?>

<?php if ($music == 1) { ?>
IF NOT EXIST ".\Music\ffmpeg.exe" (
    ECHO Downloading ffmpeg
    MKDIR .\Music\
    curl https://github.com/GyanD/codexffmpeg/releases/download/4.4/ffmpeg-4.4-essentials_build.zip -L -o .\Music\ffmpeg-2021-07-06-git-758e2da289-essentials_build.zip
    PowerShell Expand-Archive -Path .\Music\ffmpeg-2021-07-06-git-758e2da289-essentials_build.zip -DestinationPath .\Music
    MOVE /Y .\Music\ffmpeg-4.4-essentials_build\bin\ffmpeg.exe .\Music 
    RMDIR /Q /S .\Music\ffmpeg-4.4-essentials_build 
    DEL /Q /F .\Music\ffmpeg-2021-07-06-git-758e2da289-essentials_build.zip
)

COPY /Y /V .\src\yt.py .\main
<?php } ?>

SET path_found=0
IF EXIST "%PROGRAMFILES%\Python39\python.exe" (
    SET python_path="%PROGRAMFILES%\Python39\python.exe"
    SET path_found=1
)

IF EXIST "%PROGRAMFILES(x86)%\Python39\python.exe" (
    SET python_path="%PROGRAMFILES(x86)%\Python39\python.exe"
    SET path_found=1
)

IF EXIST "%LOCALAPPDATA%\Programs\Python\Python39\python.exe" (
    SET python_path="%LOCALAPPDATA%\Programs\Python\Python39\python.exe"
    SET path_found=1
)

IF %path_found% == 0 (
    IF NOT EXIST ".\python-3.9.6-amd64.exe" (
        ECHO Downloading Python installer
        curl https://www.python.org/ftp/python/3.9.6/python-3.9.6-amd64.exe -o .\python-3.9.6-amd64.exe
    )
    ECHO Installing python
    .\python-3.9.6-amd64.exe /quiet PrependPath=1 Include_pip=1 Include_tcltk=0 Include_test=0
    SET python_path="%LOCALAPPDATA%\Programs\Python\Python39\python.exe"
    DEL .\python-3.9.6-amd64.exe
)

IF NOT EXIST ".\env" (
    ECHO Setting up environment
    %python_path% -m venv env
)

.\env\Scripts\activate.bat && %python_path% .\main\Bot.py
