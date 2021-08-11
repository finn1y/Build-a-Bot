#include <cstdlib>
#include <cstdio>
#include <cstring>
#include <string>

unsigned int flag_mask = 0;
std::string token;

void help();
void clean();
void make();

int main(int argc, char** argv) {
    //parse arguments
    for (int i = 0; i < argc; i++) {
        std::string arg = std::string(argv[i]);
                
        if (arg == "--help" || arg == "-h") {
            help();
            return 0;
        }
        else if (arg == "--clean" || arg == "-c") {
            clean();
            return 0;
        }
        else {
            if (arg == "--browser" || arg == "-b") flag_mask |= 0b01;
            if (arg == "--music" || arg == "-m") flag_mask |= 0b10;

            if (arg.substr(0,8) == "--token=") {
                token = arg.substr(8, std::string::npos);
            }
            else if (arg.substr(0,7) == "--token" || arg == "-t") {
                i++;
                token = std::string(argv[i]);    
            }
        }
    }

    make();
    return 0;
}

void help() {
    printf("Usage: build-a-bot [-h/--help] [-c/--clean] [FEATURES] [(-t/--token TOKEN)/(--token=TOKEN)]\n");    
    printf("Options:\n");
    printf("  -c, --clean\t\tclean (delete) the bot files\n");
    printf("  -h, --help\t\tshows this message\n");
    printf("  -t, --token=TOKEN\tadds bot's TOKEN to the .env file, if not added here must be done manually\n");
    printf("\nFeatures:\n");
    printf("  -b, --browser\t\tincludes browser functionality in the bot\n");
    printf("  -m, --music\t\tincludes functionality to play youtube videos in the bot\n");
}

void clean() {
    system("rm -rf main/ env/ geckodriver/ Music/");
}

void make() {
    std::string flags;

    system("mkdir -p main");

    if (flag_mask & 0b01) {
            flags += " --browser";
            system("cp -f ./src/FireFoxBrowser.py ./main");
    }
    if (flag_mask & 0b10) {
            flags += " --music";
            system("cp -f ./src/yt.py ./main");
    }

    char buffer[150];
    sprintf(buffer, "echo DISCORD_TOKEN=%s > main/.env", token.c_str());
    system(buffer);

    sprintf(buffer, "php ./src/run.sh.php%s > main/run.sh", flags.c_str());
    system(buffer);

    sprintf(buffer, "php ./src/Bot.py.php%s > main/Bot.py", flags.c_str());
    system(buffer);

    sprintf(buffer, "php ./src/requirements.txt.php%s > main/requirements.txt", flags.c_str());
    system(buffer);
}


