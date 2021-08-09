# Build a Bot

A discord bot which can be built with different features included or not depending on use case

## Options

#### Browser
```
-b/--browser
```
Provides the bot with web searching capabilities, including: google, wikipedia and youtube

#### Music
```
-m/--music
```
Provides the bot with sound playing features for youtube videos

## Install

### Using the terminal/command line
1. clone the repo into a place of your choice

```
git clone https://github.com/finn1y/Build-a-Bot.git
```
2. Run the build binary for your system (note the binaries require compiling from main.cpp and currently only Linux is supported):
    
    ##### Linux
    ```
    ./build-linux64 [options] (-t/--token discord_token)/(--token=discord_token)
    ```
    ##### Windows (not supported by main.cpp)
    ```
    .\build-win64 [options] (-t/--token discord_token)/(--token=discord_token)
    ```
    ##### MacOS (not supported by main.cpp)
    ```
    ./build-macOS [options] (-t/--token discord_token)/(--token=discord_token)
    ```
    discord_token is the 'TOKEN' found in the Bot section of an application on the (discord dev)[https://discord.com/developers/] page
3. Run the bot

    ##### Linux/MacOS
    ```
    ./bin/run.sh
    ```
    ##### Windows
    ```
    .\bin\run.bat
    ```
4. Enjoy Your new bot's abilities!
