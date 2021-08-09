#!/usr/bin/env php
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
import os, inspect
import subprocess
import sys
import platform
import random

print("Installing dependencies")
subprocess.check_call([sys.executable, "-m", "pip", "install", "-r", os.path.dirname(os.path.abspath(inspect.getfile(inspect.currentframe()))) + "/requirements.txt"])
print("Running Bot")

import discord
from dotenv import load_dotenv
from discord.ext import commands, tasks
<?php if ($browser == 1) { ?>
from FireFoxBrowser import Browser
<?php } ?>
<?php if ($music == 1) { ?> 
from yt import YTDLSource
<?php } ?>

load_dotenv()
TOKEN = os.getenv('DISCORD_TOKEN')

intents = discord.Intents().all()
client = discord.Client(intents=intents)
bot = commands.Bot(command_prefix='>', intents=intents)

<?php if ($browser == 1) { ?>
#web browser object
Browser = Browser()
<?php } ?>

<?php if ($music == 1) { ?>
ffmpeg_options = {
    'options': '-vn'
}
<?php } ?>

@bot.event
async def on_ready():
    print(f'{bot.user.name} has connected to:')
    
    for guild in bot.guilds:
        print(f'{guild.name}\t|  id:{guild.id}')

@bot.event
async def on_command_error(ctx, error):
    if (isinstance(error, commands.errors.CommandNotFound)):
        await ctx.send("I can't do that I'm only a bot not a magic man!\nUse '>help' to see what I can do")

@bot.command(name="roll_dice", help="Roll some dice")
async def roll(ctx, number_of_dice: int = 1):
    if number_of_dice < 1:
        await ctx.send("\nHow do you roll less than 1 dice?")
    else:    
        dice = [random.choice(range(1, 7)) for i in range(number_of_dice)]
        msg = ", ".join([str(value) for value in dice])
        if number_of_dice > 1:
            total = sum(dice)
            msg += f'\nTotal = {total}'
        await ctx.send(msg)

@bot.command(name="flip_coin", help="Flip a coin")    
async def flip(ctx):
    sides = ["Heads", "Tails"]
    coin = sides[random.choice(range(0,2))]
    await ctx.send(coin)

@bot.command(name="hot_fuzz", help="I want a Hot Fuzz reference plz")
async def hotFuzz(ctx):
    references = ["Great big bushy beard!", 
                "When's your birthday?\n22nd Febuary\nWhat year?\nEvery year", 
                "Any luck catching them swans then?\nIt's just the one swan actually", 
                "NO DAD!",
                "Everybody and their mums packin' round here",
                "Have you ever fired two guns whilst jumping through the air?",
                "Is it true that there is a place in a mans head that if you shoot it, it will blow up?",
                "Quite like a little midnight gobble, ha ha!",
                "Fascism? Wonderful",
                "Nobody tells me nothin'",
                "We've got...red, or...white",
                "The greater good",
                "It's not murder, it's ketchup!",
                "It's alright Andy, it's just bolognese"]

    await ctx.send(references[random.choice(range(0,len(references)))])

<?php if ($browser == 1) { ?>
@bot.command(name="youtube", help="Find a youtube link")
async def search_youtube(ctx, *, query = "hot fuzz it's a shame yeahbuhwha"):
    try:
        link = await Browser.youtube(query)
        await ctx.send(link)
    except Exception as e:
        print(e)
        await ctx.send("It broke! Try again...")

@bot.command(name="wiki", help="Find info from wiki")
async def search_wiki(ctx, *, query = "Hot Fuzz"):
    try:
        text = await Browser.wiki(query)
        await ctx.send(text)
    except:
        await ctx.send("Could not find wiki page, are you sure it exists?")

@bot.command(name="google", help="Find some links from google (but it's not google because f*c* google XD)")
async def search_google(ctx, *, query = "Hot Fuzz"):
    try:
        links = await Browser.google(query)
        for link in links:
            await ctx.send(link)
    except Exception as e:
        print(e)
        await ctx.send("It broke! Try again...")
<?php } ?>

<?php if ($music == 1) { ?>
@bot.command(name="join", help="FuzzBot will join your current voice channel")
async def join(ctx):
    if not ctx.message.author.voice:
        await ctx.send(f'{ctx.message.author.name} is not connected to a voice channel, you must be in a voice channel for me to connect to!')
    else:
        channel = ctx.message.author.voice.channel
    await channel.connect()

@bot.command(name="leave", help="FuzzBot will leave the voice channel they are currently in")
async def leave(ctx):
    voice_client = ctx.message.guild.voice_client
    if voice_client.is_connected():
        await voice_client.disconnect()
    else:    
        await ctx.send("I am not in a voice channel, fool")

@bot.command(name="play", help="Music!")
async def play(ctx, *, url = "https://www.youtube.com/watch?v=dQw4w9WgXcQ"):
    #connect bot to voice client if not already
    try:
        ctx.message.guild.voice_client.is_connected()
    except:
        await join(ctx)
            
    #get url of video if not provided        
    if len(url) < 9 or url[0:8] != "https://": 
        url = await Browser.youtube(url)

    voice_client = ctx.message.guild.voice_client

    try:
        async with ctx.typing():
            filename = await YTDLSource.from_url(url, loop=bot.loop)
            if platform.system() == "Windows":
                voice_client.play(discord.FFmpegPCMAudio(executable="./Music/ffmpeg.exe", source=filename))    
            else:
                voice_client.play(discord.FFmpegPCMAudio(executable="./Music/ffmpeg", source=filename))    
        await ctx.send(f'Now playing: {filename[6:]}')
    except Exception as e:
        print(e)
        await ctx.send("It broke! Try again...")

@bot.command(name="pause", help="Stop music for a time")
async def pause(ctx):
    voice_client = ctx.message.guild.voice_client
    if voice_client.is_playing():
        await voice_client.pause()
    else:
        await ctx.send("Music cannot be stopped if there is no music")

@bot.command(name="resume", help="Carry on the music!")
async def resume(ctx):
    voice_client = ctx.message.guild.voice_client
    if voice_client.is_paused():
        await voice_client.resume()
    else:
        ctx.send("No music was stopped to be carried on")

@bot.command(name="stop", help="Stop music's life")
async def stop(ctx):
    voice_client = ctx.message.guild.voice_client
    if voice_client.is_playing():
        await voice_client.stop()
    else:
        await ctx.send("Music cannot be stopped if there is no music")
<?php } ?>

@bot.command(name="kill", help="Kill FuzzBot cleanly")
async def kill(ctx):
    await ctx.send("It's treason then...")

<?php if ($music == 1) { ?>
    for root, dirs, files in os.walk("./Music/"):
        for file in files:
            if file != "ffmpeg.exe" and file != "ffmpeg":
                os.remove(os.path.join(root, file))
<?php } ?>

<?php if ($browser == 1) { ?>
    Browser.quit()           
<?php } ?> 
    exit(0)

bot.run(TOKEN)    

