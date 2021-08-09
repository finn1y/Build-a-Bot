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

    printf("%s\n", token.c_str());
    make();
    return 0;
}

void help() {
    printf("Usage: build [-h/--help] [-c/--clean] [-b/--browser] [-m/--music] [(-t/--token token)/(--token=token)]\n");    
}

void clean() {
    system("rm -rf bin/ main/ env/ geckodriver/ Music/");
}

void make() {
    std::string flags;

    system("mkdir -p bin main");

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

    sprintf(buffer, "php ./src/run.sh.php%s > bin/run.sh", flags.c_str());
    system(buffer);

    sprintf(buffer, "php ./src/Bot.py.php%s > main/Bot.py", flags.c_str());
    system(buffer);

    sprintf(buffer, "php ./src/requirements.txt.php%s > main/requirements.txt", flags.c_str());
    system(buffer);
}


