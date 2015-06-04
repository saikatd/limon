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


OS_Version=`uname -mrs`
Time=`date`
UP_Time=`uptime -p | cut -d " " -f2-`
printf '{"hostname":"%s","used memory":%f,"total memory":%f,"cpu usage":%f,"time":"%s","os_version":"%s","up_time":"%s"}\n' "$Hostname" "$used_memory" "$total_memory" "$CPU" "$Time" "$OS_Version" "$UP_Time"
