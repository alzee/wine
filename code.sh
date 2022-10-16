#!/bin/bash
#
# vim:ft=sh

find src/ ~/w/taro.wine/src/ -type f ! -name *.png -exec echo // {} >> code.txt \; -exec cat {} >> code.txt  \; -exec echo >> code.txt \;
[ -d public/ ] && mv code.txt public/
