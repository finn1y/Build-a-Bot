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
#!/usr/bin/env bash

SYSTEM=`uname -s`

if [ "$(expr substr $SYSTEM 1 5)" == "Linux" -o "$(expr substr $SYSTEM 1 6)" == "Darwin" ]; then
    if [ "$(type -P unzip)" == "" ]; then
        echo "Installing unzip"
            
        if [ "$(expr substr $SYSTEM 1 5)" == "Linux" ]; then
            sudo apt install unzip
        elif [ "$(expr substr $SYSTEM 1 6)" == "Darwin" ]; then
            fink install unzip
        fi
    fi

<?php if ($browser == 1) { ?>
    if [ "$(type -P firefox)" == "" ]; then
        echo "Installing firefox"

        if [ "$(expr substr $SYSTEM 1 5)" == "Linux" ]; then
            sudo apt install firefox
        elif [ "$(expr substr $SYSTEM 1 6)" == "Darwin" ]; then
            fink install firefox
        fi
    fi
    
    if [ ! -e ./geckodriver/geckodriver ]; then
        echo "Downloading gecko driver"
        mkdir ./geckodriver

        if [ "$(expr substr $SYSTEM 1 5)" == "Linux" ]; then
            curl https://github.com/mozilla/geckodriver/releases/download/v0.29.1/geckodriver-v0.29.1-linux64.tar.gz -Lo ./geckodriver/geckodriver-v0.29.1.tar.gz
        elif [ "$(expr substr $SYSTEM 1 6)" == "Darwin" ]; then
            curl https://github.com/mozilla/geckodriver/releases/download/v0.29.1/geckodriver-v0.29.1-macos.tar.gz -Lo ./geckodriver/geckodriver-v0.29.1.tar.gz
        fi

        tar -xf ./geckodriver/geckodriver-v0.29.1.tar.gz -C ./geckodriver
        rm -rf ./geckodriver/geckodriver-v0.29.1.tar.gz
        chmod +x ./geckodriver/geckodriver
    fi

    cp -uf ./src/FireFoxBrowser.py ./main
<?php } ?>

<?php if ($music == 1) { ?>
    if [ ! -e ./Music/ffmpeg ]; then
        echo "Downloading ffmpeg"
        mkdir ./Music
        
        if [ "$(expr substr $SYSTEM 1 5)" == "Linux" ]; then
            curl https://johnvansickle.com/ffmpeg/releases/ffmpeg-release-amd64-static.tar.xz -Lo ./Music/ffmpeg-release-amd64.tar.xz
            tar -xf ./Music/ffmpeg-release-amd64.tar.xz -C ./Music
            mv -t ./Music/ ./Music/ffmpeg-4.4-amd64-static/ffmpeg
        elif [ "$(expr substr $SYSTEM 1 6)" == "Darwin" ]; then
            curl https://evermeet.cx/ffmpeg/ffmpeg-4.4.zip -Lo ./Music/ffmpeg-4.4.zip
            unzip -q ./Music/ffmpeg-4.4.zip -d ./Music
        fi
        
        find ./Music/ \( ! -name "ffmpeg" ! -wholename "./Music/" \) -delete
        chmod +x ./Music/ffmpeg
    fi

    cp -uf ./src/yt.py ./main
<?php } ?>

    if [ "$(type -P python3)" == "" ]; then
        echo "Installing python"
            
        if [ "$(expr substr $SYSTEM 1 5)" == "Linux" ]; then
            sudo apt install python3
        elif [ "$(expr substr $SYSTEM 1 6)" == "Darwin" ]; then
            fink install python3
        fi
    fi

    if [ "$(type -P pip)" == "" ]; then
        echo "Installing pip"

        if [ "$(expr substr $SYSTEM 1 5)" == "Linux" ]; then
            sudo apt install python3-pip     
            sudo apt install python3-venv
        elif [ "$(expr substr $SYSTEM 1 6)" == "Darwin" ]; then
            fink install python3-pip
            fink install python3-venv
        fi
    fi

    if [ ! -e ./env ]; then
        echo "Setting up environment"
        python3 -m venv env
    fi
elif [ "$(expr substr $SYSTEM 1 10)" == "MINGW64_NT" -o "$(expr substr $SYSTEM 1 10)" == "MINGW32_NT" ]; then
<?php if ($browser == 1) { ?>
    if [ ! -e ./geckodriver/geckodriver.exe ]; then
        echo "Downloading gecko driver"
        mkdir ./geckodriver
        curl https://github.com/mozilla/geckodriver/releases/download/v0.29.1/geckodriver-v0.29.1-win64.zip -Lo ./geckodriver/geckodriver-v0.29.1.zip
        unzip -q ./geckodriver/geckodriver-v0.29.1.zip -d ./geckodriver
        rm -rf ./geckodrver/geckodriver-v0.29.1.zip
    fi

    cp -uf ./src/FireFoxBrowser.py ./main
<?php } ?>

<?php if ($music == 1) { ?>
    if [ ! -e ./Music/ffmpeg.exe ]; then
        echo "Downloading ffmpeg"
        mkdir ./Music
        curl https://github.com/GyanD/codexffmpeg/releases/download/4.4/ffmpeg-4.4-essentials_build.zip -Lo ./Music/ffmpeg-2021-07-06-git-758e2da289-essentials_build.zip
        unzip -q ./Music/ffmpeg-2021-07-06-git-758e2da289-essentials_build.zip -d ./Music
        mv -t ./Music ./Music/ffmpeg-4.4-essentials_build/bin/ffmpeg.exe
        rm -rf ./Music/ffmpeg-4.4-essentials_build ./Music/ffmpeg-2021-07-06-git-758e2da289-essentials_build.zip
    fi

    cp -uf ./src/yt.py ./main
<?php } ?>

    if [ "$(type -P python3)" == "" ]; then
        if [ ! -e ./python-3.9.6-amd64.exe ]; then
            echo "Downloading Python installer"
            curl https://www.python.org/ftp/python/3.9.6/python-3.9.6-amd64.exe -Lo ./python-3.9.6-amd64.exe
        fi

        echo "Installing python"
        ./python-3.9.6-amd64.exe /quiet PrependPath=1 Include_pip=1 Include_tcltk=0 Include_test=0
        rm -rf ./python-3.9.6-amd64.exe
    fi

    if [ ! -e ./env ]; then
        echo "Setting up environment"
        python -m venv env
    fi
fi


