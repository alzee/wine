#!/bin/bash
#
# vim:ft=sh

find src/ -type f ! -name *.png -exec echo // {} >> code.txt \; -exec cat {} >> code.txt  \; -exec echo >> code.txt \;
[ -d public/ ] && mv code.txt public/
