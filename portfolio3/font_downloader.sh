!/bin/bash

# ------------------------------------------------------------------------
# This was adapted from:
# https://github.com/cstrap/monaco-font/blob/master/install-font-ubuntu.sh
# Note that I DID NOT write the script only adapted it by hard-coding
# one of the URLs which worked reliably for me...
# ------------------------------------------------------------------------

URL='http://jorrel.googlepages.com/Monaco_Linux.ttf'
FILENAME=${URL##*/}
FONT_DIR=/usr/share/fonts/truetype/custom/

echo $FILENAME
echo $FONT_DIR

echo "Start install"
sudo mkdir -p $FONT_DIR

echo "Downloading font"
wget -c $URL

echo "Installing font"
sudo mv $FILENAME $FONT_DIR

echo "Updating font cache"
sudo fc-cache -f -v

echo "Enjoy"