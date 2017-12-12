puts "Running init.tcl"
connect -host $env(HW_SERVER_HOST) -port 3121
targets -set -nocase -filter {name =~ "Cortex-A53*#0"}




