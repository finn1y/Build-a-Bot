FLAGS=--browser --music

ifeq ($(OS), Windows_NT) 
	detected_OS := Windows
	RMFLAGS := -recurse -force
	MKDIRFLAGS :=  
else
	detected_OS := $(shell sh -c 'uname 2>/dev/null || echo Unknown')
	RMFLAGS := -rf
	MKDIRFLAGS := -p
endif

all: $(detected_OS)

.PHONY: Windows Linux Darwin main clean  

Windows: main
	mkdir bin
	php .\src\build.bat.php $(FLAGS) > bin\build.bat
	cp src\run.bat bin
	.\bin\build.bat

Linux: main
	mkdir -p bin
	php ./src/build.sh.php $(FLAGS) > bin/build.sh
	cp -uf src/run.sh bin
	./bin/build.sh

Darwin: main
	mkdir -p bin
	php ./src/build.sh.php $(FLAGS) > bin/build.sh
	cp -uf src/run.sh bin
	./bin/build.sh

main:
	mkdir $(MKDIRFLAGS) main
	php ./src/Bot.py.php $(FLAGS) > main/Bot.py
	php ./src/requirements.txt.php $(FLAGS) > main/requirements.txt

clean:
	rm ./main ./bin ./env ./Music ./geckodriver $(RMFLAGS)
