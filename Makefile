.PHONY: all
all: build run
	

.PHONY: build
build:
	docker build -t sccommunity-webapp .

.PHONY: run
run:
	docker run -p 1337:80 --rm -it --name sccommunity-webapp-test -v`pwd`/app:/var/www/html sccommunity-webapp

.PHONY: vuln_list
vuln_list:
	base64 vuln_list.txt > vuln_list.txt.base64
