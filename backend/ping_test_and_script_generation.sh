#!/bin/bash
location=`pwd`
#creating the reachability list containing the info about reachability of servers in the format [status] [ip]
#input - ip_list -> [ip]\n[ip]\n[ip]...
#ouput - ip_status_list -> [status] [ip]\n[status] [ip]....
while true; do
    `cat /dev/null > $location/ip_status_list`
    `cat /dev/null > $location/consolidated_health_check_scripts`
    while read line; do
        if [ "$line" != "" ]
            then 
            ip=`echo $line | awk '{print $1}'`
            ping -c 2 $ip
            if [ $? == 0 ]
            then
                    echo "y "$line >> $location/ip_status_list
            else
                    echo "n "$line >> $location/ip_status_list
            fi
        fi
    done < $location/ip_list

    #using the ip_status_list to create server dedicated health check script
    while read line; do
            ip=`echo $line | awk '{print $2}'`
            uname=`echo $line | awk '{print $3}'`
            password=`echo $line | awk '{print $4}'`

            var_status=`echo $line | awk '{print $1}'`
            if [ "$var_status" == "y" ]
            then
            #create a server dedicated health check file for the servers that are reachable
            #format [ip_address]_health_check
                `cat $location/server_health_template.sh > $location/${ip}_health_check`
                # cp $location/server_health_template.sh  $location/${ip}_health_check
                #   sed "s/IP_ADDRESS/$var_ip/" ${ip}_health_check
                #adding the script to the consolidated_health_check_scripts
                grep -q $ip  $location/consolidated_health_check_scripts  && echo "no" ||  echo "sshpass -p '$password' ssh -o StrictHostKeyChecking=no $uname@$ip  'bash -s' < $location/${ip}_health_check > $location/${ip}_details.json &">>$location/consolidated_health_check_scripts
            #empty the content of the server dedicated file for the "unreachable servers"
            elif [ "$var_status" == "n" ]
            then
                    `cat /dev/null >  $location/${ip}_health_check`
            fi
    done < $location/ip_status_list
    `chmod 777 *`
    `./consolidated_health_check_scripts`
    echo "consolidated_health_check_scripts is being run..."
    sleep 3
done

