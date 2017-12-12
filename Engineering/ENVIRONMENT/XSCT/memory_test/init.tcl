puts "Running init.tcl\nConnecting to HW_SERVER on $env(HW_SERVER_HOST)"
connect -host $env(HW_SERVER_HOST) -port 3121
puts "Setting target Cortex-A53*#0"
targets -set -nocase -filter {name =~ "Cortex-A53*#0"}




