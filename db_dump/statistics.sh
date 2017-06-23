#!/usr/bin/env bash

# Generate statistics of various process of procurement based on statistics json for validation

lists=('tenderList' 'contractList' 'intentionAnounceList')
startYear=2012
endYear=`date +%Y`

cd ./data/statistics
for list in "${lists[@]}"
do
echo $list
for year in $(seq $startYear $endYear)
    do
    echo $year: `find ${year}-* |xargs  jq ".${list}" | awk '{sum += $1} END{print sum}'`
    done
done

