#!/bin/bash

#STYLE_COLOR
RED='\033[0;31m';
LIGHT_GREEN='\e[1;32m';
NC='\033[0m' # No Color

echo -e "${LIGHT_GREEN} Download FormDin by Git Clone ${NC}"
git clone https://github.com/bjverde/formDin.git
cd formDin;
echo -e "${LIGHT_GREEN} Move Base ${NC}"
mv -v base/ ../;
cd ..;
echo -e "${RED} Delete other files ${NC}"
rm -vfr formDin
echo -e "${LIGHT_GREEN} FormDin intallaed ${NC}"