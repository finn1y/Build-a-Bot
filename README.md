# Build a Bot

A discord bot which can be built with different features included or not depending on use case

## Help

Usage: build-a-bot [-h/--help] [-c/--clean] [FEATURES] [(-t/--token TOKEN)/(--token=TOKEN)]
Options:
  -c, --clean           clean (delete) the bot files
  -h, --help            shows this message
  -t, --token=TOKEN     adds bot's TOKEN to the .env file, if not added here must be done manually

Features:
  -b, --browser         includes browser functionality in the bot
  -m, --music           includes functionality to play youtube videos in the bot

## Install

### Using the terminal/command line
1. clone the repo into a place of your choice

```
git clone https://github.com/finn1y/Build-a-Bot.git
```
2. Run the build binary (found in bin directory) for your system (note only Linux is currently available as a binary, windows can be compiled):
    
    ##### Linux
    ```
    ./build-a-bot [-h/--help] [-c/--clean] [FEATURES] [(-t/--token TOKEN)/(--token=TOKEN)]
    ```
    ##### Windows (must be compiled from main-win.cpp)
    ```
    .\build-a-bot [-h/--help] [-c/--clean] [FEATURES] [(-t/--token TOKEN)/(--token=TOKEN)]
    ```
    ##### MacOS (not yet supported)
    ```
    ./build-a-bot [-h/--help] [-c/--clean] [FEATURES] [(-t/--token TOKEN)/(--token=TOKEN)]
    ```
    TOKEN is the "TOKEN" found in the Bot section of an application on the [discord dev](https://discord.com/developers/) page
3. Run the bot

    ##### Linux/MacOS
    ```
    ./main/run.sh
    ```
    ##### Windows
    ```
    .\main\run.bat
    ```
4. Enjoy Your new bot's abilities!

## Creating a discord bot

A useful guide on how to create a discord bot from scratch can be found [here](https://www.howtogeek.com/364225/how-to-make-your-own-discord-bot/). All that you need to do is follow the "Getting Started" step and use the token as the "TOKEN" mentioned in the install guide above.   
