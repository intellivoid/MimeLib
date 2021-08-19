clean:
	rm -rf build

update:
	ppm --generate-package="src/MimeLib"

build:
	mkdir build
	ppm --no-intro --compile="src/MimeLib" --directory="build"

install:
	ppm --no-intro --no-prompt --fix-conflict --install="build/net.intellivoid.mimelib.ppm"