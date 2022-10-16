#!/bin/bash
#
# vim:ft=sh

find src/ -type f -exec echo // {} >> code.txt \; -exec cat {} >> code.txt  \; -exec echo >> code.txt \;
mv code.txt public/
