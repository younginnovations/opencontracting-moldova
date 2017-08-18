#!/usr/bin/env bash

cd `dirname $0`

export DATABASE=`awk 'BEGIN{FS="="} {if(/DB_DATABASE/) print $2}' ../../.env`
export PUBLIC_PATH=`readlink -e ../../public`

if [ -s $PUBLIC_PATH/uploads/company.xlsx ]
then
    cd mongoscripts
     python dump_excel.py
     mongo localhost:27017/$DATABASE run_for_xlsx.js
     mongo localhost:27017/$DATABASE run_for_etenders.js
     mongo localhost:27017/$DATABASE verify.js > $PUBLIC_PATH/non-valid.txt
     cd ..
fi
