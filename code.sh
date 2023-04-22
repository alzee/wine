#!/bin/bash
#
# vim:ft=sh

file=code.txt

echo -e // 后端\\n > $file
find src/ -type f -exec echo // {} >> $file \; -exec cat {} >> $file  \; -exec echo >> $file \;

echo -e // 前端\\n >> $file
find ~/w/taro.jiu/src/ -type f ! -name *.png -exec echo // {} >> $file \; -exec cat {} >> $file  \; -exec echo >> $file \;

[ -d public/ ] && mv $file public/
