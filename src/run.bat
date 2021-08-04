ECHO OFF

IF EXIST "%PROGRAMFILES%\Python39\python.exe" (
    SET python_path="%PROGRAMFILES%\Python39\python.exe"
)

IF EXIST "%PROGRAMFILES(x86)%\Python39\python.exe" (
    SET python_path="%PROGRAMFILES(x86)%\Python39\python.exe"
)

IF EXIST "%LOCALAPPDATA%\Programs\Python\Python39\python.exe" (
    SET python_path="%LOCALAPPDATA%\Programs\Python\Python39\python.exe"
)

.\env\Scripts\activate && %python_path% .\main\Bot.py
