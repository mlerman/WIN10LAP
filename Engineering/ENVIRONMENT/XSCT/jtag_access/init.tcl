puts "Running init.tcl"

puts "IRLEN is $env(IRLEN)"
set irlen $env(IRLEN)

source c:/UniServer/www/doc/files/Engineering/ENVIRONMENT/XSCT/xilib/xilib.tcl
puts "Connecting to HW_SERVER on $env(HW_SERVER_HOST)"
connect -host $env(HW_SERVER_HOST) -port 3121
puts "Setting target $env(TARGET_FILTER_NAME)"
targets -set -nocase -filter {name =~ "$env(TARGET_FILTER_NAME)"}



#puts "Setting jtag target $env(JTAG_TARGET)"
#jtag targets $env(JTAG_TARGET)

puts "Setting jtag target for $env(JTAG_TARGET_FILTER_NAME)"
jtag targets -set -filter {name == "$env(JTAG_TARGET_FILTER_NAME)"}




