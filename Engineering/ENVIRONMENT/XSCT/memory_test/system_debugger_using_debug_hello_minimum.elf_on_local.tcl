puts "testing launch script"
puts "connect..."
connect -url tcp:127.0.0.1:3121
puts "zynqmp_utils..."
source c:/Xilinx/SDK/2017.2/scripts/sdk/util/zynqmp_utils.tcl
puts "target..."
targets -set -nocase -filter {name =~"APU*" && jtag_cable_name =~ "Digilent JTAG-SMT2NC 210308A12403"} -index 1
#targets -set -nocase -filter {name =~ "$env(TARGET_SET_FILTER)"}

puts "loadhw system.hdf..."
loadhw -hw C:/UniServer/www/doc/files/Engineering/ENVIRONMENT/VIVADO/ZU3/project_1.sdk/design_1_wrapper_hw_platform_0/system.hdf -mem-ranges [list {0x80000000 0xbfffffff} {0x400000000 0x5ffffffff} {0x1000000000 0x7fffffffff}]
puts "configparams..."
configparams force-mem-access 1
puts "target..."
targets -set -nocase -filter {name =~"APU*" && jtag_cable_name =~ "Digilent JTAG-SMT2NC 210308A12403"} -index 1
#targets -set -nocase -filter {name =~ "$env(TARGET_SET_FILTER)"}

puts "psu_init..."
#source C:/UniServer/www/doc/files/Engineering/ENVIRONMENT/VIVADO/ZU3/project_1.sdk/design_1_wrapper_hw_platform_0/psu_init.tcl
# one line blocks, it's commented
source C:/UniServer/www/doc/files/Engineering/ENVIRONMENT/VIVADO/ZU3/project_1.sdk/design_1_wrapper_hw_platform_0/psu_init_no_psu_ddr_phybringup_data.tcl
psu_init
after 1000
puts "psu_ps_pl_isolation_removal..."
psu_ps_pl_isolation_removal
after 1000
puts "psu_ps_pl_reset_config..."
psu_ps_pl_reset_config
catch {psu_protection}
puts "target..."
#targets -set -nocase -filter {name =~"*A53*0" && jtag_cable_name =~ "Digilent JTAG-SMT2NC 210308A12403"} -index 1
targets -set -nocase -filter {name =~ "$env(TARGET_SET_FILTER)"}

puts "rst -processor..."
rst -processor
puts "dow hello_minimum.elf..."
dow C:/UniServer/www/doc/files/Engineering/ENVIRONMENT/VIVADO/ZU3/project_1.sdk/hello_minimum/Debug/hello_minimum.elf
puts "configparams..."
configparams force-mem-access 0
bpadd -addr &main
con
puts "done"

