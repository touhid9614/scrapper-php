/**
 * Linux SSH commands to get system information
 * Login in cPanel and run these commands from terminal.
 */

 CPU 			: cat /proc/cpuinfo | grep processor | wc -l
 RAM 			: cat /proc/meminfo
 Uptime 		: cat /proc/uptime
 Linux_version 	: cat /proc/version
 Full_system 	: lscpu
 RAM 			: free