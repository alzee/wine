#!/bin/bash
#
# vim:ft=sh

find src/ -type f -exec echo // {} >> code \; -exec cat {} >> code  \; -exec echo >> code \;
mv code public/
