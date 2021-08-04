#!/usr/bin/env bash

SYSTEM=`uname -s`

if [ "$(expr substr $SYSTEM 1 5)" == "Linux" -o "$(expr substr $SYSTEM 1 6)" == "Darwin" ]; then
    ./env/bin/activate && python3 ./main/Bot.py
elif [ "$(expr substr $SYSTEM 1 10)" == "MINGW64_NT" -o "$(expr substr $SYSTEM 1 10)" == "MINGW32_NT" ]; then
    ./env/Scripts/activate && python ./main/Bot.py
fi


