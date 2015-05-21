#!/bin/bash
Hostname=`hostname`
total_memory=`free | grep Mem | awk '{print  $2/1024}'`
used_memory=`free | grep Mem | awk '{print  $3/1024}'`
#echo "memory usage: $Memory "
CPU=`grep 'cpu ' /proc/stat | awk '{usage=($2+$4)*100/($2+$4+$5)} END {print usage}'`
#echo "cpu usage : $CPU"
#echo "Filesystem      usage"
DISK=`df |  awk '{ if (NR==2) print $1 "        " $5 }'`
#echo  "$DISK"


ruptime="$( uptime)"
  if $(echo $ruptime | grep -E "min|days" >/dev/null); then
    x=$(echo $ruptime | awk '{ print $3 $4}')
  else
    x=$(echo $ruptime | sed s/,//g| awk '{ print $3 " (hh:mm)"}')
  fi
#echo $x
printf '{"hostname":%s,"used memory":%s,"total memory":%s,"cpu usage":%s}\n' "$Hostname" "$used_memory" "total_memory" "$CPU" 

